@extends('merchant.layouts.main')
@section('title', 'Earning statement')
@section('content')
@php $active = Request::segment(3); 
$current = route('merchant.merchant_earning_statement',[$active]).'/';
@endphp

    <meta name="csrf-token" content="{{ csrf_token() }}" />

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Earning statement</h4>
                                    
                                    

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-1">Available Payout: {{config('constants.currency')}}{{$resp['available_payout']}}
                                    </h4>
                                     
                                    <div class="pull-left mt-4"><span class="withdraw_response"></span></div>
                                    <div class="pull-right">
                                        <h6 class="mb-3">Drivills Commission:  {{config('constants.currency')}}{{$resp['drivills_commission']}}
                                        </h6>
                                        <br><br><br>
                                       <button class="btn btn-primary pull-right withdraw_request">Withdraw</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-6">

                            <div class="card">
                                <div class="card-body">
                                        <h6 class="mb-4">Total Cash Collected:  {{config('constants.currency')}}{{$resp['total_cod_collected']}}
                                        </h6> 
                                        <h6 class="mb-4">Total Refund From Drivill:  {{config('constants.currency')}}{{$resp['refund_from_drivill']}}
                                        </h6>
                                        <h6 class="mb-4">Drivills Service Charge:  {{config('constants.currency')}}{{$resp['drivill_service_charge']}}
                                        </h6>
                                        <h6 class="mb-4">Total Available For Payout:  {{config('constants.currency')}}{{$resp['total_available_for_payout']}}
                                        </h6>
                                </div>
                            </div>
                        </div>
                    </div>



                        <div class="row">
                            <div class="col-lg-12">
                                

                                <div class="card">
                                <div class="card-body">

                        
                                    <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link @if($active == 'daily') active @endif" href="{{ route('merchant.merchant_earning_statement',['daily']) }}@if($resp['merchant_id'])/{{$resp['merchant_id']}}@endif"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Daily </span>
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link @if($active == 'weekly') active @endif" href="{{ route('merchant.merchant_earning_statement',['weekly']) }}@if($resp['merchant_id'])/{{$resp['merchant_id']}}@endif"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Weekly </span>
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link @if($active == 'monthly') active @endif" href="{{ route('merchant.merchant_earning_statement',['monthly']) }}@if($resp['merchant_id'])/{{$resp['merchant_id']}}@endif" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Monthly</span>
                                        </a>
                                    </li>
                                    
                                    
                                </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active" id="navpills2-all" role="tabpanel">

                                         <div class="row">
                                            <div class="col-12">
                                                <form action="{{ route('merchant.merchant_earning_statement',[$active]) }}@if($resp['merchant_id'])/{{$resp['merchant_id']}}@endif" method="POST">@csrf

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
                                            {{--<div class="row">
                                             <!-- end col-->

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            
                                                            <div>
                                                                <h4 class="mb-1 mt-1">{{config('constants.currency')}} {{$resp['total_earning']}}</h4>
                                                                <p class="text-muted mb-0">Total Earning</p>
                                                            </div>
                                                            <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                                                            </p> -->
                                                        </div>
                                                    </div>
                                                </div> <!-- end col-->

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                           
                                                            <div>
                                                                <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{$resp['total_cod_collected']}}</span></h4>
                                                                <p class="text-muted mb-0">Total COD Received </p>
                                                            </div>
                                                            <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            
                                                            <div>
                                                                <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{$resp['pending_cod']}}</span></h4>
                                                                <p class="text-muted mb-0">Pending COD </p>
                                                            </div>
                                                            <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                

                                                
                                            </div> --}}


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
                                                                <th width="10%">Order Status</th>  <!-- <th width="10%">Earned</th> -->
                                                                <th width="10%">COD</th>
                                                                <th width="10%">Shipment Charge</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($resp['statement'] as $s)
                                                            <tr>
                                                                <td>{{date('d M, Y',strtotime($s->created_at))}}</td>
                                                                <td>{{$s->shipment_no}}</td>
                                                                <td>{{$s->product_detail}}</td>
                                                                <td>{{$s->merchant_name}}</td>
                                                                <td>{{shipment_status($s->status)}}</td>
                                                                <!-- <td>{{config('constants.currency')}}{{$s->cod_amount}}</td> -->
                                                                <td>{{config('constants.currency')}}{{$s->cod_amount}}</td>
                                                                <td>{{config('constants.currency')}}@if($s->shipment_cost == null)0 @else {{$s->shipment_cost}} @endif</td>
                                                                
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    </div>
                                                    <!-- end table -->
                                                </div>
                                            </div>



                                        </div>
                                        <div class="tab-pane" id="navpills2-home" role="tabpanel">

                                            <div class="row">
                                                <div class="col-12">
                                                    
                                                    <div class="page-title-box d-flex align-items-center  flex-wrap">
                                                        <h4 class="mb-0 px-2">This Week Shipment </h4>
                                                        <input type="week" value="" id="example-week-input" class="form-control date_form_width">
                                                    </div>
                                                
                                                </div>
                            
                                            </div>
                                            <div class="row">
                                             <!-- end col-->

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="orders-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">50</span></h4>
                                                                <p class="text-muted mb-0">Total Earning</p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div> <!-- end col-->

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="customers-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">38</span></h4>
                                                                <p class="text-muted mb-0">Total COD Received </p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="customers-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">12</span></h4>
                                                                <p class="text-muted mb-0">Pending COD </p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                

                                                
                                            </div> 


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    
                                                    <div class="table-responsive mb-4">
                                                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                                            <thead>
                                                                <tr class="bg-transparent">
                                                                    
                                                                    <th>Date</th>
                                                                    <th>Product ID</th>
                                                                    <th>Product Name</th>
                                                                    <th>Merchant Name</th>
                                                                    <th>Order Status</th>
                                                                    <th>Earned</th>
                                                                    <th>COD</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td>$5</td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td>$5</td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td>$5</td>
                                                                </tr>
                                                                
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="navpills2-profile" role="tabpanel">
                                            <div class="row">
                                                <div class="col-12">
                                                    
                                                    <div class="page-title-box d-flex align-items-center  flex-wrap">
                                                        <h4 class="mb-0 px-2">This Month Shipment </h4>
                                                        <input type="month" value="" id="example-month-input" class="form-control date_form_width">
                                                    </div>
                                                
                                                </div>
                            
                                            </div>
                                            <div class="row">
                                             <!-- end col-->

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="orders-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">50</span></h4>
                                                                <p class="text-muted mb-0">Total Earning</p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div> <!-- end col-->

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="customers-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">38</span></h4>
                                                                <p class="text-muted mb-0">Total COD Received </p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="customers-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">12</span></h4>
                                                                <p class="text-muted mb-0">Pending COD </p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                

                                                
                                            </div> 


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    
                                                    <div class="table-responsive mb-4">
                                                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                                            <thead>
                                                                <tr class="bg-transparent">
                                                                    
                                                                    <th>Date</th>
                                                                    <th>Product ID</th>
                                                                    <th>Product Name</th>
                                                                    <th>Merchant Name</th>
                                                                    <th>Order Status</th>
                                                                    <th>Earned</th>
                                                                    <th>COD</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td>$5</td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td>$5</td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td>$5</td>
                                                                </tr>
                                                                
                                                                
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
                        </div>


                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
@endsection
@section('footer_scripts')
<script type="text/javascript">
    $(function(){
      // bind change event to select
      $('#merchant').on('change', function () {
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


    $(".withdraw_request").click(function(event){
      event.preventDefault();

      let _token   = $('meta[name="csrf-token"]').attr('content');

      //alert(_token);

      $.ajax({
        url: "{{route('merchant.withdraw-request')}}",
        type:"POST",
        data:{
          _token: _token
        },
        success:function(response){
          if(response.status == true) {
            $('.withdraw_response').html('<div class="text text-success">'+response.message+'</div>');
          }
          else
          {
             $('.withdraw_response').html('<div class="text text-danger">'+response.message+'</div>');
          }
        },
        error: function(error) {
           // $('.withdraw_response').html('<div class="text text-danger>"'+error.message+'</div>');
        }
       });
  });
    });
</script>
@endsection