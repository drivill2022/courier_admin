<!doctype html>
<html lang="en">

<head>

        <meta charset="utf-8" />
        <title>Drivill</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
         <link href="assets/css/custom-style.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
         <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.1/css/line.css">
         <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    </head>

    
    <body>

    <!-- <body data-layout="horizontal" data-topbar="colored"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="dashboard.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/drivill/logo.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/drivill/logo.png" alt="" height="20">
                                </span>
                            </a>

                            <a href="dashboard.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/drivill/logo.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/drivill/logo.png" alt="" height="20">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="uil-search"></span>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil-search"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                    
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil-bell"></i>
                                <span class="badge bg-danger rounded-pill">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="m-0 font-size-16"> Notifications </h5>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small"> Mark all as read</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="#" class="text-reset notification-item">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="uil-shopping-basket"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="text-reset notification-item">
                                        <div class="d-flex align-items-start">
                                            <img src="assets/images/drivill/avatar-3.jpg"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1">James Lemire</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">It will seem like simplified English.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="text-reset notification-item">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                                    <i class="uil-truck"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1">Your item is shipped</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="#" class="text-reset notification-item">
                                        <div class="d-flex align-items-start">
                                            <img src="assets/images/drivill/avatar-4.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1">Salena Layfield</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                        <i class="uil-arrow-circle-right me-1"></i> View More..
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/drivill/avatar-4.jpg"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">Marcus</span>
                                <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="profile.html"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">View Profile</span></a>
                                
                                <a class="dropdown-item" href="#"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Sign out</span></a>
                            </div>
                        </div>

            
                    </div>
                </div>
            </header>
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="dashboard.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/drivill/logo.png" alt="" height="80">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/drivill/logo.png" alt="" height="80">
                        </span>
                    </a>

                    <a href="dashboard.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/drivill/logo.png" alt="" height="80">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/drivill/logo.png" alt="" height="80">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

                <div data-simplebar class="sidebar-menu-scroll">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                 
                        <div class="user_profile_section">
                            <div class="user_profile_section_details">
                                <img src="assets/images/drivill/avatar-4.jpg" class="img-fluid">
                                <h3>Marcus</h3>
                                <p>Admin</p>
                            </div>
                            <div class="user_profile_section_icons">
                                <ul>
                                    <li><a href="profile.html"><i class="fa fa-cog"></i></a></li>
                                    <li><a href="javascript: void(0)"><i class="bx uil-envelope"></i></a></li>
                                    <li><a href="javascript: void(0)"><i class="bx uil-user-circle"></i></a></li>
                                    <li><a href="javascript: void(0)"><i class="uil uil-sign-out-alt"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="dashboard.html">
                                    <i class="uil-home-alt"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="dripicons-store"></i>
                                    <span>Merchants</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    
                                    <li><a href="add-merchant.html">Add Merchant </a></li>
                                    <li><a href="merchant-list.html">All Merchants</a></li>
                                    <li><a href="blocked-merchant.html">Blocked Merchants </a></li>

                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa fa-shopping-bag "></i>
                                    <span>Sellers </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">

                                    <li><a href="add-seller.html">Add Seller  </a></li>
                                    <li><a href="seller-list.html">All Sellers</a></li>
                                    <li><a href="product-listing.html">Product Listing  </a></li>

                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa fa-motorcycle"></i>
                                    <span>Delivery Riders </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="add-delivery.html">Add Delivery Rider </a></li>
                                    <li><a href="delivery-list.html">All Delivery Riders</a></li>
                                    <li><a href="blocked-rider.html">Blocked Delivery Riders </a></li>

                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-window-section"></i>
                                    <span>Hubs</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="add-hub.html">Add Hub </a></li>
                                    <li><a href="hub-list.html">All Hubs </a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-user-circle"></i>
                                    <span>Customers</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="users.html">Registered Customers List </a></li>
                                    <li><a href="blocked-user.html">Blocked Customers </a></li>
                                </ul>
                            </li>



                            <li>
                                <a href="maps.html" class="waves-effect">
                                    <i class="uil-location-point"></i>
                                    <span>Maps</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-store"></i>
                                    <span>Shipments</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="all-shipments.html">All Shipments</a></li>
                                    
                                    <li><a href="upcoming-shipment.html">Upcoming Shipments </a></li>
                                    <li><a href="track-shipment.html">Track Shipment </a></li>
                                    <li><a href="transfer-shipment.html">Transfer Shipment </a></li>
                                    <li><a href="assign-rider.html">Assign Rider </a></li>     
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx uil-book-alt"></i>
                                    <span>Reports</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    
                                    <li><a href="daily-shipment-report.html">Daily Shipment Report</a></li>
                                    <li><a href="Weekly-shipment-report.html">Weekly Shipment Report </a></li>
                                    <li><a href="monthly-shipment-report.html">Monthly Shipment Report</a></li>

                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fas fa-money-bill-alt"></i>
                                    <span>Earnings</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="all-earning-transaction.html">All Transactions List</a></li>
                                    <li><a href="payment-account-section.html">Payment Account Section</a></li>

                                    <li><a href="payment-setting.html">Payment Settings </a></li>
                                        
                                </ul>
                            </li>

                            <li>
                                <a href="outstanding-merchant.html" class="waves-effect">
                                    <i class="fas fa-money-check-alt"></i>
                                    <span>Settlement </span>
                                </a>
                                
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa fa-cog"></i>
                                    <span>Settings</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="delivery-charges-chart.html">Delivery Charges Chart</a></li>
                                    <li><a href="offer-news.html">Notification </a></li>
                                    <li><a href="policy.html">Policy </a></li>
                                    <li><a href="terms-of-use.html">Terms Of Use </a></li>
                                    <li><a href="help-section.html">Help</a></li>
                                </ul>
                            </li>

                            

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-apps"></i>
                                    <span>Website Content </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="about-us.html">About Us</a></li>
                                    <li><a href="contact-us.html">Contact Us </a></li>
                                    <li><a href="our-services.html">Our Services </a></li>

                                </ul>
                            </li>


                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content main-content2">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Upcoming Shipments Order Details</h4>

                                    

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
                                                                        <th scope="row" style="width: 20%;">Date</th>
                                                                        <td>
                                                                            10/10/2020
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row" style="width: 20%;">Tracking ID</th>
                                                                        <td>#MN0121</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Type Of Product</th>
                                                                        <td>Food</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Merchant Name</th>
                                                                        <td>Sonya Henshaw</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Seller Name</th>
                                                                        <td>Sonya Henshaw2</td>
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

                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> ?? drivill.
                            </div>
                            
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->



        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>

        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <script src="assets/js/pages/dashboard.init.js"></script>

        <script src="assets/js/app.js"></script>

    </body>

</html>
