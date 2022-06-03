@extends('hub.layouts.main')
@section('title', 'Shipment Report')
@section('content')
@php $active = Request::segment(4); 
$current = route('hub.rider_shipment_report',[$active]).'/';
@endphp
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Rider Shipment Details</h4>
                                    
                                    

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                        <div class="row">
                            <div class="col-lg-12">
                                

                                <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All Shipments</h4>
                                   <div class="mb-3">
                                            <label class="form-label" for="rider">Rider :</label>
                                            <select  class="form-select" name='rider' id="rider">
                                            <option value="">Select Rider</option>
                                            @foreach($resp['riders'] as $m)
                                            <option value="{{$m->id}}" @if ($resp['rider_id']==$m->id)
                                                selected @endif>{{$m->name}}</option>
                                                @endforeach
                                            </select>
                                 </div>
                                    
                                   <!-- Nav tabs -->
                    <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link @if($active == 'daily') active @endif" href="{{ route('hub.rider_shipment_report',['daily']) }}@if($resp['rider_id'])/{{$resp['rider_id']}}@endif"
                                role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Daily </span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link @if($active == 'weekly') active @endif" href="{{ route('hub.rider_shipment_report',['weekly']) }}@if($resp['rider_id'])/{{$resp['rider_id']}}@endif"
                                role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Weekly </span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link @if($active == 'monthly') active @endif" href="{{ route('hub.rider_shipment_report',['monthly']) }}@if($resp['rider_id'])/{{$resp['rider_id']}}@endif" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Monthly</span>
                            </a>
                        </li>
                        
                        
                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                       
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{ route('hub.rider_shipment_report',[$active]) }}@if($resp['rider_id'])/{{$resp['rider_id']}}@endif" method="POST">@csrf

                                    <div class="page-title-box d-flex align-items-center  flex-wrap">
                                        @if($active == 'daily')
                                        <h4 class="mb-0 px-2">Today Earning  </h4>
                                        <input type="date" value="{{$resp['filter']}}" name="filter" value="" id="example-date-input" class="form-control date_form_width" onchange="this.form.submit()">
                                        @elseif($active == 'weekly')
                                         <h4 class="mb-0 px-2">This Week Shipment </h4>
                                        <input type="week"  value="{{$resp['filter']}}" name="filter" value="" id="example-week-input" class="form-control date_form_width" onchange="this.form.submit()">
                                        @elseif($active == 'monthly')
                                        <h4 class="mb-0 px-2">This Month Shipment </h4>
                                        <input type="month" value="{{$resp['filter']}}" name="filter" value="" id="example-month-input" class="form-control date_form_width" onchange="this.form.submit()">
                                        @endif
                                   
                                    </div>
                                 </form>
                                </div>
            
                            </div>
                                            <div class="row"> 
                <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="float-end mt-2">
                            <div id="total-revenue-chart"></div>
                        </div> -->
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$resp['total']}}</span></h4>
                            <p class="text-muted mb-0">Total Shipments</p>
                        </div>
                        {{-- <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>@if($completed->count() == 0 || $shipments->count()==0) 0.00 @else {{round(($completed->count()/$shipments->count())*100,2)}} @endif</span> </p> --}}
                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                       <!--  <div class="float-end mt-2">
                            <div id="orders-chart"> </div>
                        </div> -->
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$resp['completed']}}</span></h4>
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
                        <!-- <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div> -->
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$resp['ongoing']}}</span></h4>
                            <p class="text-muted mb-0">On-going Pickup</p>
                        </div>
                      
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div> -->
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$resp['unassign']}}</span></h4>
                            <p class="text-muted mb-0">Un-Assigned Shipment </p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div> -->
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$resp['transit']}}</span></h4>
                            <p class="text-muted mb-0">Transit Shipment </p>
                        </div>
                      
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                       <!--  <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div> -->
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$resp['cancelled']}}</span></h4>
                            <p class="text-muted mb-0">Cancel Shipment </p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                       <!--  <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div> -->
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$resp['return']}}</span></h4>
                            <p class="text-muted mb-0">Rejected Shipment </p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="float-end mt-2">
                            <div id="customers-chart"> </div>
                        </div> -->
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$resp['ongoingd']}}</span></h4>
                            <p class="text-muted mb-0">On-going Delivery</p>
                        </div>
                        {{-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                        </p> --}}
                    </div>
                </div>
            </div> <!-- end col-->
        </div>
                                                


                                                 <div class="row">
                                <div class="col-lg-12">
                                    
                                    <div class="table-responsive mb-4">
                                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                            <thead>
                                                <tr class="bg-transparent">
                                                    
                                                    <th width="10%">Date</th>
                                                    <th width="10%">Product ID</th>
                                                    <th width="20%">Product Name</th>
                                                    <th width="10%">Merchant Name</th>
                                                    <th width="10%">Rider Name</th>
                                                    <th width="10%">Order Status</th>       
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($resp['statement'] as $s)
                                                <tr>
                                                    
                                                    <td>{{date('d M, Y',strtotime($s->created_at))}}</td>
                                                    <td>{{$s->shipment_no}}</td>
                                                    <td>{{$s->product_detail}}</td>
                                                    <td>{{$s->merchant_name}}</td>
                                                    <td>{{$s->rider_name}}</td>
                                                    <td>{{shipment_status($s->status)}}</td>
                                                    
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table -->
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
@section('footer_scripts')
<script type="text/javascript">
    $(function(){
      // bind change event to select
      $('#rider').on('change', function () {
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