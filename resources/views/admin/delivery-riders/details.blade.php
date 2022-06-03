@extends('admin.layouts.main')
@section('title', 'Edit Rider')
@section('content')

<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Rider Details</h4>

<div class="">
<a href="{{ route('admin.riders.index') }}">
<button class="btn btn-primary">< Back</button> 
</a>
</div>
<div class="">
<a href="{{ route('admin.rider_shipment_report','daily') }}/{{$rider->id}}">
<button class="btn btn-primary">Shipment Reports</button> 
</a>
</div>

<div class="">
<a href="{{ route('admin.rider_earning_statement','daily') }}/{{$rider->id}}">
<button class="btn btn-primary">Earning Statements</button>

</a>
</div>

</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">

<div class="mt-2">

<div class="product-desc">
<h5 class="pb-3 nav-tabs-custom">{{$rider->name}} </h5>
<div class="tab-content border border-top-0 p-4">

<div class="tab-pane fade show active" id="specifi" role="tabpanel">
<div class="table-responsive">
<table class="table table-nowrap mb-0">
<tbody>
<tr>
<th scope="row" style="width: 20%;">Rider Photo</th>
<td>
<img src="{{img($rider->picture)}}" class="avatar-xs rounded-circle me-2">
</td>
</tr>
{{-- <tr>
<th scope="row" style="width: 20%;">Rider ID</th>
<td>#MN0121</td>
</tr> --}}
<tr>
<th scope="row">Rider  Name</th>
<td>{{$rider->name}}</td>
</tr>
<tr>
<th scope="row">Rider  Gender</th>
<td>{{$rider->gender}}</td>
</tr>
<tr>
<th scope="row">Contact No.</th>
<td>{{$rider->mobile}}</td>
</tr>
<tr>
<th scope="row">Email</th>
<td>{{$rider->email}}</td>
</tr>
<tr>
<th scope="row">Address</th>
<td>{{$rider->address}}</td>
</tr>
<tr>
<th scope="row">Hub Name</th>
<td>{{$rider->hub->name}}</td>
</tr>
<tr>
<th scope="row">NID Number</th>
<td>
{{$rider->nid_number}}
</td>
</tr>
<tr>
<th scope="row">Rider Referral Code</th>
<td>
{{$rider->referral_code}}
</td>
</tr>
@if($rider->referral_by)
<tr>
<th scope="row">Rider Referred by Code</th>
<td> {{$rider->referral_by}} </td>
</tr>
@endif
<tr>
<th scope="row" style="width: 20%;">NID Photo</th>
<td>
<img src="{{img($rider->nid_picture)}}" class="avatar-xs rounded-circle me-2">
</td>
</tr>
<tr>
<th scope="row">Father NID Photo</th>
<td><img src="{{img($rider->father_nid_pic)}}" class="avatar-xs rounded-circle me-2"></td>
</tr>
<tr>
<th scope="row">Father NID Number</th>
<td> {{$rider->father_nid}} </td>
</tr>
@if($rider->vehicle_type_id==2)
<tr>
<th scope="row">Vehicle</th>
<td>{{$rider->vtype->name}}</td>
</tr>
<tr>
<th scope="row" style="width: 20%;">DL Photo</th>
<td>
<img src="{{img($rider->vehicle->dl_photo)}}" class="avatar-xs rounded-circle me-2">
</td>
</tr>
<tr>
<th scope="row">DL Number</th>
<td>{{$rider->vehicle->dl_number}}</td>
</tr>
<tr>
<th scope="row" style="width: 20%;">RC Photo</th>
<td>
<img src="{{img($rider->vehicle->rc_photo)}}" class="avatar-xs rounded-circle me-2">
</td>
</tr>
<tr>
 
<tr>
 <tr>
<th scope="row">Brand</th>
<td>{{$rider->vehicle->brand}}</td>
</tr>
<tr>
 <tr>
<th scope="row">Model</th>
<td>{{$rider->vehicle->model}}</td>
</tr>
<tr>
<tr>
<th scope="row">Plat Number</th>
<td>{{$rider->vehicle->plat_number}}</td>
</tr><tr>
<th scope="row">Token Number</th>
<td>{{$rider->vehicle->token_number}}</td>
</tr><tr>
<th scope="row">Region</th>
<td>{{$rider->vehicle->region}}</td>
</tr><tr>
<th scope="row">Category</th>
<td>{{$rider->vehicle->category}}</td>
</tr>
@endif
<tr>
<th scope="row">Status</th>
<td>{{$rider->status}}</td>
</tr>
<tr>
<th scope="row">COD to deposit</th>
<td>{{config('constants.currency')}}{{$cod_to_deposit}}</td>
</tr>

</tbody>
</table>
</div>
</div>
</div>
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
