<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Notifications\EmailVerificationNotification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required','regex:/^01[0125][0-9]{8}$/'],
            'profile_image' => ['required','mimes:jpeg,png,jpg,gif'], 
            // 'lat' => ['required','mimes:jpeg,png,jpg,gif'], 
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {        
        $profileImagePath = $data['profile_image']->store('image', 'public');
        $driveLicencePath = '';

        if(array_key_exists('drive_licence',$data)){
            $driveLicencePath = $data['drive_licence']->store('image', 'public');
        }
        
        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ,
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'lat' => $data['latitude'],
            'lng' => $data['longitude'],
            'profile_image' => $profileImagePath,
            'drive_licence' => $driveLicencePath,
        ]);


        $token = $user->createToken('user',['app:all'])->plainTextToken;
        $user->notify(new EmailVerificationNotification);

        return $user;
        // return response()->json([
        //     'status'    => 'success',
        //     'data'      => $user,
        //     'token'     => $token,
        // ]);


    }
}
