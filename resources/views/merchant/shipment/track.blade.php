@extends('merchant.layouts.main')
@section('title', 'Track Shipments')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Tracking Shipment</h4>
                                     
                                </div>
                            </div>
                            
                        </div>

                        <div class="row my-3">
                            <div class="col-md-6 offset-md-3">
                                <form action="">
                                    <div class="tracking_shipment_form">
                                        <div>
                                            <label class="form-label" for="shipment_no"> Please Enter Shipment No.:</label>
                                            <input id="shipment_no" name="shipment_no" type="text" class="form-control" placeholder ="#DC0001" value="{{$shipment_no}}">
                                        </div>
                                        <div>
                                           <input type="submit" class="btn btn-primary"> 
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                
                                <div class="table-responsive mb-4">
                                    <table class="table table-centered  dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th>Shipment Number</th>
                                                <th>Receiver Name</th>
                                                <th>Receiver Contact Number</th>
                                                <th>Delivery Address</th>
                                                <th>Order Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shipments as $sp)
                                            <tr> 
                                                <td><a href="{{ route('merchant.shipment.show',$sp->id) }}">{{$sp->shipment_no}}</a></td>
                                                <td>{{ucwords($sp->receiver_name)}}</td>
                                                <td>{{$sp->contact_no}}</td>
                                                <td>{{$sp->d_address}}</td>
                                                <td>{{shipment_status($sp->status)}}</td>
                                            </tr>
                                            @endforeach
                                            @if($shipments->count()<=0)
                                            <tr>
                                                <td colspan="4" align="center">No Record Available</td>
                                            </tr>
                                            @endif
                                            
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
