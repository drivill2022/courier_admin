@extends('admin.layouts.main')
@section('title', 'Edit Vehicle Region')
@section('content')

<div class="page-content">
  <div class="container-fluid">
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Edit Vehicle Region</h4>
          <a href="{{ route('admin.vehicle.regions.index') }}">
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
                  <form method="POST" action="{{ route('admin.vehicle.regions.update', $region->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="name">Region  Name</label>
                          <input id="name" name="name" type="text" class="form-control" value="{{$region->name}}">
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
                            <option value="Active" @if ($region->status=='Active')
                              selected @endif>Active</option>
                              <option value="Blocked" @if ($region->status=='Blocked')
                                selected @endif>Blocked</option>
                              </select>
                              @error('status')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                          </div>


                          <div class="row my-4">
                            <div class="col text-end">
                              <a href="{{ route('admin.vehicle.regions.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
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
            <!-- end row -->

            <!-- end row-->

          </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @endsection
