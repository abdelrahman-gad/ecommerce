<?php
namespace Tests\Feature\Api\Dashboard;

use App\Models\Admin;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class ProductApiTest extends TestCase
 {
    use RefreshDatabase;

    protected $admin;

    function setUp(): void
    {
        parent::setUp();
        Artisan::call( 'db:seed', [ '--class' => 'UserTypeSeeder' ] );
        $this->admin = Admin::factory()->create();
    }

    

    public function test_admin_can_list_products(){
            
            $this->actingAs( $this->admin, 'admin-api' );
            $response = $this->getJson( '/api/dashboard/products' );
            $response->assertStatus( 200 );        
    }

    public function  test_admin_can_show_product(){
            Artisan::call( 'db:seed', [ '--class' => 'ProductSeeder' ] );
            $this->actingAs( $this->admin, 'admin-api' );
            $response = $this->getJson( '/api/dashboard/products/'.Product::first()->id );
            $response->assertStatus( 200 );        
    }

    public function test_admin_can_create_product(){

        $this->actingAs( $this->admin, 'admin-api' );
        $response = $this->postJson( '/api/dashboard/products', [
            'name' => 'product name',
            'description' => 'product description',
            'slug' => 'product slug',
            'is_active'=>true,
            'price'=>[
                'normal'=>100,
                'silver'=>90,
                'gold'=>80
            ]

        ] );

        $response->assertStatus( 201 );        
    }

    public function test_admin_can_update_product(){
            

            Artisan::call( 'db:seed', [ '--class' => 'ProductSeeder' ]);
            $this->actingAs( $this->admin, 'admin-api' );
            $response = $this->postJson( '/api/dashboard/products-update', [
                'name' => 'product name',
                'description' => 'product description',
                'slug' => 'product slug',
                'is_active'=>true,
                'id'=> Product::first()->id,
                'price'=>[
                    'normal'=>100,
                    'silver'=>90,
                    'gold'=>80
                ]
    
            ] );
            $response->assertStatus( 200 );        
    }

    public function test_admin_can_delete_product(){
            Artisan::call( 'db:seed', [ '--class' => 'ProductSeeder' ]);
            $this->actingAs( $this->admin, 'admin-api' );
            $response = $this->deleteJson( '/api/dashboard/products/'.Product::first()->id );
            $response->assertStatus( 200 );        
    }

}