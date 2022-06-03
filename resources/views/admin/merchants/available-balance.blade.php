@extends('admin.layouts.main')
@section('title', 'Manage Merchants Available Balance')
@section('content')
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">All Merchant Available Balance</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">  
                            <div class="card">
                            <div class="card-body">
                            <div class="col-lg-12">
      
                            <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active"  data-bs-toggle="tab" href="#nav-active"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Positive Merchants</span>
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#nav-block"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Negative Merchants</span>
                                        </a>
                                    </li>
                                 
                                </ul> 
                                 <div class="tab-content p-3 text-muted">
                                       <div class="tab-pane active" id="nav-active" role="tabpanel">
                                            <div class="table-responsive mb-4">
                                                <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                                    <thead>
                                                        <tr class="bg-transparent">
                                                            <th>Merchant  ID</th>
                                                            <th>Merchant  Name</th>
                                                            <th>Available Balance</th>
                                                            <th>Pay</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($positive_merchants as $m)
                                                        <tr {{--style="background-color: @if($m->available_balance < 0) #FF6251 @else #B2DD8B @endif"--}}>
                                                            <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{$m->mrid}}</a></td>
                                                            <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{ucwords($m->name)}}</a></td>
                                                            <td>{{$m->available_balance}}</td>                                                
                                                            <td><a href="{{route('admin.merchant_payment')}}/{{$m->id}}" class="btn btn-success">Pay</a></td>                                                
                                        
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                         <div class="tab-pane" id="nav-block" role="tabpanel">
                                            <div class="table-responsive mb-4">
                                                <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                                    <thead>
                                                        <tr class="bg-transparent">
                                                            <th>Merchant  ID</th>
                                                            <th>Merchant  Name</th>
                                                            <th>Available Balance</th>
                                                              <th>Pay</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($negative_merchants as $m)
                                                        <tr {{--style="background-color: @if($m->available_balance < 0) #FF6251 @else #B2DD8B @endif"--}}>
                                                            <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{$m->mrid}}</a></td>
                                                            <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{ucwords($m->name)}}</a></td>
                                                            <td>{{$m->available_balance}}</td>  
                                                            <td><a href="{{route('admin.merchant_payment')}}/{{$m->id}}" class="btn btn-success">Collected</a></td>                                              
                                        
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                   
                                    
                                <!-- end table -->
                            </div>
                        </div>  </div> 
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
