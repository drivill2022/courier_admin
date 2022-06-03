@extends('merchant.layouts.main')
@section('title', 'Upcoming Shipments')
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
                                <th>Shipment No.</th>
                                <th>Receiver Name</th>
                                <th>Contact No.</th>
                                <th>Delivery Address</th>
                                <th>Product Type</th>
                                <th>Cancel Shipment</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($shipments as $sp)
                           <tr>
                            <td><a href="{{ route('merchant.shipment.show',$sp->id) }}">{{$sp->shipment_no}}</a></td>
                            <td>{{ucwords($sp->receiver_name)}}</td>
                            <td>{{$sp->contact_no}}</td>
                            <td>{{$sp->d_address}}</td>
                            <td>{{shipmentProductType($sp->product_type)}}</td>
                            <td>
                                <a href="{{ route('merchant.shipment.cancel',$sp->id) }}">
                                    <button class="btn btn-danger">Cancel Shipment</button>
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
