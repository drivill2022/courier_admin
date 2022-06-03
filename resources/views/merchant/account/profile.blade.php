@extends('merchant.layouts.main')
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
                                        <img src="{{img(Auth::guard('merchant')->user()->picture)}}" class="avatar-lg rounded-circle img-thumbnail">
                                    </div>
                                    <h5 class="mt-3 mb-1">{{ucwords(Auth::guard('merchant')->user()->name)}}</h5>
                                    <p>Merchant: {{strtoupper(Auth::guard('merchant')->user()->mrid)}}</p>
                                </div>
                                <hr class="my-4">
                                <div class="text-muted">
                                    <h5 class="font-size-16">About Merchant</h5>

                                    <div class="table-responsive mt-4">
                                        <div>
                                            <p class="mb-1">Name:</p>
                                            <h5 class="font-size-16">{{ucwords(Auth::guard('merchant')->user()->name)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Mobile:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('merchant')->user()->mobile)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">E-mail:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('merchant')->user()->email)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">NID Number:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('merchant')->user()->email)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Address:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('merchant')->user()->address)}}</h5>
                                        </div>


                                        <div class="mt-4">
                                            <p class="mb-1">Business Logo:</p>
                                            <img src="{{img(Auth::guard('merchant')->user()->business_logo)}}" class="avatar-lg rounded-circle img-thumbnail">
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Business Name:</p>
                                           <h5 class="font-size-16">{{trim(Auth::guard('merchant')->user()->buss_name)}}</h5>
                                        </div>
                                         <div class="mt-4">
                                            <p class="mb-1">Business Address:</p>
                                           <h5 class="font-size-16">{{trim(Auth::guard('merchant')->user()->buss_address)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Trade License Photo:</p>
                                            <img src="{{img(Auth::guard('merchant')->user()->trade_lic_no)}}" class="avatar-lg rounded-circle img-thumbnail">
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Facebook Page:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('merchant')->user()->fb_page)}}</h5>
                                        </div>
                                         <div class="mt-4">
                                            <p class="mb-1">Payment Method:</p>
                                            <h5 class="font-size-16">{{Auth::guard('merchant')->user()->pmethod?Auth::guard('merchant')->user()->pmethod->name:''}}</h5>
                                        </div> 
                                        <div class="mt-4">
                                            <p class="mb-1">Product Types:</p>
                                            <h5 class="font-size-16">{{Auth::guard('merchant')->user()->product_type_names}}</h5>
                                        </div>
                                         
                                       
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{route('merchant.edit.profile')}}">
                                        <button class="btn btn-primary">Edit Profile</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div> <!-- End Page-content -->
        @endsection