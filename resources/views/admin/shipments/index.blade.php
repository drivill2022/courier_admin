@extends('admin.layouts.main')
@section('title', 'Shipments')
@section('content')
@php 
$current = route('admin.shipment.index').'/';
 @endphp
<div class="page-content">
<div class="container-fluid">

<div class="col-xl-12">
<div class="card">
    <div class="card-body">
        <h4 class="card-title">All Shipments</h4>

        <div class="row">

             <div class="mb-3">
                    <label class="form-label" for="manufacturername">Hub :</label>
                    <x-hubs-dropdown :selected="$hub_id" />
        
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="total-revenue-chart"></div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1"><!-- <span data-plugin="counterup">{{$shipments->count()}}</span> -->
                                <span>{{$shipments->count()}}</span>
                            </h4>
                            <p class="text-muted mb-0">Total Shipments</p>
                        </div>
                        {{-- <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>@if($completed->count() == 0 || $shipments->count()==0) 0.00 @else {{round(($completed->count()/$shipments->count())*100,2)}} @endif</span> </p> --}}
                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="orders-chart"> </div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1"><span>{{$completed->count()}}</span></h4>
                            <p class="text-muted mb-0">Completed Shipments </p>
                        </div>
                       {{--  <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>@if($cancelled->count() == 0 || $shipments->count()==0) 0.00 @else {{round(($cancelled->count()/$shipments->count())*100,2)}} @endif%</span> 
                        </p> --}}
                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1"><span>{{$ongoing->count()}}</span></h4>
                            <p class="text-muted mb-0">On-going Pickup</p>
                        </div>
                      
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1"><span>{{$unassign->count()}}</span></h4>
                            <p class="text-muted mb-0">Un-Assigned Shipment </p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1"><span>{{$transit->count()}}</span></h4>
                            <p class="text-muted mb-0">Transit Shipment </p>
                        </div>
                      
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1"><span>{{$cancelled->count()}}</span></h4>
                            <p class="text-muted mb-0">Cancel Shipment </p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1"><span>{{$rejected->count()}}</span></h4>
                            <p class="text-muted mb-0">Rejected Shipment </p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1"><span>{{$ongoingd->count()}}</span></h4>
                            <p class="text-muted mb-0">On-going Delivery</p>
                        </div>
                        {{-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                        </p> --}}
                    </div>
                </div>
            </div> <!-- end col-->
        </div>
        <!-- Nav tabs -->
        <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
            <li class="nav-item waves-effect waves-light">
                <a class="nav-link active" data-bs-toggle="tab" href="#navpills2-all"
                role="tab">
                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                <span class="d-none d-sm-block">All <br>Shipments</span>
            </a>
        </li>
        <li class="nav-item waves-effect waves-light">
            <a class="nav-link" data-bs-toggle="tab" href="#navpills2-home"
            role="tab">
            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
            <span class="d-none d-sm-block">Un-Assigned Shipment</span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-profile" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
            <span class="d-none d-sm-block">On-going Pickup</span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-transit"
        role="tab">
        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
        <span class="d-none d-sm-block">Transit <br> Shipment</span>
    </a>
</li>
<li class="nav-item waves-effect waves-light">
        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-delivery" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
            <span class="d-none d-sm-block">On-going Delivery</span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-messages" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
            <span class="d-none d-sm-block">Completed Shipment</span>
        </a>
    </li>
<li class="nav-item waves-effect waves-light">
    <a class="nav-link" data-bs-toggle="tab" href="#navpills2-cancel" role="tab">
        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
        <span class="d-none d-sm-block">Cancelled Shipment <!-- <br> By Merchant --></span>
    </a>
</li>
<!-- <li class="nav-item waves-effect waves-light">
    <a class="nav-link" data-bs-toggle="tab" href="#navpills2-rejected" role="tab">
        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
        <span class="d-none d-sm-block">Rejected By Customer</span>
    </a>
</li> -->
</ul>

<!-- Tab panes -->
<div class="tab-content p-3 text-muted">
<div class="tab-pane active" id="navpills2-all" role="tabpanel">

    <div class="row">
        <div class="col-lg-12">

            <div class="table-responsive mb-4">
                <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                    <thead>
                        <tr class="bg-transparent">
                            <th>Shipment No.</th>
                            <th>Hub Name</th>
                            <th>Merchant Name</th>
                            <th>Business Name</th>
                            <th>Rider Name</th>
                            <th>Phone</th>
                            <th>Receiver Name</th>
                            <th>Contact No.</th>
                            <th>Delivery Address</th>
                            <th>Product Type</th>
                            <th>Pickup Date</th>
                            <th>Assign Rider/Transfer Shipment/Action</th>
                            <th>Cancel Shipment/Report Claim</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shipments as $sp)
                        <tr>
                           <!--  <td><a href="{{ route('admin.shipments.show',$sp->id) }}">{{$sp->shipment_no ?: 'NA'}}</a></td> -->
                            <td><a href="{{ route('admin.shipments.show',$sp->id) }}">@if(FindReturnShipment($sp->id) != 0)<span class="badge badge-danger" style="background-color: red;">Delivery attempt <br>failed</span>
                @elseif($sp->status == 12)<span class="badge badge-danger" style="background-color: red;">Cancel Shipment</span>
                @endif <br> {{$sp->shipment_no ?: 'NA'}}</a></td>
                            <td>
                                {{getHubDetail(@$sp->rider->hub_id)}}
                            </td>
                            <td><a href="{{ route('admin.merchants.show',$sp->merchant_id) }}">{{ucwords($sp->merchant->name)}}</a></td>
                            <td>{{getMerchantBussName($sp->merchant->id)}}</td>
                            <td>{{@$sp->rider->rider->name}} </td>
                            <td>{{$sp->merchant->mobile}}</td>
                            <td>{{ucwords($sp->receiver_name)}}</td>
                            <td>{{$sp->contact_no}}</td>
                            <td>{{$sp->d_address}}</td>
                            <td>{{shipmentProductType($sp->product_type)}}</td>
                            <td>{{MydateTime($sp->pickup_date)}}</td>
                            <td>
                                @if($sp->status==1)
                                <a href="{{ route('admin.shipments.assign',$sp->id) }}">
                                    <button class="btn btn-primary">Assign Rider</button>
                                </a>
                                @elseif(!in_array($sp->status,[6,8]))
                                <a href="{{ route('admin.shipments.transfer',$sp->id) }}">
                                    <button class="btn btn-primary">Transfer Shipment</button>
                                </a>
                                @endif
                                @if($sp->status==5)
                                  <a href="{{ route('admin.shipments.edit',$sp->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                                @endif
                               
                            </td>
                            <td>
                                @if(!in_array($sp->status,[6,8]))
                                <a href="{{ route('admin.shipments.cancel',$sp->id) }}">
                                    <button class="btn btn-danger">Cancel Shipment</button>
                                </a>
                                @elseif(in_array($sp->status,[6,8]))
                                <!-- <a href="{{ route('admin.shipments.cancel',$sp->id) }}"> -->
                                <a href="{{ route('admin.shipments.report.claim',$sp->id) }}">
                                    <button class="btn btn-primary">Report Claim</button>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane" id="navpills2-home" role="tabpanel">
    <div class="row">
        <div class="col-lg-12">

            <div class="table-responsive mb-4 px-3">
                <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                    <thead>
                        <tr class="bg-transparent">
                            <th>Shipment No.</th>
                            <th>Hub Name</th>
                            <th>Merchant Name</th>
                            <th>Business Name</th>
                            <th>Phone</th>
                            <th>Receiver Name</th>
                            <th>Contact No.</th>
                            <th>Delivery Address</th>
                            <th>Product Type</th>
                            <th>Pickup Date</th>
                            <th>Assign Rider</th>
                            <th>Cancel Shipment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($unassign as $sp)
                       <tr>
                        <td><a href="{{ route('admin.shipments.show',$sp->id) }}">{{$sp->shipment_no ?: 'NA'}}</a></td>
                          <td>{{getHubDetail(@$sp->rider->hub_id)}}</td>
                         <td><a href="{{ route('admin.merchants.show',$sp->merchant_id) }}">{{ucwords($sp->merchant->name)}}</a></td>
                            <td>{{getMerchantBussName($sp->merchant->id)}}</td>
                            <td>{{$sp->merchant->mobile}}</td>
                            <td>{{ucwords($sp->receiver_name)}}</td>
                            <td>{{$sp->contact_no}}</td>
                            <td>{{$sp->d_address}}</td>
                            <td>{{shipmentProductType($sp->product_type)}}</td>
                            <td>{{MydateTime($sp->pickup_date)}}</td>
                        <td>
                            <a href="{{ route('admin.shipments.assign',$sp->id) }}">
                                <button class="btn btn-primary">Assign Rider</button>
                            </a>
                        </td>
                        <td>
                           <a href="{{ route('admin.shipments.cancel',$sp->id) }}">
                                <button class="btn btn-danger">Cancel Shipment</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.shipments.edit',$sp->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<div class="tab-pane" id="navpills2-profile" role="tabpanel">
<div class="row">
    <div class="col-lg-12">

        <div class="table-responsive mb-4 px-3">
            <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                <thead>
                    <tr class="bg-transparent">
                     <th>Shipment No.</th>
                     <th>Hub Name</th>
                     <th>Merchant Name</th>
                     <th>Business Name</th>
                     <th>Rider Name</th>
                     <th>Phone</th>
                     <th>Receiver Name</th>
                     <th>Contact No.</th>
                     <th>Delivery Address</th>
                     <th>Product Type</th>
                     <th>Pickup Date</th>
                     <th>Assign Rider/Transfer Shipment</th>
                     <th>Cancel Shipment/Report Claim</th>
                     <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach($ongoing as $sp)
                 <tr>
                    <td><a href="{{ route('admin.shipments.show',$sp->id) }}">{{$sp->shipment_no ?: 'NA'}}</a></td>
                      <td>{{getHubDetail(@$sp->rider->hub_id)}}</td>
                    <td><a href="{{ route('admin.merchants.show',$sp->merchant_id) }}">{{ucwords($sp->merchant->name)}}</a></td>
                            <td>{{getMerchantBussName($sp->merchant->id)}}</td>
                            <td>{{@$sp->rider->rider->name}} </td>
                            <td>{{$sp->merchant->mobile}}</td>
                            <td>{{ucwords($sp->receiver_name)}}</td>
                            <td>{{$sp->contact_no}}</td>
                            <td>{{$sp->d_address}}</td>
                            <td>{{shipmentProductType($sp->product_type)}}</td>
                            <td>{{MydateTime($sp->pickup_date)}}</td>
                            
                             <!-- <td>
                                @if($sp->rider)
                                <a href="{{ route('admin.riders.show',$sp->rider->rider_id) }}">{{$sp->rider->rider?$sp->rider->rider->name:"NA"}}</a>
                                @else
                                NA
                                @endif
                            </td>  -->
                          <td>
                        <a href="{{ route('admin.shipments.transfer',$sp->id) }}">
                            <button class="btn btn-primary">Transfer Shipment</button>
                        </a>
                    </td> 
                    <td>
                        <a href="{{ route('admin.shipments.cancel',$sp->id) }}">
                                    <button class="btn btn-danger">Cancel Shipment</button>
                        </a>
                    </td>
                    <td>
                            <a class="btn btn-info" href="{{route('admin.edit-info',$sp->id)}}">Update rider/hub</a>
                            <a href="{{ route('admin.shipments.edit',$sp->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
<div class="tab-pane" id="navpills2-delivery" role="tabpanel">
<div class="row">
    <div class="col-lg-12">

        <div class="table-responsive mb-4 px-3">
            <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                <thead>
                    <tr class="bg-transparent">
                     <th>Shipment No.</th>
                     <th>Hub Name</th>
                     <th>Merchant Name</th>
                     <th>Business Name</th>
                     <th>Rider Name</th>
                     <th>Phone</th>
                     <th>Receiver Name</th>
                     <th>Contact No.</th>
                     <th>Delivery Address</th>
                     <th>Product Type</th>
                     <!-- <th>Rider</th> -->
                     <th>Pickup Date</th>
                     
                     <!-- <th>Transfer Shipment/Action</th> -->
                     <th>Action</th>
                      <th>Cancel Shipment/Report Claim</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach($ongoingd as $sp)
                 <tr>
                    <td><a href="{{ route('admin.shipments.show',$sp->id) }}">@if($sp->status == 10)<span class="badge badge-danger" style="background-color: red;">Delivery attempt <br> failed</span>@endif <br>{{$sp->shipment_no ?: 'NA'}}</a></td>
                      <td>{{getHubDetail(@$sp->rider->hub_id)}}</td>
                    <td><a href="{{ route('admin.merchants.show',$sp->merchant_id) }}">{{ucwords($sp->merchant->name)}}</a></td>
                            <td>{{getMerchantBussName($sp->merchant->id)}}</td>
                            <td>{{@$sp->rider->rider->name}} </td>
                            <td>{{$sp->merchant->mobile}}</td>
                            <td>{{ucwords($sp->receiver_name)}}</td>
                            <td>{{$sp->contact_no}}</td>
                            <td>{{$sp->d_address}}</td>
                            <td>{{shipmentProductType($sp->product_type)}}</td>
                             <td>{{MydateTime($sp->pickup_date)}}</td>
                            <!-- <td>
                                @if($sp->rider)
                                <a href="{{ route('admin.riders.show',$sp->rider->rider_id) }}">{{$sp->rider->rider?$sp->rider->rider->name:"NA"}}</a>
                                @else
                                NA
                                @endif
                            </td>  -->
                             
                            <td>
                        <!-- <a href="{{ route('admin.shipments.transfer',$sp->id) }}">
                            <button class="btn btn-primary">Transfer Shipment</button>
                        </a> -->
                        <a href="{{ route('admin.shipments.edit',$sp->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                        <a class="btn btn-info" href="{{route('admin.edit-info',$sp->id)}}">Update rider/hub</a>
                    </td>
                    <td>
                         <a href="{{ route('admin.shipments.cancel',$sp->id) }}">
                                    <button class="btn btn-danger">Cancel Shipment</button>
                                </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
<div class="tab-pane" id="navpills2-messages" role="tabpanel">
<div class="row">
<div class="col-lg-12">

    <div class="table-responsive mb-4 px-3">
        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
            <thead>
                <tr class="bg-transparent">
                    <th>Shipment No.</th>
                     <th>Hub Name</th>
                     <th>Merchant Name</th>
                     <th>Business Name</th>
                     <th>Rider Name</th>
                     <th>Phone</th>
                     <th>Receiver Name</th>
                     <th>Contact No.</th>
                     <th>Delivery Address</th>
                     <th>Product Type</th>
                     <th>Delivery Date</th>
                     <th>Rider Name</th>
                    <!--  <th>Action</th> -->
                     <!-- <th>Assign Rider/Transfer Shipment/Action</th> -->

                      <th>Cancel Shipment/Report Claim</th>
                </tr>
            </thead>
            <tbody>
             @foreach($completed as $sp)
             <tr>
                <td><a href="{{ route('admin.shipments.show',$sp->id) }}">{{$sp->shipment_no ?: 'NA'}}</a></td>
                  <td>{{getHubDetail(@$sp->rider->hub_id)}}</td>
                <td><a href="{{ route('admin.merchants.show',$sp->merchant_id) }}">{{ucwords($sp->merchant->name)}}</a></td>
                <td>{{getMerchantBussName($sp->merchant->id)}}</td>
                <td>{{@$sp->rider->rider->name}} </td>
                <td>{{$sp->merchant->mobile}}</td>
                <td>{{ucwords($sp->receiver_name)}}</td>
                <td>{{$sp->contact_no}}</td>
                <td>{{$sp->d_address}}</td>
                <td>{{shipmentProductType($sp->product_type)}}</td>
                 <td>{{MydateTime(GetDeliveryDate($sp->id)->created_at)}}</td>
                  <td>{{@$sp->rider->rider->name}} </td>
                 <!-- <td>
                        
                    </td> -->
                    <!-- <td>
                            <a href="{{ route('admin.shipments.edit',$sp->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                    </td> -->
                    <td>
                         <a href="{{ route('admin.shipments.report.claim',$sp->id) }}">
                            <button class="btn btn-primary">Report Claim</button>
                        </a>
                    </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="navpills2-transit" role="tabpanel">
<div class="row">
<div class="col-lg-12">

<div class="table-responsive mb-4 px-3">
    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
        <thead>
            <tr class="bg-transparent">
               <th>Shipment No.</th>
               <th>Hub Name</th>
               <th>Merchant Name</th>
               <th>Business Name</th>
               <th>Rider Name</th>
               <th>Phone</th>
               <th>Receiver Name</th>
               <th>Contact No.</th>
               <th>Delivery Address</th>
               <th>Product Type</th>
               <th>Transfer Shipment</th>
               <th>Assign Rider / Cancel Shipment</th>
               <th>Action</th>

            </tr>
        </thead>
        <tbody>
         @foreach($transit as $sp)
         <tr>
            <td><a href="{{ route('admin.shipments.show',$sp->id) }}">@if(FindReturnShipment($sp->id) != 0)<span class="badge badge-danger" style="background-color: red;">Delivery attempt <br>failed</span>
                @elseif($sp->status == 12)<span class="badge badge-danger" style="background-color: red;">Cancel Shipment</span>
                @endif <br> {{$sp->shipment_no ?: 'NA'}}</a></td>
              <td>{{getHubDetail(@$sp->rider->hub_id)}}</td>
            <td><a href="{{ route('admin.merchants.show',$sp->merchant_id) }}">{{ucwords($sp->merchant->name)}}</a></td>
            <td>{{getMerchantBussName($sp->merchant->id)}}</td>
            <td>{{@$sp->rider->rider->name}} </td>
            <td>{{$sp->merchant->mobile}}</td>
            <td>{{ucwords($sp->receiver_name)}}</td>
            <td>{{$sp->contact_no}}</td>
            <td>{{$sp->d_address}}</td>
            <td>{{shipmentProductType($sp->product_type)}}</td>
             <td>
                <a href="{{ route('admin.shipments.transfer.hub',$sp->id) }}">
                    <button class="btn btn-primary">Transfer Shipment</button>
                </a>
            </td>
            
            <td>
                <a href="{{ route('admin.shipments.assign',$sp->id) }}">
                    <button class="btn btn-primary">Assign Rider</button>
                </a>
                <a href="{{ route('admin.shipments.cancel',$sp->id) }}">
                    <button class="btn btn-danger">Cancel Shipment</button>
                </a>
            </td>
            <td>
                <a href="{{ route('admin.shipments.edit',$sp->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            </td>

        </tr>
        @endforeach

    </tbody>
</table>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="navpills2-cancel" role="tabpanel">
<div class="row">
<div class="col-lg-12">

<div class="table-responsive mb-4 px-3">
    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
        <thead>
            <tr class="bg-transparent">
                <th>Shipment No.</th>
               <th>Hub Name</th>
               <th>Merchant Name</th>
               <th>Business Name</th>
               <th>Rider Name</th>
               <th>Phone</th>
               <th>Receiver Name</th>
               <th>Contact No.</th>
               <th>Delivery Address</th>
               <th>Product Type</th>
             <!--   <th>Cancel By</th> -->
               <th>Assign Rider</th> 
            </tr>
        </thead>
        <tbody>
         @foreach($cancelled as $sp)
         <tr>
            <td><a href="{{ route('admin.shipments.show',$sp->id) }}">{{$sp->shipment_no ?: 'NA'}}</a></td>
             <td>{{getHubDetail(@$sp->rider->hub_id)}}</td>
              <td><a href="{{ route('admin.merchants.show',$sp->merchant_id) }}">{{ucwords($sp->merchant->name)}}</a></td>
            <td>{{getMerchantBussName($sp->merchant->id)}}</td>
            <td>{{@$sp->rider->rider->name}} </td>
            <td>{{$sp->merchant->mobile}}</td>
            <td>{{ucwords($sp->receiver_name)}}</td>
            <td>{{$sp->contact_no}}</td>
            <td>{{getMerchant($sp->merchant->id)}}</td>
            <td>{{shipmentProductType($sp->product_type)}}</td>
    
              <td>
                <a href="{{ route('admin.shipments.assign',$sp->id) }}">
                    <button class="btn btn-primary">Assign Rider</button>
                </a>
            </td> 
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="navpills2-rejected" role="tabpanel">
<div class="row">
<div class="col-lg-12">

<div class="table-responsive mb-4 px-3">
    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
        <thead>
            <tr class="bg-transparent">
               <th>Shipment No.</th>
               <th>Hub Name</th>
               <th>Merchant Name</th>
               <th>Business Name</th>
               <th>Rider Name</th>
               <th>Phone</th>
               <th>Receiver Name</th>
               <th>Contact No.</th>
               <th>Delivery Address</th>
               <th>Product Type</th>
               <th>Report Claim</th>
               <th>Assign Rider</th>
            </tr>
        </thead>
        <tbody>
          @foreach($rejected as $sp)
          <tr>
            <td><a href="{{ route('admin.shipments.show',$sp->id) }}">{{$sp->shipment_no ?: 'NA'}}</a></td>
              <td>{{getHubDetail(@$sp->rider->hub_id)}}</td>
            <td><a href="{{ route('admin.merchants.show',$sp->merchant_id) }}">{{ucwords($sp->merchant->name)}}</a></td>
            <td>{{getMerchantBussName($sp->merchant->id)}}</td>
            <td>{{@$sp->rider->rider->name}} </td>
            <td>{{$sp->merchant->mobile}}</td>
            <td>{{ucwords($sp->receiver_name)}}</td>
            <td>{{$sp->contact_no}}</td>
            <td>{{$sp->d_address}}</td>
            <td>{{shipmentProductType($sp->product_type)}}</td>
            <td>
                <a href="{{ route('admin.shipments.report.claim',$sp->id) }}">
                    <button class="btn btn-danger">Report Claim</button>
                </a>
            </td>
             <td>
                <a href="{{ route('admin.shipments.assign',$sp->id) }}">
                    <button class="btn btn-primary">Assign Rider Again</button>
                </a>
            </td>

        </tr>
        @endforeach
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

</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection
@section('footer_scripts')
<script type="text/javascript">
    $(function(){
      // bind change event to select
      $('#hub_id').on('change', function () {
          var url = $(this).val(); // get selected value
          var active = "{{$current}}";
          if (url) { // require a URL
              window.location = active+url; // redirect
          }
          else
          {
            window.location = active;
          }
          return false;
      });
    });
</script>
@endsection