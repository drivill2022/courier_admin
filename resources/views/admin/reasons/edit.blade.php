@extends('admin.layouts.main')
@section('title', 'Edit Reason')
@section('content')

<div class="page-content">
  <div class="container-fluid">
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Edit Reason</h4>
          <a href="{{ route('admin.reasons.index') }}">
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
                  <form method="POST" action="{{ route('admin.reasons.update', $type->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="title">Reason</label>
                          <input id="title" name="title" type="text" class="form-control" value="{{$type->title}}">
                          @error('title')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="mb-3">
                         <label class="form-label" for="statusm">Reason For:</label>
                         <select  class="form-select" name="reason_for" id="reason_form">
                          <option value="0" @if ($type->reason_for=='0') selected @endif>All</option>
                          <option value="1" @if ($type->reason_for=='1') selected @endif>Admin</option>
                          <option value="2" @if ($type->reason_for=='2') selected @endif>Rider</option>
                          <option value="3" @if ($type->reason_for=='3') selected @endif>Hub</option>
                          <option value="4" @if ($type->reason_for=='4') selected @endif>Merchant</option>
                          <option value="5" @if ($type->reason_for=='5') selected @endif>Seller</option>
                          <option value="6" @if ($type->reason_for=='6') selected @endif>Customer</option>
                        </select>
                        @error('reason_for')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                          </div>


                          <div class="row my-4">
                            <div class="col text-end">
                              <a href="{{ route('admin.reasons.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
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
