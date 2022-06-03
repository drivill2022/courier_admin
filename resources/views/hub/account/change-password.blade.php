@extends('hub.layouts.main')
@section('title', 'Dashboard')
@section('content')
<style type="text/css">
    .invalid-feedback{display: inline-block;}
</style>
<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Change Password</h4>



                                    <!-- <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                            <li class="breadcrumb-item active">Add Product</li>
                                        </ol>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                        

                                        <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                                            <div class="p-4 border-top">
                                                <form class="form-horizontal" action="{{route('hub.password.update')}}" method="POST" enctype="multipart/form-data" role="form">
                                                    {{csrf_field()}}                                                
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="old_password">Current Password</label>
                                                                <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                                                @error('old_password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="password">New Password</label>
                                                                <input type="password" name="password" id="password" placeholder="New Password" class="form-control">
                                                                @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type New Password" class="form-control">
                                                                @error('password_confirmation')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                    <div class="col-md-12 col text-end mt-3">
                                                          
                                                            <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Submit </button>
                                                    </div> <!-- end row-->
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        <!-- end row -->                        
                    </div> <!-- container-fluid -->
                </div>

                
 @endsection