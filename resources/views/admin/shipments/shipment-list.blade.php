@extends('admin.layouts.main')
@section('title', 'Shipments')
@section('content')
@php 
$current = route('admin.shipment.list').'/';
$current_url = $current;
if(!empty($hub_id))
{
    $current = $current.$hub_id;
}
$type = Request::get('type');
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
                <a class="nav-link @if($type == '') active @endif" href="{{$current}}"
                role="tab">
                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                <span class="d-none d-sm-block">All <br>Shipments</span>
            </a>
        </li>
        <li class="nav-item waves-effect waves-light">
            <a class="nav-link @if($type == 'unassigned') active @endif" href="{{$current}}?type=unassigned"
            role="tab">
            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
            <span class="d-none d-sm-block">Un-Assigned Shipment</span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link @if($type == 'pickup') active @endif" href="{{$current}}?type=pickup" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
            <span class="d-none d-sm-block">On-going Pickup</span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link @if($type == 'transit') active @endif" href="{{$current}}?type=transit"
        role="tab">
        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
        <span class="d-none d-sm-block">Transit <br> Shipment</span>
    </a>
</li>
<li class="nav-item waves-effect waves-light">
        <a class="nav-link @if($type == 'delivery') active @endif" href="{{$current}}?type=delivery" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
            <span class="d-none d-sm-block">On-going Delivery</span>
        </a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link @if($type == 'completed') active @endif" href="{{$current}}?type=completed" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
            <span class="d-none d-sm-block">Completed Shipment</span>
        </a>
    </li>
<li class="nav-item waves-effect waves-light">
    <a class="nav-link @if($type == 'cancel') active @endif" href="{{$current}}?type=cancel" role="tab">
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
                    <input type="hidden" name="type" value="{{$type}}">
                    <thead>
                        @if($type == '')
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
                    @elseif($type == 'unassigned')
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
                        @elseif($type == 'pickup')
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
                        @elseif($type == 'transit')
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
                         @elseif($type == 'delivery')
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
                                 <th>Action</th>
                                  <th>Cancel Shipment/Report Claim</th>
                            </tr>
                       @elseif($type == 'completed')
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
                                  <th>Cancel Shipment/Report Claim</th>
                        </tr> 
                    @elseif($type == 'cancel')
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
                                   <th>Assign Rider</th> 
                        </tr>
                    
                    </thead>
                    @endif
                   
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
<script>
    $(document).ready(function() {
        $(".datatable").DataTable().destroy();
        var type = '{{$type}}';
        var hub_id = '{{$hub_id}}';
        if(type == ''){
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.shipment.list') }}',
                data: {type : type,hub_id: hub_id},
                type: 'GET',
                columnDefs: [{
                    targets: "_all",
                    orderable: true                 
                }]
            },
            columns: [
              { data: 'c_shipment_no', name: 'shipment_no'},
              { data: 'hub_name', name: 'hub_id',searchable: false},
              { data: 'merchant_id', name: 'merchant_id'},
              { data: 'buss_name', name: 'buss_name'},
              { data: 'rider_name', name: 'rider_name'},
              { data: 'merchant_mobile', name: 'merchant_mobile'},
              { data: 'receiver_name', name: 'receiver_name'},
              { data: 'contact_no', name: 'contact_no'},
              { data: 'd_address', name: 'd_address'},
              { data: 'product_type', name: 'product_type'},
              { data: 'pickup_date', name: 'pickup_date'},
              { data: 'assign_status', name: 'assign_status'},
              { data: 'cancel_shipment', name: 'cancel_shipment' ,searchable: false},
            
            ]
        });
    } 
    if(type == 'unassigned'){
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.shipment.list') }}',
                data: {type : type,hub_id: hub_id},
                type: 'GET',
            },
            columns: [
              { data: 'c_shipment_no', name: 'shipment_no',searchable: true},
              { data: 'hub_id', name: 'hub_id' },
              { data: 'merchant_id', name: 'merchant_id' },
              { data: 'buss_name', name: 'buss_name' },
              { data: 'merchant_mobile', name: 'merchant_mobile' },
              { data: 'receiver_name', name: 'receiver_name' },
              { data: 'contact_no', name: 'contact_no' },
              { data: 'd_address', name: 'd_address' },
              { data: 'product_type', name: 'product_type' },
              { data: 'pickup_date', name: 'pickup_date' },
              { data: 'assign_status', name: 'assign_status' },
              { data: 'cancel_shipment', name: 'cancel_shipment' },
              { data: 'action', name: 'action' },
            
            ]
        });
    }
       if(type == 'pickup'){
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.shipment.list') }}',
                data: {type : type,hub_id: hub_id},
                type: 'GET',
            },
            columns: [
              { data: 'c_shipment_no', name: 'shipment_no',searchable: true},
              { data: 'hub_id', name: 'hub_id' },
              { data: 'merchant_id', name: 'merchant_id' },
              { data: 'buss_name', name: 'buss_name' },
              { data: 'rider_name', name: 'rider_name' },
              { data: 'merchant_mobile', name: 'merchant_mobile' },
              { data: 'receiver_name', name: 'receiver_name' },
              { data: 'contact_no', name: 'contact_no' },
              { data: 'd_address', name: 'd_address' },
              { data: 'product_type', name: 'product_type' },
              { data: 'pickup_date', name: 'pickup_date' },
              { data: 'assign_status', name: 'assign_status' },
              { data: 'cancel_shipment', name: 'cancel_shipment' },
              { data: 'action', name: 'action' },
            
            ]
        });
    }
     if(type == 'transit'){
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.shipment.list') }}',
                data: {type : type,hub_id: hub_id},
                type: 'GET',
            },
            columns: [
              { data: 'c_shipment_no', name: 'shipment_no',searchable: true},
              { data: 'hub_id', name: 'hub_id' },
              { data: 'merchant_id', name: 'merchant_id' },
              { data: 'buss_name', name: 'buss_name' },
              { data: 'rider_name', name: 'rider_name' },
              { data: 'merchant_mobile', name: 'merchant_mobile' },
              { data: 'receiver_name', name: 'receiver_name' },
              { data: 'contact_no', name: 'contact_no' },
              { data: 'd_address', name: 'd_address' },
              { data: 'product_type', name: 'product_type' },
              { data: 'assign_status', name: 'assign_status' },
              { data: 'cancel_shipment', name: 'cancel_shipment' },
              { data: 'action', name: 'action' },
            
            ]
        });
    } 
    if(type == 'delivery'){
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.shipment.list') }}',
                data: {type : type,hub_id: hub_id},
                type: 'GET',
            },
            columns: [
              { data: 'c_shipment_no', name: 'shipment_no',searchable: true},
              { data: 'hub_id', name: 'hub_id' },
              { data: 'merchant_id', name: 'merchant_id' },
              { data: 'buss_name', name: 'buss_name' },
              { data: 'rider_name', name: 'rider_name' },
              { data: 'merchant_mobile', name: 'merchant_mobile' },
              { data: 'receiver_name', name: 'receiver_name' },
              { data: 'contact_no', name: 'contact_no' },
              { data: 'd_address', name: 'd_address' },
              { data: 'product_type', name: 'product_type' },
              { data: 'pickup_date', name: 'pickup_date' },
              { data: 'action', name: 'action' },
              { data: 'cancel_shipment', name: 'cancel_shipment' },
            ]
        });
    }
    if(type == 'completed'){
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.shipment.list') }}',
                data: {type : type,hub_id: hub_id},
                type: 'GET',
            },
            columns: [
              { data: 'c_shipment_no', name: 'shipment_no',searchable: true},
              { data: 'hub_id', name: 'hub_id' },
              { data: 'merchant_id', name: 'merchant_id' },
              { data: 'buss_name', name: 'buss_name' },
              { data: 'rider_name', name: 'rider_name' },
              { data: 'merchant_mobile', name: 'merchant_mobile' },
              { data: 'receiver_name', name: 'receiver_name' },
              { data: 'contact_no', name: 'contact_no' },
              { data: 'd_address', name: 'd_address' },
              { data: 'product_type', name: 'product_type' },
              { data: 'pickup_date', name: 'pickup_date' },
              { data: 'cancel_shipment', name: 'cancel_shipment' },
            ]
        });
    }
    if(type == 'cancel'){
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.shipment.list') }}',
                 data: {type : type,hub_id: hub_id},
                type: 'GET',
            },
            columns: [
              { data: 'c_shipment_no', name: 'shipment_no',searchable: true},
              { data: 'hub_id', name: 'hub_id' },
              { data: 'merchant_id', name: 'merchant_id' },
              { data: 'buss_name', name: 'buss_name' },
              { data: 'rider_name', name: 'rider_name' },
              { data: 'merchant_mobile', name: 'merchant_mobile' },
              { data: 'receiver_name', name: 'receiver_name' },
              { data: 'contact_no', name: 'contact_no' },
              { data: 'd_address', name: 'd_address' },
              { data: 'product_type', name: 'product_type' },
              { data: 'assign_status', name: 'assign_status' },
            ]
        });
    }
    });
</script>
<script type="text/javascript">
    $(function(){
      // bind change event to select
      $('#hub_id').on('change', function () {
          var url = $(this).val(); // get selected value
          var active = "{{$current_url}}";
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