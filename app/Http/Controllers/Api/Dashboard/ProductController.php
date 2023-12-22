<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller {

   public ProductRepository $productRepository;
   function  __construct(ProductRepository $productRepository )
   {
    $this->productRepository = $productRepository;
   }

    public function store( StoreProductRequest $request) {
        
        


        $this->productRepository->create($request->validated());





        return response()->json( [
            'status'=>true,
            'message'=>'Product created',
            'data'=>[]
        ]);
    
    
    }

    public function index():JsonResponse {
        return response()->json( [
            'status'=>true,
            'message'=>'Product list',
            'data'=>[]
        ] );
    }

}
