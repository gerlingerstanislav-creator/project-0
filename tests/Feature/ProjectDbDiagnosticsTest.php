<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProjectDbDiagnosticsTest extends TestCase
{
    public function test_database_diagnostics_returns_safe_database_metadata(): void
    {
        foreach ([
            ['admin', 'admin'],
            ['moderator', 'moderator'],
            ['user', 'user'],
        ] as [$username, $role]) {
            User::create([
                'username' => $username,
                'role' => $role,
                'password' => Hash::make('secret'),
            ]);
        }

        $exitCode = Artisan::call('project:db-diagnostics', ['--json' => true]);
        $data = json_decode(Artisan::output(), true, flags: JSON_THROW_ON_ERROR);

        $this->assertSame(0, $exitCode);
        $this->assertSame('testing', $data['application']['environment']);
        $this->assertSame('ok', $data['database']['status']);
        $this->assertSame(3, $data['users']['total']);
        $this->assertSame(1, $data['users']['roles']['admin']);
        $this->assertSame(1, $data['users']['roles']['moderator']);
        $this->assertSame(1, $data['users']['roles']['user']);
        $this->assertCount(3, $data['users']['records']);
        $this->assertArrayNotHasKey('password', $data['users']['records'][0]);
        $this->assertArrayNotHasKey('remember_token', $data['users']['records'][0]);
    }
}
