<?php
namespace Tests\Feature\Api\Site;

use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use App\Models\UserType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'UserTypeSeeder']);  
        Artisan::call('db:seed', ['--class' => 'ProductSeeder']);
        $this->user = User::factory()->create();
    }


    public function test_user_can_list_products()
    {  
        $this->actingAs($this->user, 'user-api');
        $response = $this->getJson('/api/site/products');
        $response->assertStatus(200);
    }

    public function test_user_can_show_product()
    {  
        $this->actingAs($this->user, 'user-api');
        $response = $this->getJson('/api/site/products/'.Product::first()->id);
        $response->assertStatus(200);
    }
  
}
