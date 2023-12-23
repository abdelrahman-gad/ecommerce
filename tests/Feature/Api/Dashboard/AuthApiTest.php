<?php

namespace Tests\Feature\Api\Dashboard;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {

        parent::setUp();
        Artisan::call( 'db:seed', [ '--class' => 'AdminSeeder' ] );
    }

    public function test_admin_can_login()
    {
    
        $admin = Admin::where('is_active', true)->first();

        $response = $this->postJson('/api/dashboard/login', [
            'username' => $admin->username,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }
    
}
