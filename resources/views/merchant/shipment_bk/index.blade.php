@extends('merchant.layouts.main')
@section('title', 'Manage Shipment')
@section('content')
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Shipment List</h4>
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
                                                <th>Shipment No.</th>
                                                <th>Receiver Name</th>
                                                <th>Contact No.</th>
                                                <th>Product Type</th>
                                                <th>Product Weight</th>
                                                <th>Pickup Address</th>
                                                <th>Delivery Address</th>
                                                <th>Shipment Cost / Type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shipments as $sp)
                                            <tr>
                                                <td>{{$sp->shipment_no}}</td>
                                                <td>{{$sp->receiver_name}}</td>
                                                <td>{{$sp->contact_no}}</td>
                                                <td>{{shipmentPType($sp->product_type)}}</td>
                                                <td>{{$sp->product_weight}}</td>
                                                <td>{{$sp->s_address}}</td>
                                                <td>{{$sp->d_address}}</td>
                                                <td>{{$sp->shipment_cost}} {{shipmentDType($sp->shipment_type)}}</td>
                                                <td>{{shipment_status($sp->status)}}</td>
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
