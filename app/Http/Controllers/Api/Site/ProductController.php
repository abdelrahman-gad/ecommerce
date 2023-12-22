<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\Site\ProductResource;
use App\Repositories\Eloquents\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public ProductRepository $productRepository;

    function  __construct( ProductRepository $productRepository ) {
        $this->productRepository = $productRepository;
    }

    public function index( Request $request ):JsonResponse{

        $perPage = $request->perPage ?? 10;
        
        $user = Auth::user()->with(['type'])->first();
     
        $userType = $user->type;

        $user_type_id =  $userType->id;

        $products = $this->productRepository->whereColumns(['is_active'=>true])
                        ->with(['prices'=>function($q) use ($user_type_id){
                            $q->where('user_type_id', $user_type_id);
        }])->paginate( $perPage );

        return  ProductResource::collection( $products )->response();
    }

    public function show($id):JsonResponse{

        $product = $this->productRepository->whereColumns(['is_active'=>true])
        ->with(['prices'=>function($q){
            $q->with('userTypes');
        }])->findorFail($id);

        return (new ProductResource($product))->response();
    }

}
