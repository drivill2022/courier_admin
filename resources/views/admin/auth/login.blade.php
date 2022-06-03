@extends('admin.layouts.app')
@section('title', 'Login')
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
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to Drivill.</p>
                            </div>
                            @if(session('status'))
                            <div class="alert alert-success"> {{session('status')}}</div>
                            @endif
                            @if(Session::has('flash_error'))
                            <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              {{ Session::get('flash_error')}} 
                          </div>
                          @endif
                            <div class="p-2 mt-4">
                                <form action="{{ url('admin/login') }}" method='post'>
                                    {{csrf_field()}}
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" {{old('email')}}>
                                        @if ($errors->has('email'))
                                        <span class="help-block error">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" name="password" class="form-control" id="userpassword" placeholder="Enter password" {{old('password')}}>
                                        {{-- @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif --}}
                                    </div>

                                    <div class="form-check">
                                    	<div class="float-end">
                                            <a href="{{url('/admin/password/reset')}}" class="text-muted">Forgot password?</a>
                                        </div>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="form-check-input" id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                    </div>
                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log In</button>
                                    </div>


                                   {{--  <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="font-size-14 mb-3 title">Sign in with</h5>
                                        </div>


                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="" class="social-list-item bg-primary text-white border-primary">
                                                    <i class="mdi mdi-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="" class="social-list-item bg-info text-white border-info">
                                                    <i class="mdi mdi-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="" class="social-list-item bg-danger text-white border-danger">
                                                    <i class="mdi mdi-google"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Don't have an account ? <a href="signup.html" class="fw-medium text-primary"> Signup now </a> </p>
                                    </div> --}}
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
@endsection