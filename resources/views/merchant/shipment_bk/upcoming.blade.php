@extends('merchant.layouts.main')
@section('title', 'Upcoming Shipment')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Upcoming Shipments</h4>
                                     
                                </div>
                            </div>
                            
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                
                                <div class="table-responsive mb-4">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th>Pickup Date</th>
                                                <th>Shipping Number</th>
                                                {{-- <th>Seller Business Name</th> --}}
                                                {{-- <th>Type of Product</th> --}}
                                                <th>Receiver Name</th>                                                
                                                <th>Delivery Address</th>                                                
                                                <th>Action</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shipments as $sp)
                                            <tr>
                                                <td>{{MydateTime($sp->pickup_date)}}</td>
                                                <td>{{$sp->shipment_no}}</td>
                                                <td>{{$sp->receiver_name}}</td>
                                                <td>{{$sp->d_address}}</td>
                                                <td>
                                                    <a href="{{ route('merchant.shipment.edit',$sp->id) }}">
                                                        <button class="btn btn-primary">Cancel Order/Status Order/Report Claim</button>
                                                    </a>
                                                </td> 
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
