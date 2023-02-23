<?php 

namespace App\Repositories\Users;

use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Hash;

class UsersRepository implements UsersInterface
{
    function all(){
        return User::all();
    }

    function getByLocationAscending()
    {
        $user = User::find(auth()->id());
        $longitude = $user->lng;
        $latitude = $user->lat;


        $haversine = "(
            6371 * acos(
                cos(radians(?))
                * cos(radians(`lat`))
                * cos(radians(`lng`) - radians(?))
                + sin(radians(?)) * sin(radians(`lat`))
            )
        )";

        // $users = $this->userRepository->all();
        $users = User::select('*')
                ->selectRaw("$haversine AS distance",[$latitude, $longitude, $latitude])
                // ->having("distance", "<=", $distance)
                ->orderby("distance", "asc")
                ->get();

        return $users;
    }
    
    function store($data){
        $profileImagePath = $data['profile_image']->store('image', 'public');
        $driveLicencePath = '';

        if(array_key_exists('drive_licence',$data->all())){
            $driveLicencePath = $data['drive_licence']->store('image', 'public');
        }
        
        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ,
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'lat' => $data['latitude'],
            'lng' => $data['longitude'],
            'profile_image' => $profileImagePath,
            'drive_licence' => $driveLicencePath,
        ]);


        // $token = $user->createToken('user',['app:all'])->plainTextToken;
        // $user->notify(new EmailVerificationNotification);

        return $user;
    }

    function update($request, $id){
        $user = User::find($id);
        if(!$user){
            return false;
        }
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        
        if($request->file('profile_image')){
            $image_path = $request->file('profile_image')->store('image', 'public');
            $user->profile_image = $image_path;
        }

        if($request->file('drive_licence')){
            $image_path = $request->file('drive_licence')->store('image', 'public');
            $user->drive_licence = $image_path;
        }

        if($request->latitude){
            $user->lat = $request->latitude;
            $user->lng = $request->longitude;
        }
        
        return $user;
    }

    function delete($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return true;
        }
        return false;
    }
}