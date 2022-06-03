@extends('admin.layouts.main')
@section('title', 'Shipment Reports')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                
                                <div class="page-title-box d-flex align-items-center  flex-wrap">
                                    @if($type=='daily')
                                    <h4 class="mb-0 px-2">Today Shipment  </h4>
                                    <input type="date" value="" id="example-date-input" class="form-control date_form_width">
                                    @elseif($type=='weekly')
                                    <h4 class="mb-0 px-2">This Week Shipment </h4>
                                    <input type="week" value="" id="example-week-input" class="form-control date_form_width">
                                    @else
                                    <h4 class="mb-0 px-2">This Month Shipment </h4>
                                    <input type="month" value="" id="example-month-input" class="form-control date_form_width">
                                    @endif
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
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">50</span></h4>
                                            <p class="text-muted mb-0">Total Orders</p>
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
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">38</span></h4>
                                            <p class="text-muted mb-0">Deliverd Order </p>
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
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">5</span></h4>
                                            <p class="text-muted mb-0">On-going Order </p>
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
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">2</span></h4>
                                            <p class="text-muted mb-0">Return Order </p>
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
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">5</span></h4>
                                            <p class="text-muted mb-0">Cancel Order </p>
                                        </div>
                                        <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            
                        </div> 
                        <!-- start page title -->
                        
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                
                                <div class="table-responsive mb-4">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                
                                                <th width="10%">Date</th>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                               <!--  <th>Seller Name</th> -->
                                                <th>merchant Name</th>
                                                <th>Order Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shipments as $s)
                                            <tr>
                                                
                                                <td width="10%">{{$s->date}}</td>
                                                <td width="10%">{{$s->shipment_no}}</td>
                                                <td width="20%">{{$s->product_detail}}</td>
                                                <!-- <td>{{$s->shipment_no}}</td> -->
                                                <td width="10%">{{$s->merchant_name}}</td>
                                                <td width="10%">{{$s->status}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
