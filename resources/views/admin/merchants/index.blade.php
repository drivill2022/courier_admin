@extends('admin.layouts.main')
@section('title', 'Manage Merchants')
@section('content')
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">All Merchants</h4>
                                    <a href="{{ route('admin.merchants.create') }}">
                                    <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add Merchant</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">  
                            <div class="card">
                            <div class="card-body">
                            <div class="col-md-12"><div class="row">  
                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end mt-2">
                                            <div id="total-revenue-chart"></div>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$active_merchants->count()}}</span></h4>
                                            <p class="text-muted mb-0">Total Active</p>
                                        </div>
                
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end mt-2">
                                            <div id="orders-chart"> </div>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$block_merchants->count()}}</span></h4>
                                            <p class="text-muted mb-0">Total Blocked</p>
                                        </div>
                                
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end mt-2">
                                            <div id="customers-chart"> </div>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{$pending_merchants->count()}}</span></h4>
                                            <p class="text-muted mb-0">Total Pending</p>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div></div></div>

                            <div class="col-lg-12">
                                <div>
                                            
                                  <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active"  data-bs-toggle="tab" href="#nav-active"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Active</span>
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#nav-block"
                                            role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Blocked</span>
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#nav-pending" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Pending</span>
                                        </a>
                                    </li>
                                    
                                    
                                </ul> 
                                    
                                </div>
                                <div class="tab-content p-3 text-muted">
                                       <div class="tab-pane active" id="nav-active" role="tabpanel">
                                            <div class="table-responsive mb-4">
                                                <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                                    <thead>
                                                        <tr class="bg-transparent">
                                                        	<th style="width: 30px;">Business Logo</th>
                                                            <th style="width: 20px;">Merchant Photo</th>
                                                            <th>Merchant  ID</th>
                                                            <!-- <th>Merchant  Name</th> -->
                                                             <th>Merchant Business Name</th>
                                                            <th>Contact No.</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($active_merchants as $m)
                                                        <tr>
                                                        	<td>
                                                                <img src="{{img($m->business_logo)}}" class="avatar-xs rounded-circle me-2">
                                                            </td>
                                                            <td>
                                                                <img src="{{img($m->picture)}}" class="avatar-xs rounded-circle me-2">
                                                            </td>
                                                            
                                                            <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{$m->mrid}}</a></td>
                                                            <!-- <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{ucwords($m->name)}}</a></td> -->
                                                             <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{ucwords($m->buss_name)}}</a></td>
                                                            <td>{{ucwords($m->mobile)}}</td>                                                
                                                            <td class="d-flex">
                                                                <a href="{{ route('admin.merchants.edit',$m->id) }}" class="btn btn-primary px-2 mx-1"><i class="uil uil-pen font-size-15">Edit</i></a>
                                                                 <a href="{{ route('admin.merchants.show',$m->id) }}" class="btn btn-primary px-2 mx-1"><i class="uil uil-eye font-size-15">View</i></a>
                                                                <form action="{{ route('admin.merchants.destroy', $m->id) }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                 <button class="px-3 mx-1 btn btn-danger" onclick="return confirm('Are you sure you want to delete this account?')" > <i class="uil uil-trash-alt font-size-18"></i>Delete</button>
                                                            </form> 
                                                            </td>
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
                                                            <th style="width: 30px;">Business Logo</th>
                                                            <th style="width: 20px;">Merchant Photo</th>
                                                            <th>Merchant  ID</th>
                                                            <!-- <th>Merchant  Name</th> -->
                                                            <th>Merchant Business Name</th>
                                                            <th>Contact No.</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($block_merchants as $m)
                                                        <tr>
                                                            <td>
                                                                <img src="{{img($m->business_logo)}}" class="avatar-xs rounded-circle me-2">
                                                            </td>
                                                            <td>
                                                                <img src="{{img($m->picture)}}" class="avatar-xs rounded-circle me-2">
                                                            </td>
                                                            
                                                            <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{$m->mrid}}</a></td>
                                                           <!--  <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{ucwords($m->name)}}</a></td> -->
                                                            <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{ucwords($m->buss_name)}}</a></td>
                                                            <td>{{ucwords($m->mobile)}}</td>                                                
                                                            <td class="d-flex">
                                                                <a href="{{ route('admin.merchants.edit',$m->id) }}" class="btn btn-primary px-2 mx-1"><i class="uil uil-pen font-size-15">Edit</i></a>
                                                                 <a href="{{ route('admin.merchants.show',$m->id) }}" class="btn btn-primary px-2 mx-1"><i class="uil uil-eye font-size-15">View</i></a>
                                                                <form action="{{ route('admin.merchants.destroy', $m->id) }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                 <button class="px-3 mx-1 btn btn-danger" onclick="return confirm('Are you sure you want to delete this account?')" > <i class="uil uil-trash-alt font-size-18"></i>Delete</button>
                                                            </form> 
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                     <div class="tab-pane" id="nav-pending" role="tabpanel">
                                            <div class="table-responsive mb-4">
                                                <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                                    <thead>
                                                        <tr class="bg-transparent">
                                                            <th style="width: 30px;">Business Logo</th>
                                                            <th style="width: 20px;">Merchant Photo</th>
                                                            <th>Merchant  ID</th>
                                                            <!-- <th>Merchant  Name</th> -->
                                                            <th>Merchant Business Name</th>
                                                            <th>Contact No.</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($pending_merchants as $m)
                                                        <tr>
                                                            <td>
                                                                <img src="{{img($m->business_logo)}}" class="avatar-xs rounded-circle me-2">
                                                            </td>
                                                            <td>
                                                                <img src="{{img($m->picture)}}" class="avatar-xs rounded-circle me-2">
                                                            </td>
                                                            
                                                            <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{$m->mrid}}</a></td>
                                                            <!-- <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{ucwords($m->name)}}</a></td> -->
                                                             <td><a href="{{ route('admin.merchants.show',$m->id) }}">{{ucwords($m->buss_name)}}</a></td>
                                                            <td>{{ucwords($m->mobile)}}</td>                                                
                                                            <td class="d-flex">
                                                                <a href="{{ route('admin.merchants.edit',$m->id) }}" class="btn btn-primary px-2 mx-1"><i class="uil uil-pen font-size-15">Edit</i></a>
                                                                 <a href="{{ route('admin.merchants.show',$m->id) }}" class="btn btn-primary px-2 mx-1"><i class="uil uil-eye font-size-15">View</i></a>
                                                                <form action="{{ route('admin.merchants.destroy', $m->id) }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                 <button class="px-3 mx-1 btn btn-danger" onclick="return confirm('Are you sure you want to delete this account?')" > <i class="uil uil-trash-alt font-size-18"></i>Delete</button>
                                                            </form> 
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                </div>
                                <!-- end table -->
                            </div>
                        </div>  </div>  </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
