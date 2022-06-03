@extends('admin.layouts.main')
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
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <form class="form-horizontal" action="{{route('admin.profile.update')}}" method="POST" enctype="multipart/form-data" role="form">
                                {{csrf_field()}}                                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input id="name" name="name" type="text" class="form-control" value="{{trim(Auth::guard('admin')->user()->name)}}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="mobile">Mobile No.</label>
                                            <input id="mobile" name="mobile" type="text" class="form-control" value="{{trim(Auth::guard('admin')->user()->mobile)}}" maxlength="10">
                                            @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email ID</label>
                                            <input id="email" name="email" type="text" class="form-control" value="{{trim(Auth::guard('admin')->user()->email)}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Address</label>
                                            <input id="address" name="address" type="text" class="form-control" value="{{trim(Auth::guard('admin')->user()->address)}}">
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="images upload">Profile Images</label>
                                    @if(isset(Auth::guard('admin')->user()->picture))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em; margin-left: 15px;" src="{{img(Auth::guard('admin')->user()->picture)}}">
                                    @endif
                                    <input name="picture" type="file" multiple="multiple" class="form-control" accept="image/*">
                                    @error('picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 col text-end mt-3">
                                    <a href="{{route('admin.profile')}}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                                    <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Update </button>
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