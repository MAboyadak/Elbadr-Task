<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    use HttpResponse;
    

    public function login(LoginUserRequest $request){
        
        // $request->validated($request->all());

        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return $this->error('','Credentials don\'t match', 401);
        }

        $loggedUser = User::where('email',$request->email)->first(); 
        return $this->success([
            'user' => $loggedUser,
            'token' => $loggedUser->createToken('New Api Token')->plainTextToken,
        ]);

    }

    public function register(StoreUserRequest $request){
        
        // $request->validated($request->all());

        $profileImagePath = $request->profile_image->store('image', 'public');
        $driveLicencePath = '';

        if($request->drive_licence){
            $driveLicencePath = $request->drive_licence->store('image', 'public');
        }

        $newUser = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name ,
            'last_name' => $request->last_name,
            'email' => $request->email,
            // 'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'lat' => $request->latitude,
            'lng' => $request->longitude,
            'profile_image' => $profileImagePath,
            'drive_licence' => $driveLicencePath,
        ]);

        $newUser->notify(new EmailVerificationNotification);

        return $this->success([
            'user' => $newUser, 
            'token' => $newUser->createToken('API Token of ' . $newUser->name)->plainTextToken
        ]);

    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return $this->success([],'You Have Just Logged Out');
    }
}
