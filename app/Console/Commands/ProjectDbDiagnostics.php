<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class ProjectDbDiagnostics extends Command
{
    protected $signature = 'project:db-diagnostics {--json : Output machine-readable JSON}';
    protected $description = 'Inspect production database health and safe application metadata without modifying data';

    public function handle(): int
    {
        try {
            DB::connection()->getPdo();

            $tables = collect(Schema::getTables())
                ->map(fn (array $table) => $table['name'] ?? null)
                ->filter()
                ->values()
                ->all();

            $users = DB::table('users')->select(['id', 'username', 'role'])->orderBy('id')->get()
                ->map(fn (object $user): array => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                ])->all();

            $roleCounts = DB::table('users')
                ->select('role', DB::raw('COUNT(*) as count'))
                ->groupBy('role')
                ->orderBy('role')
                ->pluck('count', 'role')
                ->map(fn ($count): int => (int) $count)
                ->all();

            $data = [
                'application' => [
                    'environment' => app()->environment(),
                    'debug' => (bool) config('app.debug'),
                    'laravel' => app()->version(),
                ],
                'database' => [
                    'connection' => DB::getDefaultConnection(),
                    'driver' => DB::connection()->getDriverName(),
                    'status' => 'ok',
                    'tables' => $tables,
                    'migrations' => DB::table('migrations')->count(),
                ],
                'users' => [
                    'total' => count($users),
                    'roles' => $roleCounts,
                    'records' => $users,
                ],
                'content' => [
                    'startup_ideas' => Schema::hasTable('startup_ideas') ? DB::table('startup_ideas')->count() : null,
                    'manager_cheat_sheets' => Schema::hasTable('manager_cheat_sheets') ? DB::table('manager_cheat_sheets')->count() : null,
                ],
                'push' => [
                    'subscriptions' => Schema::hasTable('push_subscriptions') ? DB::table('push_subscriptions')->count() : null,
                    'linked_subscriptions' => Schema::hasTable('push_subscriptions')
                        ? DB::table('push_subscriptions')->whereNotNull('user_id')->count()
                        : null,
                    'vapid_configured' => filled(config('webpush.public_key')) && filled(config('webpush.private_key')),
                ],
            ];

            if ($this->option('json')) {
                $this->line(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                return self::SUCCESS;
            }

            $this->info('=== PROJECT DATABASE DIAGNOSTICS ===');
            $this->line('Environment: '.$data['application']['environment']);
            $this->line('Debug: '.($data['application']['debug'] ? 'ON' : 'OFF'));
            $this->line('Laravel: '.$data['application']['laravel']);
            $this->line('Database: '.$data['database']['driver'].' / '.$data['database']['status']);
            $this->line('Tables: '.implode(', ', $tables));
            $this->line('Migrations: '.$data['database']['migrations']);
            $this->line('Users: '.$data['users']['total']);
            foreach ($roleCounts as $role => $count) $this->line("  {$role}: {$count}");

            $this->newLine();
            $this->table(['ID', 'Username', 'Role'], array_map(
                fn (array $user): array => [$user['id'], $user['username'], $user['role']],
                $users,
            ));
            $this->line('Startup ideas: '.($data['content']['startup_ideas'] ?? 'n/a'));
            $this->line('Manager cheat sheets: '.($data['content']['manager_cheat_sheets'] ?? 'n/a'));
            $this->line('Push subscriptions: '.($data['push']['subscriptions'] ?? 'n/a'));
            $this->line('Linked push subscriptions: '.($data['push']['linked_subscriptions'] ?? 'n/a'));
            $this->line('VAPID configured: '.($data['push']['vapid_configured'] ? 'yes' : 'no'));

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error('Database diagnostics failed: '.$exception->getMessage());
            return self::FAILURE;
        }
    }
}
