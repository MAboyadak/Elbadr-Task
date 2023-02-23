@extends('layouts.app')

@section('content')
<div class="card-style mb-30">
    
    @if(session('success'))
        <div class="bg-success text-white p-2 m-2">{{session('success')}}</div>
    @endif

    @if(session('error'))
        <div class="bg-success text-white p-2 m-2">{{session('error')}}</div>
    @endif

    <div class="card-header">
        <div class="card-title d-flex justify-content-between">
            <h3>User List</h3>
            <a class="btn btn-primary float-right" href="{{route('users.create')}}">+ New User</a>
        </div>
    </div>
    <hr>

    <div class="table-wrapper table-responsive">
      <table class="table">
        <thead>
          <tr class="text-center">
            <th>Profile Image</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Role</th>
            <th>Drive Licence</th>
            @canany(['edit-users', 'delete-users'])
                <th>Action</th>                
            @endcanany
          </tr>
          <!-- end table row-->
        </thead>

        <tbody>
            @foreach ($users as $user)
            @if ($user->hasRole('admin'))
                <?php continue;?>
            @endif
                <tr class="text-center">
                    <td class="min-width">
                        <div class="lead">
                            <div class="lead-image">
                                <img src='{{asset("storage/$user->profile_image")}}' alt=""/>
                            </div>
                        </div>
                    </td>
                    <td class="min-width">
                        {{$user->first_name . ' '}} {{$user->middle_name ?  $user->middle_name . ' ' :''}} {{$user->last_name}}
                    </td>
                    <td class="min-width">
                        {{$user->email}}
                    </td>
                    <td class="min-width">
                        {{$user->phone}}
                    </td>
                    <td class="min-width">
                        {{$user->distance ? round($user->distance,2) . ' km' : '0'}}
                    </td>
                    <td class="min-width">
                        {{$user->hasRole('user') ? 'User' : 'Client'}}
                    </td>
                    <td class="min-width">
                        @if ($user->drive_licence)
                            <div class="lead">
                                <div class="lead-image">
                                    <img src='{{asset("storage/$user->drive_licence")}}' alt=""/>
                                </div>
                            </div>
                        @endif
                        {{-- <img src="assets/images/lead/lead-1.png" alt=""/> --}}
                    </td>
                    
                    <td class="min-width">
                        @can('edit-users')
                            <a href="{{route('users.edit',$user->id)}}" class="btn btn-warning text-white">Edit</a>
                        @endcan
                        @can('delete-users')
                            <a href="{{route('toggle-activation',$user->id)}}" class="btn btn-secondary text-white">{{$user->active? 'Deactivate':'Activate'}}</a>
                            <form class="d-inline" action="{{route('users.destroy',$user->id)}}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger text-white">Delete</button>
                            </form>                            
                        @endcan
                    </td>
                </tr>
                <!-- end table row -->
            @endforeach

        </tbody>

      </table>
      <!-- end table -->

    </div>
  </div>
@endsection