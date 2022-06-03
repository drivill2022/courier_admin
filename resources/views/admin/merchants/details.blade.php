@extends('admin.layouts.main')
@section('title', 'Add Admins')
@section('content')

<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Merchant Details </h4>

<div class="">
<a href="{{ route('admin.merchant_shipment_report','daily') }}/{{$merchant->id}}">
<button class="btn btn-primary">Shipment Reports</button> 
</a>
</div>

<div class="">
<a href="{{ route('admin.merchant_earning_statement','daily') }}/{{$merchant->id}}">
<button class="btn btn-primary">Earning Statements</button>

</a>
</div>

<div>
<a href="{{ route('admin.merchants.index') }}">
<button class="btn btn-primary">< Back</button> 
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
<h5 class="pb-3 nav-tabs-custom">{{ucwords($merchant->name)}}</h5>
<div class="tab-content border border-top-0 p-4">

<div class="tab-pane fade show active" id="specifi" role="tabpanel">
<div class="table-responsive">
<table class="table table-nowrap mb-0">
<tbody>
<tr>
<th scope="row" style="width: 20%;">Merchant Photo</th>
<td>
<img src="{{img($merchant->picture)}}" alt="" class="avatar-xs rounded-circle me-2">

</td>
</tr>

<tr>
<th scope="row" style="width: 20%;">Merchant ID</th>
<td>{{$merchant->mrid}}</td>
</tr>
<tr>
<th scope="row">Merchant  Name</th>
<td>{{ucwords($merchant->name)}}</td>
</tr>
<tr>
<th scope="row">Contact No.</th>
<td>{{ucwords($merchant->mobile)}}</td>
</tr>
<tr>
<th scope="row">Contact Email</th>
<td>{{ucwords($merchant->email)}}</td>
</tr>
<tr>
<th scope="row">NID Number</th>
<td>{{ucwords($merchant->nid_number)}}</td>
</tr>
<tr>
<th scope="row">Merchant Business Name</th>
<td>{{trim($merchant->buss_name)}}</td>
</tr>
<tr>
<th scope="row">Merchant Business Phone Number</th>
<td>{{trim($merchant->buss_phone)}}</td>
</tr>
<tr>
<th scope="row">Merchant Business Address</th>
<td>{{trim($merchant->buss_address)}}</td>
</tr>
<tr>
<th scope="row">Merchant Business Facebook Page</th>
<td>{{trim($merchant->fb_page)}}</td>
</tr>

<tr>
<th scope="row">Merchant Payment Method</th>
<td>{{trim($merchant->pmethod?$merchant->pmethod->name:'NA')}}</td>
</tr>
<tr>
<th scope="row">Merchant Product Types</th>
<td>{{trim($merchant->product_type_names)}}</td>
</tr>
<tr>
<th scope="row">Merchant Business Logo</th>
<td>
@if(!empty($merchant->business_logo))
<img src="{{img($merchant->business_logo)}}" alt="" class="avatar-xs rounded-circle me-2">
@endif
</td>
</tr>
<tr>
<th scope="row">Trade license Photo</th>
<td>
@if(!empty($merchant->trade_lic_no))
<img src="{{img($merchant->trade_lic_no)}}" alt="" class="avatar-xs rounded-circle me-2">
@endif
</td>
</tr>
<tr>
<th scope="row">Merchant Status</th>
<td>{{$merchant->status}}</td>
</tr>
<tr>
<th scope="row">Total Order </th>
<td>{{$merchant->total}}</td>
</tr>
<tr>
<th scope="row">Total Deliverd Order </th>
<td>{{$merchant->delivered}}</td>
</tr>
<tr>
<th scope="row">Total On-going Order </th>
<td>{{$merchant->ongoingd}}</td>
</tr>
<tr>
<th scope="row">Total Return/Cancel Order </th>
<td>{{$merchant->rejected}}</td>
</tr>
<tr>
<!-- <th scope="row">Total Cancel Order </th>
<td>{{$merchant->cancelled}}</td>
</tr>
<tr>
<th scope="row">Account Number</th>
<td>1234567890</td>
</tr>
 -->
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