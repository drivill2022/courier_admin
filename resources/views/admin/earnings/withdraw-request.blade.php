@extends('admin.layouts.main')
@section('title', 'Withdraw Request')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-5 mt-3">
                        <div class="col-md-6">
                            <h4 class="card-title">Withdraw Request List</h4>
                        </div>
                     
                    </div>

                    <!-- Nav tabs -->
    

                <!-- Tab panes -->
                 
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive mb-4 px-3">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th>Date</th>
                                                <th>Merchant Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($merchantwithdrawlist as $value)
                                            @if($value->pay_amount != 0)
                                            <tr>
                                                <td>{{date('d M,Y',strtotime($value->created_at))}}</td>
                                                <td>{{$value->name}}</td>
                                                <td>
                                                 <a href="{{route('admin.merchant_payment')}}/{{$value->merchant_id}}">
   												  <button type="button" class="btn btn-success waves-effect waves-light mb-3">Pay</button>
   												 </a>
   												</td>
                                            </tr>
                                            @endif
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                        </div>
                 
                
                </div>

            </div>
        </div>
    </div>

</div> <!-- container-fluid -->
<!-- End Page-content -->
@endsection
