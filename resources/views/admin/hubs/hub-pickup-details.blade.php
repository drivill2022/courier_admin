@extends('admin.layouts.main')
@section('title', 'Manage Hubs')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Hub Pickup Details</h4>
                                    
                                    

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                        <div class="row">
                            <div class="col-lg-12">
                                

                                <div class="card">
                                <div class="card-body">

                                    
                                    <!-- Nav tabs -->
                                    <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#navpills2-all"
                                                role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block"> Local Pickup</span>
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab" href="#navpills2-home"
                                                role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">Nationwide Pickup</span>
                                            </a>
                                        </li>
                                    
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active" id="navpills2-all" role="tabpanel">

                                        
                                            <div class="row">
                                             <!-- end col-->

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="orders-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">50</span></h4>
                                                                <p class="text-muted mb-0">Total Delivered Orders</p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                                                            </p>
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
                                                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">10</span></h4>
                                                                <p class="text-muted mb-0">Total Pending Orders </p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="customers-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">5</span></h4>
                                                                <p class="text-muted mb-0">Total Rejected Orders </p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="customers-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">200</span></h4>
                                                                <p class="text-muted mb-0">Total COD</p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                

                                                
                                            </div> 


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    
                                                    <div class="table-responsive mb-4">
                                                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                                            <thead>
                                                                <tr class="bg-transparent">
                                                                    
                                                                    <th>Date</th>
                                                                    <th>Product ID</th>
                                                                    <th>Product Name</th>
                                                                    <th>Hub Name</th>
                                                                    <th>Pickup Address</th>
                                                                    <th>Delivered Address</th>
                                                                    <th>Order Status</th>
                                                                    <th>COD</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    <td>Texas</td>
                                                                    <td>California</td>
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td><select  class="form-select form-control">
                                                                            <option > COD Received </option>
                                                                            <option > COD Missing </option>
                                                                            <option > COD Pending </option>


                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    <td>Texas</td>
                                                                    <td>California</td>
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td><select  class="form-select form-control">
                                                                            <option > COD Received </option>
                                                                            <option > COD Missing </option>
                                                                            <option > COD Pending </option>


                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    <td>Texas</td>
                                                                    <td>California</td>
                                                                    <td>Pending</td>
                                                                    <td>$10</td>
                                                                    <td><select  class="form-select form-control">
                                                                            <option > COD Received </option>
                                                                            <option > COD Missing </option>
                                                                            <option > COD Pending </option>


                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end table -->
                                                </div>
                                            </div>



                                        </div>
                                        <div class="tab-pane" id="navpills2-home" role="tabpanel">

                                            <div class="row">
                                             <!-- end col-->

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="orders-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">50</span></h4>
                                                                <p class="text-muted mb-0">Total Delivered Orders</p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                                                            </p>
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
                                                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">10</span></h4>
                                                                <p class="text-muted mb-0">Total Pending Orders </p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="customers-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">5</span></h4>
                                                                <p class="text-muted mb-0">Total Rejected Orders </p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-end mt-2">
                                                                <div id="customers-chart"> </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">200</span></h4>
                                                                <p class="text-muted mb-0">Total COD</p>
                                                            </div>
                                                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                

                                                
                                            </div> 


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    
                                                    <div class="table-responsive mb-4">
                                                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                                            <thead>
                                                                <tr class="bg-transparent">
                                                                    
                                                                    <th>Date</th>
                                                                    <th>Product ID</th>
                                                                    <th>Product Name</th>
                                                                    <th>Hub Name</th>
                                                                    <th>Pickup Address</th>
                                                                    <th>Delivered Address</th>
                                                                    <th>Order Status</th>
                                                                    <th>COD</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    <td>Texas</td>
                                                                    <td>California</td>
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td><select  class="form-select form-control">
                                                                            <option > COD Received </option>
                                                                            <option > COD Missing </option>
                                                                            <option > COD Pending </option>


                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    <td>Texas</td>
                                                                    <td>California</td>
                                                                    <td>Deliverd</td>
                                                                    <td>$10</td>
                                                                    <td><select  class="form-select form-control">
                                                                            <option > COD Received </option>
                                                                            <option > COD Missing </option>
                                                                            <option > COD Pending </option>


                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    
                                                                    <td>15 Aug,2020</td>
                                                                    <td>#25AB54321</td>
                                                                    <td>Mobile</td>
                                                                    <td>Jacob Hunter</td>
                                                                    <td>Texas</td>
                                                                    <td>California</td>
                                                                    <td>Pending</td>
                                                                    <td>$10</td>
                                                                    <td><select  class="form-select form-control">
                                                                            <option > COD Received </option>
                                                                            <option > COD Missing </option>
                                                                            <option > COD Pending </option>


                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                
                                                                
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
                            </div>
                        </div>


                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
