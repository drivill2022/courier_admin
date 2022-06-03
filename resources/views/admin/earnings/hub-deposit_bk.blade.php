@extends('admin.layouts.main')
@section('title', 'Hub Deposit')
@section('content')
@php $active = Request::segment(3); @endphp
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Hub Deposit</h4>
                                    
                                    

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                        <div class="row">
                            <div class="col-lg-12">
                                

                                <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All Hub Deposit</h4>

                                    
                                   <!-- Nav tabs -->
                    <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link @if($active == 'daily') active @endif" href="{{ route('admin.hub_deposit',['daily']) }}"
                                role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Daily </span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link @if($active == 'weekly') active @endif" href="{{ route('admin.hub_deposit',['weekly']) }}"
                                role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Weekly </span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link @if($active == 'monthly') active @endif" href="{{ route('admin.hub_deposit',['monthly']) }}" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Monthly</span>
                            </a>
                        </li>
                        
                        
                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                       
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{ route('admin.hub_deposit',[$active]) }}" method="POST">@csrf

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
                                             <!-- end col-->

                                                <div class="col-md-6 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="float-end mt-2">
                                                            <div id="total-revenue-chart"></div>
                                                        </div>
                                                        <div>
                                                            <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{$deposit_amount}}</span></h4>
                                                            <p class="text-muted mb-0">Total Deposit Amount</p>
                                                        </div>
                                                       <!--  <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
                                                        </p> -->
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
                                                <th>Date</th>
                                                <th>Hub Name</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Change Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hubDepositList as $value)
                                            <tr style="background-color: @if($value->status == 0) #FF6251 @else #B2DD8B @endif">
                                                <td>{{date('d M,Y',strtotime($value->created_at))}}</td>
                                                <td>{{$value->hub_name}}</td>
                                                <td> {{($value->status == 0)?"Unpaid":"Paid"}}</td>
                                                <td>{{config('constants.currency')}}{{$value->amount}}</td>
                                                <td>
                                                    @csrf
                                                    <select class="form-control status_change" data-id="{{$value->id}}" width="100px">
                                                        <option value="0" @if($value->status == 0)selected @endif>Unpaid</option>
                                                        <option value="1" @if($value->status == 1)selected @endif>Paid</option>
                                                    </select>
                                                </td>
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
        $(document).ready(function(){ 
           $(".status_change").on('change', function postinput(){
            if (confirm('Are you sure , you want to change status')) {
                   var status_change = $(this).val(); // this.value
                   var id = $(this).attr('data-id'); // this.value
                   var _token = $('input[name="_token"]').attr('value'); // this.value
                   var url = "<?php echo url('/').'/admin/changeHubDepositStatus';?>"
                                $.ajax({ 
                                    url: url,
                                    type: 'POST',
                                    method: 'POST',
                                     headers: {
                                            'X-CSRF-Token': _token 
                                       },
                                    data: jQuery.param({ status : status_change, id : id, _token : _token}) ,
                                }).done(function(responseData) {
                                  location.reload();  
                                }).fail(function() {
                                    console.log('Failed');
                                }); 
                     } else {
                    //alert('Why did you press cancel? You should have confirmed');
                }  
                               
          });
        });
</script>
@endsection
