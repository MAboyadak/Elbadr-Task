@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($user->email_verified_at)
                        <div class="alert alert-success" role="alert">
                            {{ __('Your email address has been verified.') }}
                        </div>
                    @else                    
                    
                        <form class="text-center justify-content-center" method="POST" action="{{ route('verify.update') }}">
                            @csrf
                            <input type="text" class="form-control" placeholder="Enter the code here .." name="otp" >
                            <input type="hidden" name="email" value="{{$user->email}}" id="">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <button type="submit" class="btn btn-primary mt-3">{{ __('Submit') }}</button>
                        </form>

                        <form class="d-inline" method="POST" action="{{ route('verify.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
