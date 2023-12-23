<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Product\StoreProductRequest;
use App\Http\Requests\Api\Dashboard\Product\UpdateProductRequest;
use App\Http\Resources\Dashboard\ProductResource;
use App\Repositories\Eloquents\ProductRepository;
use App\Traits\FileStorageHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        try {
            DB::beginTransaction();
            $image = null;
            if ( $request->hasFile( 'image' ) ) {
                $image = $this->storeFile( $request->image );
            }

            $productReq = [
                'name'=>$request->name,
                'description'=>$request->description,
                'slug'=>$request->slug,
                'is_active'=>$request->is_active,
                'image'=> $image ?? null ,
            ];

            $product = $this->productRepository->create( $productReq );

            $this->productRepository->assignPricesToProduct( $product->id, $request->price );

            DB::commit();
            return (new ProductResource($product))->response(); 
        } catch (\Exception $e) {
            Log::info("message: ".$e->getMessage()." file: ".$e->getFile()." line: ".$e->getLine()." trace: ".$e->getTraceAsString()."");
            DB::rollBack();
            return response()->json([
                'message'=>'Something went wrong'
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function update(UpdateProductRequest $request):JsonResponse{

        try{
            DB::beginTransaction();
            $image = null;
            if ( $request->hasFile( 'image' ) ) {
                $image = $this->storeFile( $request->image );
            }

            $productReq = [
                'name'=>$request->name,
                'description'=>$request->description,
                'slug'=>$request->slug,
                'is_active'=>$request->is_active,
                'image'=> $image ?? null ,
            ];

            $this->productRepository->update( $productReq, $request->id );

            $this->productRepository->updateProductPrices( $request->id, $request->price );

            DB::commit();
            $product = $this->productRepository->find($request->id);
            return (new ProductResource($product))->response();
        }catch(\Exception $e){
            Log::info("message: ".$e->getMessage()." file: ".$e->getFile()." line: ".$e->getLine()." trace: ".$e->getTraceAsString()."");
            DB::rollBack();
            return response()->json([
                'message'=>'Something went wrong'
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $id){
        $this->productRepository->delete($id);
        return response()->json([
            'message'=>'Product deleted successfully'
        ],Response::HTTP_OK);

    }



   

}
