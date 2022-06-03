@extends('admin.layouts.app')
@section('title', 'Forgot Password')
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
                    <form method="POST" action="{{ url('/admin/password/email') }}">
                        @csrf
                                   <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit"> {{ __('Send Password Reset Link') }}</button>
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

