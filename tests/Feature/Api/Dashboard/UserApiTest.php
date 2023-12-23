<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserApiTest extends TestCase
{
 
    use RefreshDatabase;

    protected $admin;

    function setUp(): void
    {
        parent::setUp();
        $this->admin = \App\Models\Admin::factory()->create();
        Artisan::call( 'db:seed', [ '--class' => 'UserTypeSeeder' ] );
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
    }


    public function test_admin_can_list_users(): void
    {
        $this->actingAs($this->admin, 'admin-api');

        $response = $this->getJson('/api/dashboard/users');
        $response->assertStatus(200);
    }

    public function test_admin_can_show_user(): void
    { 
       $user = User::where('is_active', true)->first();
  
       
       $this->actingAs($this->admin, 'admin-api');
        $response = $this->getJson('/api/dashboard/users/'.$user->id);
        $response->assertStatus(200);
    }

    public function test_admin_can_create_user(): void
    {
        $this->actingAs($this->admin, 'admin-api');
        $fakePassword  = fake()->password;
        $response = $this->postJson('/api/dashboard/users', [
            'username' => fake()->username,
            'mobile' => fake()->phoneNumber,
            'password' =>  $fakePassword,
            'password_confirmation' => $fakePassword,
            'type_id' => UserType::where('name', 'normal')->first()->id,
        ]);

        $response->assertStatus(201);
    }

    public function test_admin_can_list_user_types(){
        $this->actingAs($this->admin, 'admin-api');
        $response = $this->getJson('/api/dashboard/user-types');
        $response->assertStatus(200);
    }
    
    public function test_admin_can_update_user(){

        $user = User::factory()->create();

        $this->actingAs($this->admin, 'admin-api');
        $response = $this->postJson('/api/dashboard/users-update',[
            'id' => $user->id,
            'username' => fake()->username,
            'mobile' => fake()->phoneNumber,
            'type_id' => UserType::where('name', 'normal')->first()->id,
        ]);

        $response->assertStatus(200);
    }

    public function test_admin_can_delete_user(){
        $user = User::factory()->create();
        $this->actingAs($this->admin, 'admin-api');
        $response = $this->deleteJson('/api/dashboard/users/'.$user->id);
        $response->assertStatus(200);
    }
}
