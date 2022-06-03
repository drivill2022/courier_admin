@extends('admin.layouts.main')
@section('title', 'Settlements')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="col-xl-12">


            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Settlement</h4>

                    <!-- Nav tabs -->
                    <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-bs-toggle="tab" href="#navpills2-home"
                            role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Daily</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-profile" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Weekly</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-messages" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Monthly</span>
                        </a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="navpills2-home" role="tabpanel">

                        <div class="row">
                            <div class="col-md-6 col-xl-4">
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
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end mt-2">
                                            <div id="orders-chart"> </div>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1">$<span data-plugin="counterup">500</span></h4>
                                            <p class="text-muted mb-0">Online Pay </p>
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
                                            <h4 class="mb-1 mt-1">$<span data-plugin="counterup">500</span></h4>
                                            <p class="text-muted mb-0">COD </p>
                                        </div>
                                        <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                        </p>
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

                                                <th>Product ID</th>
                                                <th>Seller ID</th>
                                                <th>Merchant ID</th>
                                                <th>Hub ID</th>
                                                <th>Rider ID</th>
                                                <th>Order Status</th>
                                                <th>COD/Online Pay</th>
                                                <th>Serivce Charge</th>
                                                <th>Settlement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>
                                            <tr>


                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>
                                            <tr>


                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>
                                            <tr>


                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
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
                            <div class="col-md-6 col-xl-4">
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
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end mt-2">
                                            <div id="orders-chart"> </div>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1">$<span data-plugin="counterup">500</span></h4>
                                            <p class="text-muted mb-0">Online Pay </p>
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
                                            <h4 class="mb-1 mt-1">$<span data-plugin="counterup">500</span></h4>
                                            <p class="text-muted mb-0">COD </p>
                                        </div>
                                        <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive mb-4 px-3">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">

                                                <th>Product ID</th>
                                                <th>Seller ID</th>
                                                <th>Merchant ID</th>
                                                <th>Hub ID</th>
                                                <th>Rider ID</th>
                                                <th>Order Status</th>
                                                <th>COD/Online Pay</th>
                                                <th>Serivce Charge</th>
                                                <th>Settlement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>
                                            <tr>


                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>
                                            <tr>


                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>
                                            <tr>


                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="navpills2-messages" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 col-xl-4">
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
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end mt-2">
                                            <div id="orders-chart"> </div>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1">$<span data-plugin="counterup">500</span></h4>
                                            <p class="text-muted mb-0">Online Pay </p>
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
                                            <h4 class="mb-1 mt-1">$<span data-plugin="counterup">500</span></h4>
                                            <p class="text-muted mb-0">COD </p>
                                        </div>
                                        <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive mb-4 px-3">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">

                                                <th>Product ID</th>
                                                <th>Seller ID</th>
                                                <th>Merchant ID</th>
                                                <th>Hub ID</th>
                                                <th>Rider ID</th>
                                                <th>Order Status</th>
                                                <th>COD/Online Pay</th>
                                                <th>Serivce Charge</th>
                                                <th>Settlement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>
                                            <tr>


                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>
                                            <tr>


                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
                                            </tr>
                                            <tr>


                                                <td>#25AB098765</td>
                                                <td>#ABC12</td>
                                                <td>#XYX12</td>
                                                <td>#HH54321</td>
                                                <td>#RR54321</td>
                                                <td>Delivered</td>
                                                <td>
                                                    COD
                                                </td>
                                                <td>$5</td>
                                                <td><a href="Settlement-account.html"><button class="btn btn-primary">Settlement</button></a></td>
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