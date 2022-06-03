@extends('admin.layouts.main')
@section('title', 'Earnings')
@section('content')
@php
$current = route('admin.merchant_transaction',[$type,'']).'/';
@endphp
<style type="text/css">
  .modal-content
  {
    border: 1px solid #ddd;
  }
  .modal .table-responsive {
        padding: 17px;
    }
    .modal-content
    {
        background-color:#efefef;
    }
</style>
<div class="page-content">
    <div class="container-fluid">

        <div class="col-xl-12">
            <div class="row">
                <div class="mb-3">
                        <label class="form-label" for="manufacturername">Merchant :</label>
                        <select  class="form-select" name='merchant' id="merchant">
                        <option value="">Select Merchant</option>
                        @foreach($merchants as $m)
                        <option value="{{$m->id}}" @if ($merchant_id==$m->id)
                            selected @endif>{{$m->name}}({{$m->buss_name}})</option>
                            @endforeach
                        </select>
                  </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2">
                                <div id="total-revenue-chart"></div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{$total_pay}}</span></h4>
                                <p class="text-muted mb-0">Total Earning</p>
                            </div>
                           <!--  <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
                            </p> -->
                        </div>
                    </div>
                </div> <!-- end col-->

              {{--  <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2">
                                <div id="orders-chart"> </div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{$merchant_total_pay}}</span></h4>
                                <p class="text-muted mb-0">Earning Form Merchant </p>
                            </div>
                             <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                            </p> 
                        </div>
                    </div>
                </div>  --}}<!-- end col-->

              {{--   <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2">
                                <div id="orders-chart"> </div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{$rider_total_pay}}</span></h4>
                                <p class="text-muted mb-0">Earning Form Rider </p>
                            </div>
                             <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                            </p>
                        </div>
                    </div>
                </div> --}} <!-- end col-->

               

            </div> 

            <div class="card">
                <div class="card-body">

                     <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link @if($type == 'daily') active @endif" href="{{ route('admin.merchant_transaction',['daily',$merchant_id]) }}"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Daily </span>
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link @if($type == 'weekly') active @endif" href="{{ route('admin.merchant_transaction',['weekly',$merchant_id]) }}"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Weekly </span>
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link @if($type == 'monthly') active @endif" href="{{ route('admin.merchant_transaction',['monthly',$merchant_id]) }}" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Monthly</span>
                                        </a>
                                    </li>
                                    
                                    
                                </ul>
                  <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="navpills2-all" role="tabpanel">

                     <div class="row">
                        <div class="col-12">
                    <form action="{{ route('admin.merchant_transaction',[$type,$merchant_id]) }}" method="POST">@csrf
                         <!-- <h4 class="mb-0 px-2">This Week Transactions </h4>
                        <input type="week"  value="{{$filter}}" name="filter" value="" id="example-week-input" class="form-control date_form_width" onchange="this.form.submit()"> -->

                        <div class="page-title-box d-flex align-items-center  flex-wrap">
                                                    @if($type == 'daily')
                                                    <h4 class="mb-0 px-2">Today Earning  </h4>
                                                    <input type="date" value="{{$filter}}" name="filter" value="" id="example-date-input" class="form-control date_form_width" onchange="this.form.submit()">
                                                    @elseif($type == 'weekly')
                                                     <h4 class="mb-0 px-2">This Week Shipment </h4>
                                                    <input type="week"  value="{{$filter}}" name="filter" value="" id="example-week-input" class="form-control date_form_width" onchange="this.form.submit()">
                                                    @elseif($type == 'monthly')
                                                    <h4 class="mb-0 px-2">This Month Shipment </h4>
                                                    <input type="month" value="{{$filter}}" name="filter" value="" id="example-month-input" class="form-control date_form_width" onchange="this.form.submit()">
                                                    @endif
                                               
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

                    <div class="row mb-5 mt-3">
                        <div class="col-md-6">
                            <h4 class="card-title">Transactions List</h4>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary pull-right export_to_excel">Export To Excel</button>
                        </div>
                     
                    </div>

                    <!-- Nav tabs -->
    

                <!-- Tab panes -->
                 
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive mb-4 px-3">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th>Date</th>
                                                <th>Transaction ID</th>
                                                <th>Amount</th>
                                                <th>Payment Mode</th>
                                                <th>Merchant Name</th>
                                                <th>Business Name</th>
                                                <th>Status</th>
                                                <!-- <th>Pay Amount</th> -->
                                                <th class="noExl">Payment Invoice</th>
                                                <th class="noExl">Send Invoice</th>
                                                <!-- <th>Details</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($merchantpaymentlist as $value)
                                            <tr>
                                                <td>{{date('d M,Y',strtotime($value->created_at))}}

                                                   <div id="payment{{$value->id}}" class="modal fade show" role="dialog">
                                                  <div class="modal-dialog">

                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h4 class="modal-title">Payment Invoice</h4>
                                                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr class="bg-transparent">
                                                                        <th>Shipment ID</th>
                                                                        <th>COD Amount</th>
                                                                        <th>Shipment Cost</th>
                                                                        <th>Available Balance</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($value->shipment as $shipment)
                                                                    <tr>
                                                                        <td>{{$shipment->shipment_no}}</td>
                                                                        <td>{{$shipment->cod_amount}}</td>
                                                                        <td>{{$shipment->shipment_cost}}</td>
                                                                        <td>{{$shipment->cod_amount - $shipment->shipment_cost}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                          </div>
                                                      </div>
                        
                                                    </div>

                                                  </div>
                                                </div>
                                                </td>
                                                <td>{{$value->txn_id}}</td>
                                                <td>{{$value->amount}}</td>
                                                <td>
                                                 <!--  {{($value->payment_method == 0)?"Cash":"Card"}} -->
                                                  {{payment_mode($value->payment_mode)}}
                                                </td>
                                                <td>{{$value->merchant_name}}</td>
                                                <td>{{$value->buss_name}}</td>
                                                <td> {{($value->status == 0)?"Pending":"Done"}}</td>
                                                <!-- <td>{{config('constants.currency')}}{{$value->pay_amount}}</td> -->
                                                <td class="noExl"><button type="button" class="btn btn-primary trans_view" data-toggle="modal" data-target="#payment{{$value->id}}">View</button>
                                              
                                                </td>
                                                 <td class="noExl">
                                                   <button class="btn btn-success send_invoice" data-txnid="{{$value->txn_id}}" data-mid="{{$value->merchant_id}}">Send Invoice</button></td>

                                              


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

</div> <!-- container-fluid -->


<!-- End Page-content -->
@endsection
@section('header_styles')
<style type="text/css">
    /*.modal-body .dataTables_length,.modal-body .dataTables_filter,.modal-body .dataTables_info,.modal-body .dataTables_paginate
    {
       display: none !important;
    }*/
</style>
@endsection
@section('footer_scripts')
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://www.jqueryscript.net/demo/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel/src/jquery.table2excel.js"></script>

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
    });

  $(".export_to_excel").click(function(){
  var exTable = $('.table-card-list').clone();
    //remove the action th/td
  exTable.find('.noExl').remove();

  $(exTable).table2excel({
    // exclude CSS class
    exclude:".noExl",
    name:"Merchant Transactions List",
    filename:"Transaction List",//do not include extension
    fileext:".xls" // file extension
  });
});

 $(document).on( 'click', 'tr td button.send_invoice', function postinput(){
            if (confirm('Are you sure , you want to send invoice on merchant email?')) {
                   var merchant_id = $(this).attr('data-mid'); // this.value
                   var txnid = $(this).attr('data-txnid'); // this.value
                   var _token = $('input[name="_token"]').attr('value'); // this.value
                   var url = "<?php echo url('/').'/admin/send-invoice';?>"
                                $.ajax({ 
                                    url: url,
                                    type: 'POST',
                                    method: 'POST',
                                     headers: {
                                            'X-CSRF-Token': _token 
                                       },
                                    data: jQuery.param({ txnid : txnid,merchant_id : merchant_id, _token : _token}) ,
                                }).done(function(responseData) {
                                  //location.reload(); 
                                  if(responseData.status == true)
                                  {
                                  	alert(responseData.msg);
                                  }
                                   if(responseData.status == false)
                                  {
                                  	alert(responseData.msg);
                                  } 
                                }).fail(function() {
                                    console.log('Failed');
                                }); 
                     } else {
                    //alert('Why did you press cancel? You should have confirmed');
                }  
                               
          });

  </script>
@endsection