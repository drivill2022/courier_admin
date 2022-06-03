@extends('merchant.layouts.main')
@section('title', 'Shipment Details')
@section('content')

<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Shipment Order Details</h4>
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
<h5 class="pb-3 nav-tabs-custom">Shipment Number: {{$shipment->shipment_no}}</h5>
<div class="tab-content border border-top-0 p-4">
<div class="tab-pane fade show active" id="specifi" role="tabpanel">
<div class="table-responsive">
<table class="table table-nowrap mb-0">
    <tbody>
        <tr>
            <th scope="row" style="width: 20%;">Hub</th>
            <td>
                {{getHubDetail(@$shipment->rider->hub_id)}}
            </td>
        </tr> 
        <tr>
            <th scope="row" style="width: 20%;">Merchant</th>
            <td>
                {{$shipment->merchant->name}}
            </td>
        </tr>
        <tr>
            <th scope="row" style="width: 20%;">Phone Number</th>
            <td>
                {{$shipment->merchant->mobile}}
            </td>
        </tr>
        <tr>
            <th scope="row" style="width: 20%;">Pickup Date</th>
            <td>
                {{MydateTime($shipment->pickup_date)}}
            </td>
        </tr>
        
        <tr>
            <th scope="row">Receiver Name</th>
            <td>{{$shipment->receiver_name}}</td>
        </tr>
        <tr>
            <th scope="row">Contact Number</th>
            <td>{{$shipment->contact_no}}</td>
        </tr>
        <tr>
            <th scope="row" style="width: 20%;">Product Type</th>
            <td>{{shipmentProductType($shipment->product_type)}}</td>
        </tr>
         <tr>
            <th scope="row">Weight</th>
            <td>{{$shipment->product_weight}}</td>
        </tr>
        <tr>
            <th scope="row">Pickup Address</th>
            <td>{{$shipment->s_address}}</td>
        </tr>
        <tr>
            <th scope="row">Pickup Division</th>
            <td>{{$shipment->sdivision?$shipment->sdivision->name:'NA'}}</td>
        </tr>
        <tr>
            <th scope="row">Pickup District</th>
            <td>{{$shipment->sdistrict?$shipment->sdistrict->name:'NA'}}</td>
        </tr>
        <tr>
            <th scope="row">Pickup Thana</th>
            <td>{{$shipment->sthana?$shipment->sthana->name:'NA'}}</td>
        </tr>
        <tr>
            <th scope="row">Delivery Address</th>
            <td>{{$shipment->d_address}}</td>
        </tr>
        <tr>
            <th scope="row">Delivery Division</th>
            <td>{{$shipment->ddivision?$shipment->ddivision->name:'NA'}}</td>
        </tr>
        <tr>
            <th scope="row">Delivery District</th>
            <td>{{$shipment->ddistrict?$shipment->ddistrict->name:'NA'}}</td>
        </tr>
        <tr>
            <th scope="row">Delivery Thana</th>
            <td>{{$shipment->dthana?$shipment->dthana->name:'NA'}}</td>
        </tr>
        <tr>
            <th scope="row">Delivery Note</th>
            <td>{{$shipment->note}}</td>
        </tr>
        <tr>
            <th scope="row">status</th>
            <td>{{shipment_status($shipment->status)}}</td>
        </tr>
        @if($shipment->status == 8)
             <tr>
                <th scope="row">Reason</th>
                <td>{{$shipment->cancelBy[0]->reason}}</td>
            </tr>
            <tr>
                <th scope="row">Cancel Note</th>
                <td>{{cancelNote($shipment->cancelBy[0]->note,$shipment->cancelBy[0]->updated_by_id,$shipment->cancelBy[0]->updated_by)}}</td>
            </tr>
        @endif
       <!--  <tr>
            <th scope="row">Shipment Type</th>
            <td>{{shipmentDType($shipment->shipment_type)}} Delivery</td>
        </tr> -->
        @if($shipment->status == 8 && $shipment->cancelBy[0]->updated_by == "Admin")
        <tr>
            <th scope="row">Shipment Cost</th>
            <td>{{config('constants.currency')}}{{$shipment->shipment_cost?$shipment->shipment_cost/2:0}}</td>
        </tr>
        @else
        <tr>
            <th scope="row">Shipment Cost</th>
            <td>{{config('constants.currency')}}{{$shipment->shipment_cost?$shipment->shipment_cost:0}}</td>
        </tr>
        <tr>
            <th scope="row">COD Amount</th>
            <td>{{config('constants.currency')}}{{$shipment->cod_amount}}</td>
        </tr>
        @endif
       
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
