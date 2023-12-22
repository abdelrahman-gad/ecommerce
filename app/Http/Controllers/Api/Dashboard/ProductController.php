<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index():JsonResponse
    {
     return response()->json([
         'status'=>true,
         'message'=>'Product list',
         'data'=>[]
     ]);
    }

    // public function store(Store ){

    // }


}
