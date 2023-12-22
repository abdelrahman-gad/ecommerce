<?php

namespace  App\Services;

use App\Models\Otp;
use Exception;
use Illuminate\Support\Facades\Log;

class TwilioOtpService {

    public function generateOtp():string {
        $otp = rand( 10000, 999999 );
        $existingOtp = Otp::where( 'code', $otp )->first();
        if ( isset( $existingOtp ) ) return $this->generateOtp();
        return $otp;
    }

    public function sendOtp( $phone, $otp ):bool {
        $sid = config( 'services.twilio.sid' );
        $token = config( 'services.twilio.token' );
        $from = config( 'services.twilio.from' );

        $client = new \Twilio\Rest\Client( $sid, $token );

        $message = 'Your Otp is '. $otp;

        try {
            $client->messages->create(
                $phone,
                [
                    'from' => $from,
                    'body' => $message
                ]
            );
            return true;
        } catch( Exception $e ) {
            $message =   $e->getMessage();
            Log::info( 'Error Sending Otp: '.$message );
            return false;
        }
    }

}
