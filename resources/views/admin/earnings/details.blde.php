@extends('admin.layouts.main')
@section('title', 'Earnings Details')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Transaction Details</h4>



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
                                                        <th scope="row" style="width: 20%;">Product ID</th>
                                                        <td>#ABC0121</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Product  Name</th>
                                                        <td>Mobile</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Seller Name</th>
                                                        <td>Jacob Hunter</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Seller Address</th>
                                                        <td>California</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Seller Contact Number</th>
                                                        <td>+ 44321564</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Merchant Name</th>
                                                        <td>Ekart</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Customer Name</th>
                                                        <td> Marie Kim</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Earning Form Seller </th>
                                                        <td>$5</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Earning Form Merchant </th>
                                                        <td>$5</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Earning Form Customer </th>
                                                        <td>$5</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Earning </th>
                                                        <td>$15</td>
                                                    </tr>


                                                    <tr>
                                                        <th scope="row">Status</th>
                                                        <td>Delivered</td>
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
