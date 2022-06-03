@extends('admin.layouts.main')
@section('title', 'Transfer Shipment')
@section('content')

<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Transfer Shipment </h4>
</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-lg-12">
<div id="addproduct-accordion" class="custom-accordion">
<div class="card">
<div class="p-4 border-top">
<form method="POST" action="{{ route('admin.shipments.transfer.hub.post',$shipment->id) }}" enctype="multipart/form-data">
@csrf
    <div class="row">
        {{-- <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label" for="manufacturername">Pickup Categories :</label>
                <select  class="form-select">
                  <option >Local Pickup</option>
                  <option >Nationwide Pickup</option>
              </select>
          </div>
      </div> --}}
      <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="manufacturername">From Hub :</label>
            <select  class="form-select" name='selectedhubs' id="selectedhubs" disabled>
                <option value="">Select Hub</option>
                @php($hid=$shipment->rider?$shipment->rider->hub_id:old('selectedhubs'))
                
                @foreach($selectedhubs as $hb)

                <option value="{{$hb->id}}" @if ($hid==$hb->id)
                    selected @endif>{{$hb->name}}</option>
                    @endforeach

                </select>
                @error('selectedhubs')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
      </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-3">
            <label class="form-label" for="hub">To Hub :</label>
            <select  class="form-select" name='hub' id="hub">
                <option value="">Select Hub</option>
                @php($hid=$shipment->rider?$shipment->rider->hub_id:old('hub'))
                
                @foreach($hubs as $hb)

                <option value="{{$hb->id}}" @if ($hid==$hb->id)
                    selected @endif>{{$hb->name}}</option>
                    @endforeach

                </select>
                @error('hub')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
      </div>
</div>

</div>
<div class="row my-4">
<div class="col text-end">
<input type="hidden" name="assign" value="1">
<a href="{{ route('admin.shipments.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
<button class="btn btn-success" onclick="return confirm('Are you sure?')"> <i class="uil uil-file-alt me-1"></i> Transfer </button>
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
@section('footer_scripts')

@endsection
