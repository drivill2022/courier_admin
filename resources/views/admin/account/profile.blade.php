@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between"> <h4 class="mb-0">Profile</h4> </div> </div> </div>
                        <!-- end page title -->
                        <div class="row mb-4">
                            <div class="col-xl-12">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="text-center">

                                            <div class="clearfix"></div>
                                            <div>
                                                <img src="{{img(Auth::guard('admin')->user()->picture)}}" class="avatar-lg rounded-circle img-thumbnail">
                                            </div>
                                            <h5 class="mt-3 mb-1">{{ucwords(Auth::guard('admin')->user()->name)}}</h5>
                                            <p class="text-muted">{{ucwords(Auth::guard('admin')->user()->role->name)}}</p>
                                        </div>

                                        <hr class="my-4">

                                        <div class="text-muted">
                                            <h5 class="font-size-16">About User</h5>
                                            
                                            <div class="table-responsive mt-4">
                                                <div>
                                                    <p class="mb-1">Name :</p>
                                                    <h5 class="font-size-16">{{ucwords(Auth::guard('admin')->user()->name)}}</h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-1">Mobile :</p>
                                                    <h5 class="font-size-16">{{trim(Auth::guard('admin')->user()->mobile)}}</h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-1">E-mail :</p>
                                                    <h5 class="font-size-16">{{trim(Auth::guard('admin')->user()->email)}}</h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-1">Address :</p>
                                                    <h5 class="font-size-16">{{trim(Auth::guard('admin')->user()->address)}}</h5>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="{{route('admin.edit.profile')}}">
                                                <button class="btn btn-primary">Edit Profile</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                @endsection