<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    private $_otp;

    public function __construct()
    {
        $this->_otp = new Otp();
    }


    public function show()
    {
        $user = auth()->user();
        return view('auth.verify',compact('user'));
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        // var_dump($request->email);
        // var_dump($request->otp);

        $otp = $this->_otp->validate($request->email, $request->otp);
        $user = User::where('email',$request->email)->first();
        

        if(!$otp->status){
            return view('auth.verify',compact('user'))->with('error','Code is expired');
        }
        
        $user->email_verified_at = now();
        $user->save();
        
        // return response()->json(['success'=>true], 200);
        return view('auth.verify',compact('user'));
    }

    public function resendOtp()
    {
        auth()->user()->notify(new EmailVerificationNotification());
        return view('auth.verify',compact('user'));
    }
}
