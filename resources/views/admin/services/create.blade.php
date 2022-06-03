@extends('admin.layouts.main')
@section('title', 'Add Service')
@section('content')

<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Add Service</h4>
<a href="{{ route('admin.services.index') }}">
  <button type="button" class="btn btn-success waves-effect waves-light mb-3">< Back</button></a>
</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-lg-12">
<div id="addproduct-accordion" class="custom-accordion">
<div class="card">


<div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
<div class="p-4 border-top">
<form class="form-horizontal" action="{{route('admin.services.store')}}" method="POST" enctype="multipart/form-data" role="form">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="name">Name</label>
        <input id="name" name="name" type="text" class="form-control" value="{{old('name')}}">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" class="control-label">Status</label>
                <select class="form-control" name="status">
                    <option>Select</option>
                    <option value="Active" @if(old('status')=='Active') selected @endif>Active</option>
                    <option value="Blocked" @if(old('status')=='Blocked') selected @endif>Blocked</option>
                </select>
                @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" class="control-label">Picture</label>
                <input type="file" name="picture" class="form-control">
                @error('picture')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="mb-0">
        <label class="form-label" for="productdesc">  Description</label> 
        <textarea class="form-control" id="description" name="description" rows="4">{{old('description')}}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    </div> <!-- end row-->

    <div class="row mb-4">
        <div class="col text-end">
            <a href="{{ route('admin.services.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
            <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Save </button>
        </div> <!-- end col -->
</form>
</div>
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
