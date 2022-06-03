@extends('admin.layouts.main')
@section('title', 'Add Vehicle Model')
@section('content')<!-- edit page -->

<div class="page-content">
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Add Vehicle Model</h4>
          <a href="{{ route('admin.vehicle.models.index') }}">
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
                  <form method="POST" action="{{ route('admin.vehicle.models.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="name">Model  Name</label>
                          <input id="name" name="name" type="text" class="form-control" value="{{old('name')}}">
                          @error('name')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
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

                      <div class="row mb-4">
                        <div class="col text-end">
                          <a href="{{ route('admin.vehicle.models.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                          <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Save </button>
                        </div> <!-- end col -->
                      </div> <!-- end row-->
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end row -->

        <!-- end row-->

      </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @endsection
