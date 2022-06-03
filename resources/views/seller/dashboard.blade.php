@extends('seller.layouts.main')
@section('title', 'Dashboard')
@section('content')
<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
    <div class="page-title-box">
        <h4 class="mb-0" style="color: #fff">Hi, Welcome</h4>
        <p style="color: #fff">Dashboard</p>

    </div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-md-6 col-xl-3">
    <div class="card">
        <div class="card-body">
            <div class="float-end mt-2">
                <div id="total-revenue-chart"></div>
            </div>
            <div>
                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">34,152</span></h4>
                <p class="text-muted mb-0">Total Earnings</p>
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
                <h4 class="mb-1 mt-1"><span data-plugin="counterup">5,000</span></h4>
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
                <h4 class="mb-1 mt-1"><span data-plugin="counterup">4000</span></h4>
                <p class="text-muted mb-0">Total Delivered Orders </p>
            </div>
            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
            </p>
        </div>
    </div>
</div> <!-- end col-->

<div class="col-md-6 col-xl-3">

    <div class="card">
        <div class="card-body">
            <div class="float-end mt-2">
                <div id="growth-chart"></div>
            </div>
            <div>
                <h4 class="mb-1 mt-1"><span data-plugin="counterup">1000</span></h4>
                <p class="text-muted mb-0">On-going Orders</p>
            </div>
            <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>10.51%</span> since last week
            </p>
        </div>
    </div>
</div> <!-- end col-->
</div> <!-- end row-->

<div class="row">
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="float-end">
                <div class="dropdown">
                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5"
                        data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="fw-semibold">Sort By:</span> <span class="text-muted">Monthly<i class="mdi mdi-chevron-down ms-1"></i></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                        <a class="dropdown-item" href="#">Monthly</a>
                        <a class="dropdown-item" href="#">Yearly</a>
                        <a class="dropdown-item" href="#">Weekly</a>
                    </div>
                </div>
            </div>
            <h4 class="card-title mb-4">Orders Analytics</h4>

            <div class="mt-1">
                <ul class="list-inline main-chart mb-0">
                    <li class="list-inline-item chart-border-left me-0 border-0">
                        <h3 class="text-primary">$<span data-plugin="counterup">34,152</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Earning</span></h3>
                    </li>
                    <li class="list-inline-item chart-border-left me-0">
                        <h3><span data-plugin="counterup">5000</span><span class="text-muted d-inline-block font-size-15 ms-3">Orders</span>
                        </h3>
                    </li>
                    <li class="list-inline-item chart-border-left me-0">
                        <h3><span data-plugin="counterup">80</span>%<span class="text-muted d-inline-block font-size-15 ms-3">Delivered Ratio</span></h3>
                    </li>
                </ul>
            </div>

            <div class="mt-3">
                <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div> <!-- end col-->

<!-- end Col -->
</div> <!-- end row-->

<div class="row">
<div class="col-xl-6">
    <div class="card">
        <div class="card-body">
            <div class="float-end">
                <div class="dropdown">
                    <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted">All Members<i class="mdi mdi-chevron-down ms-1"></i></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                        <a class="dropdown-item" href="#">Locations</a>
                        <a class="dropdown-item" href="#">Revenue</a>
                        <a class="dropdown-item" href="#">Join Date</a>
                    </div>
                </div>
            </div>
            <h4 class="card-title mb-4">Top Sellers</h4>

            <div data-simplebar style="max-height: 336px;">
                <div class="table-responsive">
                    <table class="table table-borderless table-centered table-nowrap">
                        <tbody>
                            <tr>
                                <td style="width: 20px;"><img src="assets/images/users/avatar-4.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 fw-normal">Glenn Holden</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Nevada</p>
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i>$250.00</td>
                            </tr>
                            <tr>
                                <td><img src="assets/images/users/avatar-5.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 fw-normal">Lolita Hamill</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Texas</p>
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-danger" data-feather="trending-down"></i>$110.00</td>
                            </tr>
                            <tr>
                                <td><img src="assets/images/users/avatar-6.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 fw-normal">Robert Mercer</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i>$420.00</td>
                            </tr>
                            <tr>
                                <td><img src="assets/images/users/avatar-7.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 fw-normal">Marie Kim</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Montana</p>
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                            </tr>
                            <tr>
                                <td><img src="assets/images/users/avatar-8.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 fw-normal">Sonya Henshaw</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Colorado</p>
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i>$112.00</td>
                            </tr>
                            <tr>
                                <td><img src="assets/images/users/avatar-2.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 fw-normal">Marie Kim</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Australia</p>
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                            </tr>
                            <tr>
                                <td><img src="assets/images/users/avatar-1.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                <td>
                                    <h6 class="font-size-15 mb-1 fw-normal">Sonya Henshaw</h6>
                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> India</p>
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i>$112.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- enbd table-responsive-->
            </div> <!-- data-sidebar-->
        </div><!-- end card-body-->
    </div> <!-- end card-->
</div><!-- end col -->

<div class="col-xl-6">
    <div class="card">
        <div class="card-body">
            <div class="float-end">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="dropdownMenuButton3"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted">Recent<i class="mdi mdi-chevron-down ms-1"></i></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton3">
                        <a class="dropdown-item" href="#">Recent</a>
                        <a class="dropdown-item" href="#">By Users</a>
                    </div>
                </div>
            </div>

            <h4 class="card-title mb-4">Recent Activity</h4>

            <ol class="activity-feed mb-0 ps-2" data-simplebar style="max-height: 336px;">
                <li class="feed-item">
                    <div class="feed-item-list">
                        <p class="text-muted mb-1 font-size-13">Today<small class="d-inline-block ms-1">12:20 pm</small></p>
                        <p class="mt-0 mb-0">Andrei Coman magna sed porta finibus, risus
                            posted a new article: <span class="text-primary">Forget UX
                                Rowland</span></p>
                    </div>
                </li>
                <li class="feed-item">
                    <p class="text-muted mb-1 font-size-13">22 Jul, 2020 <small class="d-inline-block ms-1">12:36 pm</small></p>
                    <p class="mt-0 mb-0">Andrei Coman posted a new article: <span
                            class="text-primary">Designer Alex</span></p>
                </li>
                <li class="feed-item">
                    <p class="text-muted mb-1 font-size-13">18 Jul, 2020 <small class="d-inline-block ms-1">07:56 am</small></p>
                    <p class="mt-0 mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                        Commented <span class="text-primary"> Developer Moreno</span></p>
                </li>
                <li class="feed-item">
                    <p class="text-muted mb-1 font-size-13">10 Jul, 2020 <small class="d-inline-block ms-1">08:42 pm</small></p>
                    <p class="mt-0 mb-0">Zack Wetass, Chris combined Commented <span
                            class="text-primary">UX Murphy</span></p>
                </li>

                <li class="feed-item">
                    <p class="text-muted mb-1 font-size-13">23 Jun, 2020 <small class="d-inline-block ms-1">12:22 am</small></p>
                    <p class="mt-0 mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                        Commented <span class="text-primary"> Developer Moreno</span></p>
                </li>
                <li class="feed-item pb-1">
                    <p class="text-muted mb-1 font-size-13">20 Jun, 2020 <small class="d-inline-block ms-1">09:48 pm</small></p>
                    <p class="mt-0 mb-0">Zack Wetass, Chris combined Commented <span
                            class="text-primary">UX Murphy</span></p>
                </li>

            </ol>

        </div>
    </div>
</div>

</div>
<!-- end row -->


</div> <!-- container-fluid -->
</div>
@endsection
@push('script')
<!-- apexcharts -->
<script src="{{asset('public/backend/libs/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('public/backend/js/pages/dashboard.init.js')}}"></script>
@endpush