@extends('hub.layouts.main')
@section('title', 'Dashboard')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="mb-0">Hi, Welcome</h4>
                    <p>Dashboard</p>

                </div>
            </div>
        </div>
        <!-- end page title -->
      <div class="row">
        <div class="col-lg-6">
                                <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-6">
                                    <h4 class="mb-1">COD to Deposit: {{config('constants.currency')}} {{$res['cod_to_deposit']}}
                                    </h4>
                                     
                                   
                                </div>
                                  <!--   <div class="col-md-6">
                                        <h6 class="mt-4 mb-5">Drivills Commission:  {{config('constants.currency')}} {{$res['drivills_commission']}}
                                        </h6>
                                       
                                    </div> -->
                                </div>
                                 <!--  <form method="post" action="{{route('hub.deposit-amount')}}">
                                    <div class="row">
                                   
                                        @csrf
                                      <div class="col-md-9">
                                        <input type="number" name="amount" id="amount" class="form-control" required> 
                                        <span class="deposit_response"></span>
                                      </div>
                                      <div class="col-md-3">
                                       <button type="submit" class="btn btn-primary deposit_amount">Deposit</button>
                                      </div>
                                
                                   </div>
                                     </form> -->
                                </div>
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
                            <h4 class="mb-1 mt-1"><span>{{config('constants.currency')}} {{$res['total_earnings']}}</span></h4>
                            <p class="text-muted mb-0">Total Earnings</p>
                        </div>
                        <!-- <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
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
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$res['total_order']}}</span></h4>
                            <p class="text-muted mb-0">Total Shipments</p>
                        </div>
                       <!--  <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                        </p> -->
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
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$res['delivered']}}</span></h4>
                            <p class="text-muted mb-0">Total Delivered Shipments </p>
                        </div>
                       <!--  <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                        </p> -->
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
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$res['ongoingd']}}</span></h4>
                            <p class="text-muted mb-0">On-going Shipments</p>
                        </div>
                        <!-- <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>10.51%</span> since last week
                        </p> -->
                    </div>
                </div>
            </div> <!-- end col-->
        </div> <!-- end row-->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                       <!--  <div class="float-end">
                            <div class="dropdown">
                                <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="fw-semibold">Sort By:</span> <span class="text-muted">Monthly<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>

                         <div class="dropdown-menu dropdown-menu-end" id="filter" aria-labelledby="dropdownMenuButton5">
                                <a class="dropdown-item" href="#">Monthly</a>
                                <a class="dropdown-item" href="#">Yearly</a>
                                <a class="dropdown-item" href="#">Weekly</a>
                            </div> 

                            <select id="filter">
                                <option value="yearly">Yearly</option> 
                                <option value="weekly">Weekly</option>
                                  <option value="monthly">Monthly</option>
                            </select>

                        </div>
                    </div> -->

                    <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-bs-toggle="tab" href="#weekly_tab"
                            role="tab">
                            <span class="d-none d-sm-block">Weekly</span>
                        </a>
                      </li>
                       <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#monthly_tab"
                            role="tab">
                            <span class="d-none d-sm-block">Monthly</span>
                        </a>
                      </li>
                  </ul>
                  <div class="tab-content p-3 text-muted">
                     <div class="tab-pane active" id="weekly_tab" role="tabpanel">
                       <h4 class="card-title mb-4">Shipments Analytics</h4>
                    <div class="mt-1">
                        <ul class="list-inline main-chart mb-0">
                            <li class="list-inline-item chart-border-left me-0 border-0">
                                <h3 class="text-primary">{{config('constants.currency')}}<span class="total_earnings">0</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Earning</span></h3>
                            </li>
                            <li class="list-inline-item chart-border-left me-0">
                                <h3><span class="total_shipments">0</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Shipments</span>
                                </h3>
                            </li>
                            <li class="list-inline-item chart-border-left me-0">
                                <h3><span class="total_delivery_ratio">0</span>%<span class="text-muted d-inline-block font-size-15 ms-3">Delivered Ratio</span></h3>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-3">
                        <div class="sales-analytics" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
                <div class="tab-pane" id="monthly_tab" role="tabpanel">
                       <h4 class="card-title mb-4">Shipments Analytics</h4>
                    <div class="mt-1">
                        <ul class="list-inline main-chart mb-0">
                            <li class="list-inline-item chart-border-left me-0 border-0">
                                <h3 class="text-primary">{{config('constants.currency')}}<span class="total_earnings">0</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Earning</span></h3>
                            </li>
                            <li class="list-inline-item chart-border-left me-0">
                                <h3><span class="total_shipments">0</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Shipments</span>
                                </h3>
                            </li>
                            <li class="list-inline-item chart-border-left me-0">
                                <h3><span class="total_delivery_ratio">0</span>%<span class="text-muted d-inline-block font-size-15 ms-3">Delivered Ratio</span></h3>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-3">
                        <div class="sales-analytics" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <!-- end Col -->
    </div> <!-- end row-->

<!-- <div class="row">
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
</div> 
</div> 
</div>
</div>
</div>

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
-->

{{--<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Rider Details</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20px;">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                    </div>
                                </th>
                                <th>Rider ID</th>
                                <th>Rider Name</th>
                                <th>Date</th>
                                <th>Total Order Delivered </th>
                                <th>Order Status</th>
                                <th>View Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="customCheck7">
                                        <label class="form-check-label" for="customCheck7">&nbsp;</label>
                                    </div>
                                </td>
                                <td><a href="javascript: void(0);" class="text-body fw-bold">#MB2545</a> </td>
                                <td>Jacob Hunter</td>
                                <td>
                                    04 Oct, 2019
                                </td>
                                <td>
                                    $392
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="customCheck7">
                                        <label class="form-check-label" for="customCheck7">&nbsp;</label>
                                    </div>
                                </td>
                                <td><a href="javascript: void(0);" class="text-body fw-bold">#MB2545</a> </td>
                                <td>Jacob Hunter</td>
                                <td>
                                    04 Oct, 2019
                                </td>
                                <td>
                                    $392
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="customCheck7">
                                        <label class="form-check-label" for="customCheck7">&nbsp;</label>
                                    </div>
                                </td>
                                <td><a href="javascript: void(0);" class="text-body fw-bold">#MB2545</a> </td>
                                <td>Jacob Hunter</td>
                                <td>
                                    04 Oct, 2019
                                </td>
                                <td>
                                    $392
                                </td>

                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="customCheck7">
                                        <label class="form-check-label" for="customCheck7">&nbsp;</label>
                                    </div>
                                </td>
                                <td><a href="javascript: void(0);" class="text-body fw-bold">#MB2545</a> </td>
                                <td>Jacob Hunter</td>
                                <td>
                                    04 Oct, 2019
                                </td>
                                <td>
                                    $392
                                </td>
                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div>--}}
<!-- end row -->
</div> <!-- container-fluid -->
</div>
@endsection
@push('script')
<!-- apexcharts -->
<script src="{{asset('public/backend/libs/apexcharts/apexcharts.min.js')}}"></script>
<!-- <script src="{{asset('public/backend/js/pages/dashboard.init.js')}}"></script> -->
<script type="text/javascript">
$( document ).ready(function() {
 filter_type("weekly",'weekly_tab');
 filter_type("monthly",'monthly_tab');
/*$('#filter').on('change', function() {
        var filter = this.value; 
        filter_type(filter);
});*/
});

function filter_type(filter,id_name){
 $.ajax({
           type:'POST',
           url:"{{ route('hub.dashboard.filter') }}",
           data:{_token: "{{ csrf_token() }}",filter:filter},
           success:function(data){
              if(data.message == 'success')
              {
                $("#"+id_name+" .total_earnings").html(data.delivery_amount);
                $("#"+id_name+" .total_shipments").html(data.total_shipments);
                console.log(data);
                options = {
                    chart: {
                        height: 339,
                        type: "line",
                        stacked: !1,
                        toolbar: {
                            show: !1
                        }
                    },
                    stroke: {
                        width: [0, 2, 4],
                        curve: "smooth"
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: "30%"
                        }
                    },
                    colors: ["#5b73e8"/*, "#dfe2e6"*/, "#f1b44c"],
                    series: [{
                        name: "Delivered Order",
                       /* type: "column",*/
                        type: "area",
                        data: data.delivered
                    }/*, {
                        name: "Total Order",
                        type: "area",
                        data: data.total
                    }*/, {
                        name: "On-going",
                        type: "line",
                        data: data.ongoingd
                    }],
                    fill: {
                        opacity: [.85, .25, 1],
                        gradient: {
                            inverseColors: !1,
                            shade: "light",
                            type: "vertical",
                            opacityFrom: .85,
                            opacityTo: .55,
                            stops: [0, 100, 100, 100]
                        }
                    },
                    labels: data.date_array,
                    markers: {
                        size: 0
                    },
                    yaxis: {
                        title: {
                            /*text: "Percent"*/
                        }
                    },
                    tooltip: {
                        shared: !0,
                        intersect: !1,
                        y: {
                            formatter: function(e) {
                                return void 0 !== e ? e.toFixed(0) + " Shipments" : e
                            }
                        }
                    },
                    grid: {
                        borderColor: "#f1f1f1"
                    }
                };
                /*chart = new ApexCharts(document.querySelector("#sales-analytics-chart"), options);
                chart.destroy();*/
                let chart = new ApexCharts(document.querySelector("#"+id_name+" .sales-analytics"), options);
                chart.render();
                              }
           }
        });
}


 $('.deposit_amount').on('click', function(e) {
   // alert("Ggjghj");
       e.preventDefault(); 
       var amount = $('#amount').val();
       $.ajax({
           type: "POST",
           url: "{{route('hub.deposit-amount')}}",
           data: {amount:amount,_token: "{{ csrf_token() }}"},
           success: function( response ) {
              //alert(response.status)
               if(response.status == false)
               {
                 $(".deposit_response").html('<div class="text-danger">'+response.message+'</div>');
               }
               else if(response.status == true)
               {
                 $(".deposit_response").html('<div class="text-success">'+response.message+'</div>');
               }
           }
       });
   });
</script>
@endpush