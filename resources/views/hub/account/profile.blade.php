@extends('hub.layouts.main')
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
                                                <img src="{{img(Auth::guard('hub')->user()->picture)}}" class="avatar-lg rounded-circle img-thumbnail">
                                            </div>
                                            <h5 class="mt-3 mb-1">{{ucwords(Auth::guard('hub')->user()->name)}}</h5>
                                            <p class="text-muted">HUB: {{ucwords(Auth::guard('hub')->user()->hbsid)}}</p>
                                        </div>

                                        <hr class="my-4">

                                        <div class="text-muted">
                                            <h5 class="font-size-16">About Hub</h5>
                                            
                                            <div class="table-responsive mt-4">
                                                <div>
                                                    <p class="mb-1">Name:</p>
                                                    <h5 class="font-size-16">{{ucwords(Auth::guard('hub')->user()->name)}}</h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-1">Office Phone:</p>
                                                    <h5 class="font-size-16">{{trim(Auth::guard('hub')->user()->phone)}}</h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-1">E-mail:</p>
                                                    <h5 class="font-size-16">{{trim(Auth::guard('hub')->user()->email)}}</h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-1">Address:</p>
                                                    <h5 class="font-size-16">{{trim(Auth::guard('hub')->user()->address)}}</h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-1">Supervisor Name:</p>
                                                    <h5 class="font-size-16">{{ucwords(Auth::guard('hub')->user()->supervisor_name)}}</h5>
                                                </div> 
                                                <div class="mt-4">
                                                    <p class="mb-1">Supervisor Photo:</p>
                                                    <h5 class="font-size-16"> @if(Auth::guard('hub')->user()->sup_picture)
                                                            <img src="{{img(Auth::guard('hub')->user()->sup_picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                                        @endif</h5>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="mb-1">Supervisor Phone Number:</p>
                                                    <h5 class="font-size-16">{{ucwords(Auth::guard('hub')->user()->sup_phone)}}</h5>
                                                </div> 
                                                <div class="mt-4">
                                                    <p class="mb-1">Supervisor NID Number:</p>
                                                    <h5 class="font-size-16">{{ucwords(Auth::guard('hub')->user()->sup_nid_no)}}</h5>
                                                </div> 
                                                <div class="mt-4">
                                                    <p class="mb-1">Supervisor NID Photo:</p>
                                                    <h5 class="font-size-16">
                                                        @if(Auth::guard('hub')->user()->sup_nid_pic)
                                                            <img src="{{img(Auth::guard('hub')->user()->sup_nid_pic)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                                        @endif</h5>
                                                </div> 
                                                <div class="mt-4">
                                                    <p class="mb-1">Supervisor TIN Number:</p>
                                                    <h5 class="font-size-16">{{ucwords(Auth::guard('hub')->user()->sup_tin_no)}}</h5>
                                                </div> 
                                                <div class="mt-4">
                                                    <p class="mb-1">Supervisor TIN Photo:</p>
                                                    <h5 class="font-size-16">
                                                        @if(Auth::guard('hub')->user()->sup_tin_pic)
                                                            <img src="{{img(Auth::guard('hub')->user()->sup_tin_pic)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                                        @endif</h5>
                                                </div>

                                                <div class="mt-4">
                                                    <p class="mb-1">Trade licence photo:</p>
                                                    <h5 class="font-size-16">
                                                        @if(Auth::guard('hub')->user()->tl_picture)
                                                            <img src="{{img(Auth::guard('hub')->user()->tl_picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                                        @endif</h5>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="{{route('hub.edit.profile')}}">
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