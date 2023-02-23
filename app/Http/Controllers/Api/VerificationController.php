<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use App\Traits\HttpResponse;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class VerificationController extends Controller
{

    use HttpResponse;


    private $_otp;

    public function __construct()
    {
        $this->_otp = new Otp();
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {

        $otp = $this->_otp->validate($request->email, $request->otp);
        // return $otp;
        $user = User::where('email',$request->email)->first();
        

        if(!$otp->status){
            
            return $this->error(
                null,
                'OTP Code is Expired',
                402);
        }
        
        $user->email_verified_at = now();
        $user->save();
        
        return $this->success(
            ['user' => $user],
            'Email has been verified successfully',
            200
        );
    }

    public function resendOtp()
    {
        $user = auth()->user();
        if(!$user){
            return $this->error(
                null,
                'You are not authenticated',
                401
            );
        }

        $user->notify(new EmailVerificationNotification());
        
        return $this->success(
            null,
            'OTP Code has been resent to your Email',
            200
        );
    }
}
