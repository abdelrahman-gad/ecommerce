<?php

namespace Tests\Feature\Feature\Api\Site;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

   

    function setUp(): void
    {
        parent::setUp();
        Artisan::call( 'db:seed', [ '--class' => 'UserTypeSeeder' ] );
        Artisan::call( 'db:seed', [ '--class' => 'UserSeeder' ] );
    }

    public function test_user_can_login()
    {
        $user = User::where('is_active', true)->first();

        $response = $this->postJson( '/api/site/login', [
            'username' => $user->username,
            'password' => 'password',
          ] );

        $response->assertStatus( 200 );
    }
   

}
