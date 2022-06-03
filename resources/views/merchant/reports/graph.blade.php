@extends('merchant.layouts.main')
@section('title', 'Delivery Area Graph')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Delivery Chart</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Delivery Chart</h4>
                                        
                                        <div id="bar_chart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>



                        <!-- end row -->

                        
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection
@section('footer_scripts')
<!-- apexcharts -->
<script src="{{admin_asset('libs/apexcharts/apexcharts.min.js')}}"></script>
<!-- apexcharts init -->
<script src="{{admin_asset('js/pages/apexcharts.init.js')}}"></script>
@endsection

