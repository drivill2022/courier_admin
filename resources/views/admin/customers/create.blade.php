@extends('admin.layouts.main')
@section('title', 'Add Customer')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Add Customer</h4>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-primary pull-right"><i class="fa fa-angle-left"></i> Back</a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <form class="form-horizontal" action="{{route('admin.customers.store')}}" method="POST" enctype="multipart/form-data" role="form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input id="name" name="name" type="text" class="form-control" value="{{old('name')}}">
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
                                            <input id="mobile" name="mobile" type="text" class="form-control" value="{{old('mobile')}}">
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
                                            <input id="email" name="email" type="email" class="form-control" value="{{old('email')}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                          <label class="form-label" for="password">Password</label>
                                          <input id="password" name="password" type="password" class="form-control" value="{{old('password')}}">
                                          @error('password')
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                      <label class="form-label" for="password_confirmation">Confirm Password</label>
                                      <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" value="{{old('password_confirmation')}}">
                                      @error('password_confirmation')
                                      <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <input id="address" name="address" type="text" class="form-control" value="{{old('address')}}">
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                             <label class="form-label" for="images upload">Profile Images</label>
                             <input name="picture" type="file" multiple="multiple" class="form-control">
                             @error('picture')
                             <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label class="form-label" for="statusm">Status:</label>
                              <select  class="form-select" name="status" id="statusm">
                                <option value="Active" @if (old('status')=='Active')
                                selected @endif>Active</option>
                                <option value="Blocked" @if (old('status')=='Blocked')
                                selected @endif>Blocked</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row my-4">
                    <div class="col text-end">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                        <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Add </button>
                    </div> <!-- end col -->
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

</div> 
</div>
<!-- End Page-content -->
@endsection
