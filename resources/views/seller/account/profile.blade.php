@extends('seller.layouts.main')
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
                                        <img src="{{img(Auth::guard('seller')->user()->picture)}}" class="avatar-lg rounded-circle img-thumbnail">
                                    </div>
                                    <h5 class="mt-3 mb-1">{{ucwords(Auth::guard('seller')->user()->name)}}</h5>
                                    <p>Seller: {{strtoupper(Auth::guard('seller')->user()->slid)}}</p>
                                </div>
                                <hr class="my-4">
                                <div class="text-muted">
                                    <h5 class="font-size-16">About Seller</h5>

                                    <div class="table-responsive mt-4">
                                        <div>
                                            <p class="mb-1">Name:</p>
                                            <h5 class="font-size-16">{{ucwords(Auth::guard('seller')->user()->name)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Mobile:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('seller')->user()->mobile)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">E-mail:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('seller')->user()->email)}}</h5>
                                        </div>
                                       

                                        <div class="mt-4">
                                            <p class="mb-1">Seller NID Number:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('seller')->user()->nid_no)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Business Name:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('seller')->user()->business_name)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Business Logo:</p>
                                            <img src="{{img(Auth::guard('seller')->user()->business_logo)}}" class="avatar-lg rounded-circle img-thumbnail">
                                        </div>

                                        <div class="mt-4">
                                            <p class="mb-1">Facebook Page:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('seller')->user()->fb_page)}}</h5>
                                        </div>
                                         <div class="mt-4">
                                            <p class="mb-1">Address:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('seller')->user()->address)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Payment Type:</p>
                                            <h5 class="font-size-16">{{trim(Auth::guard('seller')->user()->payment_method->name)}}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Product Type(Sales):</p>
                                            <h5 class="font-size-16">{{seller_product_type(Auth::guard('seller')->user()->id,'name',1)}}</h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{route('seller.edit.profile')}}">
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