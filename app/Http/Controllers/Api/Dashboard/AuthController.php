<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Auth\LoginRequest;
use App\Models\Admin;
use App\Repositories\Eloquents\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{

    public function login(LoginRequest $request): JsonResponse
    {

        $admin = Admin::where( 'username', $request->username )->first();

        if ( !$admin->is_active ) return response()->json( [ 'message'=>'Account is not Activated' ], Response::HTTP_UNAUTHORIZED );

        $credentials = $request->only( [ 'username', 'password' ] );

        if (!auth( 'admin-api' )->attempt( $credentials ) ) {
            return response()->json( [ 'message'=>'Invalid Credentials' ], 401 );
        }

        $admin = Auth::guard('admin-api')->user();

        $token =  $admin->createToken(config('sanctum.jwt-secret'),['admin'])->plainTextToken;

        return response()->json( [
            'message' => 'Login Successfully',
            'token' => $token,
            'user' => auth( 'admin-api' )->user()
        ], Response::HTTP_OK );
    }


    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json( [
            'message' => 'Logout Successfully',
        ], Response::HTTP_OK );
    }

}
