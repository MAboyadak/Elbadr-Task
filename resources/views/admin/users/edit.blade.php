@extends('layouts.app')

@section('content')
<div class="card-style mb-30">
    <div class="card-header">
        <h3 class="card-title">Update User</h3>
    </div>
    <hr>
    <div class="card-body">
        
        @if(session('error'))
            <div class="bg-success text-white p-2">{{session('error')}}</div>
        @endif

        <form method="POST" action="{{ route('users.update',$user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                <div class="col-md-6">
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}" >

                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="middle_name" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }}</label>

                <div class="col-md-6">
                    <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ $user->middle_name }}" >

                    @error('middle_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                <div class="col-md-6">
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" >

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

                <div class="col-md-6">
                    <input id="phone" type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" autocomplete="phone" value="{{ $user->phone }}">

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
            </div>

            <div class="row mb-3">
                <label for="profile_image" class="col-md-4 col-form-label text-md-end">{{ __('Profile Image') }}</label>

                <div class="col-md-6">
                    <input id="profile_image" name="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" >

                    @error('profile_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="drive_licence" class="col-md-4 col-form-label text-md-end">{{ __('Drive License') }}</label>

                <div class="col-md-6">
                    <input id="drive_licence" name="drive_licence" type="file" class="form-control @error('drive_licence') is-invalid @enderror" >

                    @error('drive_licence')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <input id="latitude" type="hidden" class="form-control" name="latitude" value="{{ $user->lat }}" >
            <input id="longitude" type="hidden" class="form-control" name="longitude" value="{{ $user->lng }}" >

            <div class="row mb-3">
                <label for="pac-input" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

                <div class="col-md-6">
                    <input type="text" name="pac-input" id="pac-input"  class="form-control" placeholder="Choose Location">
                </div>
            </div>
            

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
    
</div>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=places&callback=Function.prototype&language=ar&region=EG"></script>
    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize(){
            var input = document.getElementById('pac-input');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
            });
        }        
    </script>
@endsection