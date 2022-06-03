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
                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">{{$total_pay}}</span></h4>
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
                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">{{$merchant_total_pay}}</span></h4>
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
                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">{{$rider_total_pay}}</span></h4>
                                <p class="text-muted mb-0">Earning Form Rider </p>
                            </div>
                            <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                            </p> -->
                        </div>
                    </div>
                </div> <!-- end col-->

                <!-- <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2">
                                <div id="customers-chart"> </div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">500</span></h4>
                                <p class="text-muted mb-0">Earning Form Sellers </p>
                            </div>
                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                            </p>
                        </div>
                    </div>
                </div> -->

               <!--  <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2">
                                <div id="customers-chart"> </div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">200</span></h4>
                                <p class="text-muted mb-0">Earning Form Customers </p>
                            </div>
                           <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                            </p>
                        </div>
                    </div>
                </div> --> <!-- end col-->


            </div> 

            <div class="card">
                <div class="card-body">
                    <div class="row mb-5 mt-3">
                        <div class="col-md-6">
                            <h4 class="card-title">Transactions List</h4>
                        </div>
                       <!--  <div class="col-md-6">
                            <input class="form-control" type="date" value="2019-08-19" id="example-date-input">
                        </div> -->
                    </div>

                    <!-- Nav tabs -->
                    <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                       <!--  <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-bs-toggle="tab" href="#navpills2-home"
                            role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">All Transactions</span>
                        </a>
                    </li> -->
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#navpills2-profile" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Merchant Transactions</span>
                        </a>
                    </li>
                     <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpills2-rider"
                            role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Rider Transactions</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-messages" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Seller Transactions</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-settings" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block">Customer Transactions</span>
                        </a>
                    </li> -->
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <!-- <div class="tab-pane active" id="navpills2-home" role="tabpanel">

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive mb-4">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">

                                                <th>Date</th>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>Seller Name</th>
                                                <th>Merchant Name</th>
                                                <th>Customer Name</th>
                                                <th>Order Status</th>
                                                <th>Earned</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                              
                            </div>
                        </div>
                    </div> -->
                    <div class="tab-pane active" id="navpills2-profile" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive mb-4 px-3">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th>Date</th>
                                                <th>Transaction ID</th>
                                                <th>Payment Mode</th>
                                                <th>Merchant Name</th>
                                                <th>Status</th>
                                                <th>Pay Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($merchantpaymentlist as $value)
                                            <tr>
                                                <td>{{date('d M,Y',strtotime($value->created_at))}}</td>
                                                <td>{{$value->txn_id}}</td>
                                                <td>
                                                  {{($value->payment_method == 0)?"Cash":"Card"}}
                                                </td>
                                                <td>{{$value->merchant_name}}</td>
                                                <td> {{($value->status == 0)?"Pending":"Done"}}</td>
                                                <td>${{$value->pay_amount}}</td>
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="navpills2-rider" role="tabpanel">
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
                                                <td>${{$value->pay_amount}}</td>
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
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

                                                <th>Date</th>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>Seller Name</th>
                                                <th>Merchant Name</th>
                                                <th>Customer Name</th>
                                                <th>Order Status</th>
                                                <th>Earned</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="navpills2-settings" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive mb-4 px-3">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">

                                                <th>Date</th>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>Seller Name</th>
                                                <th>Merchant Name</th>
                                                <th>Customer Name</th>
                                                <th>Order Status</th>
                                                <th>Earned</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
                                            </tr>
                                            <tr>

                                                <td>15 Aug,2020</td>
                                                <td><a href="earning-transaction-details.html">#25AB54321</a></td>
                                                <td><a href="earning-transaction-details.html">Mobile</a></td>
                                                <td>Jacob Hunter</td>
                                                <td>Sonya Henshaw</td>
                                                <td>
                                                    Marie Kim
                                                </td>
                                                <td>Deliverd</td>
                                                <td>$10</td>
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

</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection
