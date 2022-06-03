@extends('merchant.layouts.app')
@section('title', 'Reset Password')
@section('content')
 <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{url('/')}}" class="mb-3 d-block auth-logo">
                            <img src="{{asset('public/backend/images/drivill/logo.png')}}" alt="" height="70" class="logo logo-dark">
                            <img src="{{asset('public/backend/images/drivill/logo.png')}}" alt="" height="70" class="logo logo-light">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4"> 
                            <div class="text-center mt-2">
                                <h5 class="text-primary">{{ __('Reset Password') }}</h5>
                            </div>
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif
                            @if(Session::has('flash_error'))
                            <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              {{ Session::get('flash_error')}} 
                          </div>
                          @endif
                            <div class="p-2 mt-4">
                    <form method="POST" action="{{ url('merchant/password/mobile/reset') }}">
                        @csrf
                                   <div class="mb-3">
                                        <label class="form-label" for="mobile">Mobile Number</label>
                                        <input id="mobile" type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $mobile ?? old('mobile') }}" required autocomplete="mobile" autofocus>

                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="{{url('/merchant/password/reset')}}" class="text-muted">Resend OTP</a>
                                        </div>
                                        <label for="otp" class="form-label">{{ __('OTP') }}</label>
                                       <input id="otp" type="number" class="form-control @error('otp') is-invalid @enderror" value="{{old('otp')}}" name="otp" required autocomplete="otp">

                                       @error('otp')
                                       <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">{{ __('Password') }}</label>
                                       <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                       @error('password')
                                       <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                    <div class="mb-3">
                                         <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                         <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>                                 
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
@endsection
