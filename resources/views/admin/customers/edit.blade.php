@extends('admin.layouts.main')
@section('title', 'Edit Customer')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Customer</h4>
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
                            <form class="form-horizontal" action="{{route('admin.customers.update',$user->id)}}" method="POST" enctype="multipart/form-data" role="form">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input id="name" name="name" type="text" class="form-control" value="{{$user->name}}">
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
                                            <input id="mobile" name="mobile" type="text" class="form-control" value="{{$user->mobile}}">
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
                                            <input id="email" name="email" type="email" class="form-control" value="{{$user->email}}">
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
                                            <input id="address" name="address" type="text" class="form-control" value="{{$user->address}}">
                                            @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <label class="form-label" for="images upload">Profile Images</label>
                                       @if($user->picture)
                                       <img src="{{img($user->picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                       @endif
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
                                        <option value="Active" @if ($user->status=='Active')
                                        selected @endif>Active</option>
                                        <option value="Blocked" @if ($user->status=='Blocked')
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
                                    <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Update </button>
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
