@extends('admin.layouts.main')
@section('title', 'View Hub')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ucwords($hub->name)}} Hub Details </h4>

                    <!-- <div class="">
                        <a href="hub-pickup_details.html">
                            <button class="btn btn-primary">Pickup Details</button>
                        </a>
                    </div> -->
                    <div class="">
                        <a href="{{ route('admin.hub_shipment_report','daily') }}/{{$hub->id}}">
                        <button class="btn btn-primary">Shipment Reports</button> 
                        </a>
                   </div>

                   
                    <div class="">
                        <a href="{{ route('admin.hub_earning_statement','daily') }}/{{$hub->id}}">
                        <button class="btn btn-primary">Earning Statements</button>

                        </a>
                 </div>
                  <div >
                        <a href="{{ route('admin.hubs.index') }}" class="pull-right">
                            <button class="btn btn-primary">< Back</button>
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

                                <div class="tab-content border border-top-0 p-4">

                                    <div class="tab-pane fade show active" id="specifi" role="tabpanel">
                                        <div class="table-responsive">
                                           
                                            <table class="table table-nowrap mb-0">
                                                <tbody>

                                                    <tr>
                                                        <th scope="row" style="width: 20%;">Hub ID</th>
                                                        <td>{{$hub->hbsid}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Hub Photo</th>
                                                        <td> @if($hub->picture)
                                                            <img src="{{img($hub->picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                                        @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Hub  Name</th>
                                                        <td>{{ucwords($hub->name)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Contact No.</th>
                                                        <td>{{trim($hub->phone)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Hub Address</th>
                                                        <td>{{trim($hub->address)}}</td>
                                                    </tr>
                                                     <tr>
                                                        <th scope="row">Home Address</th>
                                                        <td>{{trim($hub->home_address)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Supervisor Name</th>
                                                        <td>{{ucwords($hub->supervisor_name)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Supervisor Photo</th>
                                                        <td> @if($hub->sup_picture)
                                                            <img src="{{img($hub->sup_picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                                        @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Phone Number</th>
                                                        <td>{{trim($hub->sup_phone)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Supervisor NID Number</th>
                                                        <td>{{trim($hub->sup_nid_no)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Supervisor NID Photo</th>
                                                        <td> @if($hub->sup_nid_pic)
                                                            <img src="{{img($hub->sup_nid_pic)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                                        @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Supervisor TIN Number</th>
                                                        <td>{{trim($hub->sup_tin_no)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Supervisor TIN Photo</th>
                                                        <td> @if($hub->sup_tin_pic)
                                                            <img src="{{img($hub->sup_tin_pic)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                                        @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Trade licence photo</th>
                                                        <td> @if($hub->tl_picture)
                                                            <img src="{{img($hub->tl_picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                                        @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Delivery Riders</th>
                                                        <td>{{$hub->total_riders}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row"> Status</th>
                                                        <td>{{ucwords($hub->status)}}</td>
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
