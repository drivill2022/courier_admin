@extends('hub.layouts.main')
@section('title', $title)
@section('content')
@php $shipment_id = Request::segment(3); @endphp
<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">{{$title}}</h4>
<a href="{{ route('hub.shipments.index') }}">
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
<form class="form-horizontal" action="{{route('hub.help.store')}}" method="POST" enctype="multipart/form-data" role="form">
    @csrf
    @if(@$shipment)
       <input type="hidden" name="shipment_id" value="{{$shipment->id}}">
       <input type="hidden" name="merchant_id" value="{{$shipment->merchant_id}}">
    @else
    <div class="mb-3">
        <label class="form-label" for="name">Shipment No.</label>
        <select name="shipment_id" class="form-control">
        @if(!empty($shipment_list))
           @foreach($shipment_list as $value)
            <option value="{{$value->id}}">{{$value->shipment_no}}</option>
           @endforeach
        @endif
        </select>
        @error('shipment_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
     <div class="mb-3">
        <label class="form-label" for="name">Merchant Name</label>
        <select name="merchant_id" class="form-control">
        @if(!empty($marchants))
           @foreach($marchants as $value)
            <option value="{{$value->id}}">{{$value->name}}</option>
           @endforeach
        @endif
        </select>
        @error('merchant_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="status">Status</label>
        <select name="status" class="form-control">
            <option value="0">Under Investigation</option>
            <option value="1">Solved</option>
        </select>
    </div>
    @endif
    <div class="mb-0">
        <label class="form-label" for="productdesc">Complain</label> 
        <textarea class="form-control" id="complain" name="complain" rows="4">{{old('complain')}}</textarea>
        @error('complain')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    </div> <!-- end row-->

    <div class="row mb-4">
        <div class="col text-end">
            <a href="{{ route('hub.shipments.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
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
