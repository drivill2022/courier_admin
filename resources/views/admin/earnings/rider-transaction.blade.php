@extends('admin.layouts.main')
@section('title', 'Earnings')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="col-xl-12">
            <div class="row">
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

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2">
                                <div id="orders-chart"> </div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{$merchant_total_pay}}</span></h4>
                                <p class="text-muted mb-0">Earning Form Merchant </p>
                            </div>
                            <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                            </p> -->
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
                                <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{$rider_total_pay}}</span></h4>
                                <p class="text-muted mb-0">Earning Form Rider </p>
                            </div>
                            <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                            </p> -->
                        </div>
                    </div>
                </div> <!-- end col-->

               

            </div> 

            <div class="card">
                <div class="card-body">
                    <div class="row mb-5 mt-3">
                        <div class="col-md-6">
                            <h4 class="card-title">Transactions List</h4>
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
                                                <th>Payment Mode</th>
                                                <th>Rider Name</th>
                                                <th>Status</th>
                                                <th>Pay Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($riderpaymentlist as $value)
                                            <tr>
                                                <td>{{date('d M,Y',strtotime($value->created_at))}}</td>
                                                <td>{{$value->txn_id}}</td>
                                                <td>
                                                  {{($value->payment_method == 0)?"Cash":"Card"}}
                                                </td>
                                                <td>{{$value->rider_name}}</td>
                                                <td> {{($value->status == 0)?"Pending":"Done"}}</td>
                                                <td>{{config('constants.currency')}}{{$value->pay_amount}}</td>
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
