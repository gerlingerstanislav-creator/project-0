<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class CheckIpController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('CheckIp');
    }

    public function lookup(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ip' => ['required', 'ip'],
        ]);

        $ip = $validated['ip'];
        $isPublic = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false;
        $version = str_contains($ip, ':') ? 6 : 4;
        $ptr = gethostbyaddr($ip);
        $ptr = $ptr !== false && $ptr !== $ip ? $ptr : null;

        $result = [
            'ip' => $ip,
            'version' => 'IPv'.$version,
            'scope' => $isPublic ? 'public' : 'private / reserved',
            'ptr' => $ptr,
            'binary' => $this->binary($ip),
            'hex' => bin2hex(inet_pton($ip)),
            'decimal' => $version === 4 ? sprintf('%u', ip2long($ip)) : null,
            'rdap' => null,
            'rdap_error' => null,
        ];

        if ($isPublic) {
            try {
                $response = Http::acceptJson()
                    ->timeout(6)
                    ->retry(2, 150, throw: false)
                    ->get('https://rdap.org/ip/'.rawurlencode($ip));

                if ($response->successful()) {
                    $rdap = $response->json();
                    $result['rdap'] = [
                        'name' => $rdap['name'] ?? null,
                        'handle' => $rdap['handle'] ?? null,
                        'type' => $rdap['type'] ?? null,
                        'startAddress' => $rdap['startAddress'] ?? null,
                        'endAddress' => $rdap['endAddress'] ?? null,
                        'country' => $rdap['country'] ?? null,
                        'parentHandle' => $rdap['parentHandle'] ?? null,
                        'port43' => $rdap['port43'] ?? null,
                        'status' => $rdap['status'] ?? [],
                        'events' => $rdap['events'] ?? [],
                        'entities' => $this->entities($rdap['entities'] ?? []),
                        'links' => $rdap['links'] ?? [],
                        'raw' => $rdap,
                    ];
                } else {
                    $result['rdap_error'] = 'RDAP returned HTTP '.$response->status().'.';
                }
            } catch (Throwable) {
                $result['rdap_error'] = 'RDAP is temporarily unavailable.';
            }
        } else {
            $result['rdap_error'] = 'RDAP lookup is skipped for private or reserved addresses.';
        }

        return response()->json($result);
    }

    private function binary(string $ip): string
    {
        $packed = inet_pton($ip);
        if ($packed === false) {
            return '';
        }

        return implode(' ', array_map(
            static fn (string $byte): string => str_pad(decbin(ord($byte)), 8, '0', STR_PAD_LEFT),
            str_split($packed)
        ));
    }

    private function entities(array $entities): array
    {
        return array_map(static function (array $entity): array {
            $vcard = [];
            foreach ($entity['vcardArray'][1] ?? [] as $field) {
                if (is_array($field) && isset($field[0], $field[3]) && is_string($field[0]) && (is_string($field[3]) || is_numeric($field[3]))) {
                    $vcard[$field[0]][] = (string) $field[3];
                }
            }

            return [
                'handle' => $entity['handle'] ?? null,
                'roles' => $entity['roles'] ?? [],
                'name' => $vcard['fn'][0] ?? null,
                'email' => $vcard['email'][0] ?? null,
                'phone' => $vcard['tel'][0] ?? null,
            ];
        }, $entities);
    }
}
