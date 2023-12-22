<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreProductRequest;
use App\Http\Requests\Api\Dashboard\UpdateProductRequest;
use App\Http\Resources\Dashboard\ProductResource;
use App\Repositories\Eloquents\ProductRepository;
use App\Traits\FileStorageHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller {

    use FileStorageHandler;

    public ProductRepository $productRepository;

    function  __construct( ProductRepository $productRepository ) {
        $this->productRepository = $productRepository;
    }

    public function index( Request $request ):JsonResponse{

        $perPage = $request->perPage ?? 10;
        
        $products = $this->productRepository
                  ->with(['prices'=>function($q){
            $q->with('userTypes');
        }])->paginate( $perPage );

        return  ProductResource::collection( $products )->response();
    }

    public function show($id):JsonResponse{

        $product = $this->productRepository->where('is_active',1)->with(['prices'=>function($q){
            $q->with('userTypes');
        }])->find($id);

        return (new ProductResource($product))->response();
    }

    public function store( StoreProductRequest $request ) {

        if ( $request->hasFile( 'image' ) ) {
            $image = $this->storeFile( $request->image );
        }

        $productReq = [
            'name'=>$request->name,
            'description'=>$request->description,
            'slug'=>$request->slug,
            'is_active'=>$request->is_active,
            'image'=>$image,
        ];

        $product = $this->productRepository->create( $productReq );

        $this->productRepository->assignPricesToProduct( $product->id, $request->price );

        return (new ProductResource($product))->response(); 

    }


    public function update(UpdateProductRequest $request):JsonResponse{

        if ( $request->hasFile( 'image' ) ) {
            $image = $this->storeFile( $request->image );
            $request->merge(['image'=>$image]);
        }

        if($request->has('price')){
            $this->productRepository->updateProductPrices( $request->id, $request->price );
        }

        $productData = $request->except(['price']);

        $this->productRepository->update($productData,$request->id);

        $product = $this->productRepository->find($request->id);

        return (new ProductResource($product))->response();
    }

    public function destroy(string $id){
        $this->productRepository->delete($id);
        return response()->json([
            'message'=>'Product deleted successfully'
        ],Response::HTTP_OK);

    }



   

}
