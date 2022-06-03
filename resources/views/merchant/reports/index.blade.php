@extends('merchant.layouts.main')
@section('title', 'Shipment Reports')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
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
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="total-revenue-chart"></div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1">$<span data-plugin="counterup">1000</span></h4>
                            <p class="text-muted mb-0">Total Earning</p>
                        </div>
                        <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <div id="total-revenue-chart"></div>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1">$<span data-plugin="counterup">100</span></h4>
                            <p class="text-muted mb-0">Total Service Chages Pay</p>
                        </div>
                        <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
                        </p>
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
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">50</span></h4>
                            <p class="text-muted mb-0">Total Orders</p>
                        </div>
                        <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                        </p>
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
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">42</span></h4>
                            <p class="text-muted mb-0">Deliverd Order </p>
                        </div>
                        <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                        </p>
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
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">5</span></h4>
                            <p class="text-muted mb-0">On-going Order </p>
                        </div>
                        <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                        </p>
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
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">2</span></h4>
                            <p class="text-muted mb-0">Total Return Order </p>
                        </div>
                        <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                        </p>
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
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">1</span></h4>
                            <p class="text-muted mb-0">Total Cancel Order </p>
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

                                <th>Date</th>
                                <th>Product ID</th>
                                <th>Rider Name</th>
                                <th>Receiver Name</th>
                                <th>Delivery Address</th>
                                <th>Contact No.</th>
                                <th>Order Status</th>
                                <th>Earned</th>
                                <th>Service Charge Pay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td>15 Aug,2020</td>
                                <td><a href="order-details.html">#25AB54321</a></td>
                                <td>Jacob Hunter</td>
                                <td>Sonya Henshaw</td>
                                <td>
                                    California
                                </td>
                                <td>+91 91652 45265</td>
                                <td>Deliverd</td>
                                <td>$10</td>
                                <td>$1</td>
                            </tr>
                            <tr>

                                <td>15 Aug,2020</td>
                                <td><a href="order-details.html">#25AB54321</a></td>
                                <td>Jacob Hunter</td>
                                <td>Sonya Henshaw</td>
                                <td>
                                    California
                                </td>
                                <td>+91 91652 45265</td>
                                <td>Deliverd</td>
                                <td>$10</td>
                                <td>$1</td>
                            </tr>
                            <tr>

                                <td>15 Aug,2020</td>
                                <td><a href="order-details.html">#25AB54321</a></td>
                                <td>Jacob Hunter</td>
                                <td>Sonya Henshaw</td>
                                <td>
                                    California
                                </td>
                                <td>+91 91652 45265</td>
                                <td>Deliverd</td>
                                <td>$10</td>
                                <td>$1</td>
                            </tr>




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
