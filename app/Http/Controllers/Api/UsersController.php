<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Users\UsersInterface;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    use HttpResponse;


    private $userRepository;

    public function __construct(UsersInterface $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    private function noPermission()
    {
        return response()->json([
            'status'    =>  'error',
            'message'   =>  'You don\'t have permission for this request'
        ],401);
    }

    public function index()
    {
        if(!auth()->user()->hasPermissionTo('view-users')){
            return $this->noPermission();
        }

        $users = $this->userRepository->getByLocationAscending();
        return response()->json([
            'users'=> $users
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('create-users')){
            return $this->noPermission();
        }

        $user = $this->userRepository->store($request);
        if($user){
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('New Api Token')->plainTextToken,
            ],'User Created Successfully',200);
        }
    }

    public function update(UpdateUserRequest $request,$id)
    {
        if(!auth()->user()->hasPermissionTo('edit-users')){
            return $this->noPermission();
        }

        $user = $this->userRepository->update($request,$id);
        
        if(!$user){
            return $this->error(
                [],
                'No Such User in Database',
                200
            );
        }

        if($user->save()){
            if($user){
                return $this->success(
                ['user' => $user,],
                'User Updated Successfully',
                200);
            }
        }else{
            return $this->error(
            ['user' => $user,],
            'Error happened in storing to database',
            402);
        }
    }

    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-users')){
            return $this->noPermission();
        }

        if($this->userRepository->delete($id)){
            return $this->success(
                [],
                'User Deleted Successfully',
                200);
        }else{

        }
        return $this->error(
            [],
            'No Such User in Database',
            200);
    }



    


}
