<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\LoginRequest;
use App\Http\Requests\Api\Site\RegisterRequest;
use App\Http\Requests\Api\Site\VerifyAccountRequest;
use App\Models\Otp;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\TwilioOtpService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller {

    protected TwilioOtpService  $twilioOtpService;
    protected UserRepository $userRepository;

    public function __construct(
        TwilioOtpService $twilioOtpService,
        UserRepository $userRepository

        ) {
        $this->twilioOtpService = $twilioOtpService;
        $this->userRepository = $userRepository;
    }

    public function login( LoginRequest $request ): \Illuminate\Http\JsonResponse {

        $user = User::where( 'username', $request->username )->first();

        if ( !$user->is_active ) return response()->json( [ 'message'=>'Account is not Activated' ], Response::HTTP_UNAUTHORIZED );

        $credentials = $request->only( [ 'username', 'password' ] );

        if ( !$token = auth( 'user-api' )->attempt( $credentials ) ) {
            return response()->json( [ 'message'=>'Invalid Credentials' ], 401 );
        }

        return response()->json( [
            'message' => 'Login Successfully',
            'token' => $token,
            'user' => auth( 'user-api' )->user()
        ], Response::HTTP_OK );
    }

    public function register( RegisterRequest $request ): \Illuminate\Http\JsonResponse {

        $user = User::create( [
            'name'=> $request->name,
            'username'=> $request->username,
            'mobile' => $request->mobile,
            'password'=> Hash::make( $request->password ),
        ]);

        $otpCode = $this->twilioOtpService->generateOtp();

        Otp::create( [
            'user_id'=> $user->id,
            'code'=> $otpCode,
            'expire_at'=> now()->addMinutes( 5 )
        ] );

        if ( $this->twilioOtpService->sendOtp( $request->mobile, $otpCode ) ) {
            return response()->json( [
                'message'=> 'Otp Sent Successfully'
            ], Response::HTTP_OK );
        } else {
            return response()->json( [
                'message' => 'Error Sending Otp'
            ], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    public function verifyAccount( VerifyAccountRequest $request ): \Illuminate\Http\JsonResponse {

        $otp = Otp::where( 'code', $request->code )->where( 'expire_at', '>', now() )->first();

        if ( !$otp ) {
            return response()->json( [
                'message' => 'Invalid Otp'
            ], Response::HTTP_UNPROCESSABLE_ENTITY );
        }

        $user = User::where( 'id', $otp->user_id )->first();

        if ( !$user ) {
            return response()->json( [
                'message' => 'User Not Found'
            ], Response::HTTP_UNPROCESSABLE_ENTITY );
        }

        $user->update( [
            'mobile_verified_at' => now(),
            'is_active' => true
        ] );

        $otp->delete();

        return response()->json( [
            'message' => 'Account Verified Successfully'
        ], Response::HTTP_OK );
    }


    public function resendOtp( Request $request ): \Illuminate\Http\JsonResponse {

        $user = User::where( 'mobile', $request->mobile )->first();

        if ( !$user ) {
            return response()->json( [
                'message' => 'User Not Found'
            ], Response::HTTP_UNPROCESSABLE_ENTITY );
        }

        $otpCode = $this->twilioOtpService->generateOtp();

        Otp::create( [
            'user_id'=> $user->id,
            'code'=> $otpCode,
            'expire_at'=> now()->addMinutes( 5 )
        ] );

        if ( $this->twilioOtpService->sendOtp( $request->mobile, $otpCode ) ) {
            return response()->json( [
                'message'=> 'Otp Sent Successfully'
            ], Response::HTTP_OK );
        } else {
            return response()->json( [
                'message' => 'Error Sending Otp'
            ], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }


}
