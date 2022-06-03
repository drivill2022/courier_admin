@extends('admin.layouts.main')
@section('title', 'View Seller')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Seller Details</h4>
                    <div class="">
                        <a href="{{ route('admin.sellers.index') }}">
                            <button class="btn btn-primary">< Back</button> 
                        </a>
                    </div>
                    <div class="">
                        <a href="seller-shipment-report.html">
                            <button class="btn btn-primary">Shipment Reports</button> 
                        </a>
                    </div>

                    <div class="">
                        <a href="seller-earning-statement.html">
                            <button class="btn btn-primary">Earning Statements</button>

                        </a>
                    </div>


                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="mt-2">

                            <div class="product-desc">
                                <h5 class="pb-3 nav-tabs-custom">{{ucwords($seller->name)}}</h5>
                                <div class="tab-content border border-top-0 p-4">

                                    <div class="tab-pane fade show active" id="specifi" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" style="width: 20%;">Seller Photo</th>
                                                        <td>
                                                            <img src="{{img($seller->picture)}}" alt="" class="avatar-xs rounded-circle me-2">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="width: 20%;">Seller ID</th>
                                                        <td>{{$seller->slid}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Seller  Name</th>
                                                        <td>{{ucwords($seller->name)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Contact No.</th>
                                                        <td>{{$seller->mobile}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Seller Business Facebook Page</th>
                                                        <td>{{$seller->fb_page}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Seller Business Logo</th>
                                                        <td>
                                                            <img src="{{img($seller->business_logo)}}" alt="" class="avatar-xs rounded-circle me-2">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Seller Status</th>
                                                        <td>{{$seller->status}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Location</th>
                                                        <td>{{$seller->address}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Sales Products</th>
                                                        <td>{{seller_product_type($seller->id,'name',1)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Order </th>
                                                        <td>100</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Deliverd Order </th>
                                                        <td>80</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total On-going Order </th>
                                                        <td>10</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Return Order </th>
                                                        <td>5</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Cancel Order </th>
                                                        <td>5</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Account Number</th>
                                                        <td>1234567890</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
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
<!-- End Page-content -->

@endsection
