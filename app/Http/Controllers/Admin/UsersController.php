<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Users\UsersInterface;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $userRepository;

    public function __construct(UsersInterface $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function index()
    {
        if(!auth()->user()->hasPermissionTo('view-users')){
            return redirect('/home')->with('error','You don\'t have permission for this request');
        }

        $users = $this->userRepository->getByLocationAscending();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if(!auth()->user()->hasPermissionTo('create-users')){
            return redirect('/users')->with('success','Updated Successfully');
        }

        return view('admin.users.create');
    }

    public function edit($id)
    {
        if(!auth()->user()->hasPermissionTo('edit-users')){
            return redirect('/');
        }

        $user = User::find($id);
        return view('admin.users.edit',compact('user'));
    }

    public function update(UpdateUserRequest $request,$id)
    {
        if(!auth()->user()->hasPermissionTo('edit-users')){
            return redirect('/');
        }

        $user = $this->userRepository->update($request,$id);

        if($user->save()){
            return redirect('/users')->with('success','Updated Successfully');
        }else{
            return redirect()->back()->with('error','Error happened');
        }
    }

    public function store(StoreUserRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('create-users')){
            return redirect('/');
        }

        $user = $this->userRepository->store($request);
        if($user){
            return redirect()->route('users.index')->with('success','User has been Created Successfully');
        }
    }

    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-users')){
            return redirect('/');
        }

        $this->userRepository->delete($id);
        return redirect()->back()->with('success','Deleted Successfully');
    }

    public function toggleActivation($id)
    {
        if(!auth()->user()->hasPermissionTo('delete-users')){
            return redirect('/');
        }

        $user = User::find($id);
        $user->active = ! $user->active;
        $user->save();
        return redirect('/users')->with('success',$user->active ? 'Activated':'Diactivated' . " Successfully");
    }


    


}
