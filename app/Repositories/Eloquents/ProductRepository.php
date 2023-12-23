<?php

namespace App\Repositories\Eloquents;

use App\Models\Product;
use App\Models\UserType;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquents\BaseRepository; 



class ProductRepository extends BaseRepository implements ProductRepositoryInterface {
    protected Product  $product;

    public function __construct() {
        $this->model = new \App\Models\Product();
    }

    public function  assignPricesToProduct( $productId, $prices ):Collection {
      $product =  $this->model->find( $productId )->prices()->createMany( [
            [
                'user_type_id'=> UserType::where( 'name', 'normal' )->first()->id,
                'price'=>$prices[ 'normal' ],
            ],
            [
                'user_type_id'=> UserType::where( 'name', 'silver' )->first()->id,
                'price'=>$prices[ 'silver' ]
            ],
            [
                'user_type_id'=> UserType::where( 'name', 'gold' )->first()->id,
                'price'=> $prices[ 'gold' ]
            ]
        ]);

      return $product;
    }

    public function updateProductPrices( $productId, $prices ):Model {
  
        $product = $this->model->find( $productId );
  
        foreach ( $prices as $key => $value ) {
            $product->prices()->where( 'user_type_id', UserType::where( 'name', $key )->first()->id )->update( [ 'price'=>$value ] );
        }

        return $product;
    }




}
