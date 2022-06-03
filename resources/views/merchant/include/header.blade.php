@php $merchant_id = auth()->guard('merchant')->user()->id;
$notificationList = notificationList($merchant_id);
@endphp
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

@php $merchant_id = auth()->guard('merchant')->user()->id;
                                    $notificationList = notificationList($merchant_id); @endphp

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil-bell"></i>
                                @if(notificationcount($merchant_id) > 0)<span class="badge bg-danger rounded-pill">{{notificationcount($merchant_id)}}</span>@endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="m-0 font-size-16"> Notifications </h5>
                                        </div>
                                       <!--  <div class="col-auto">
                                            <a href="#!" class="small"> Mark all as read</a>
                                        </div> -->
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    @if(!empty($notificationList))
                                    @foreach($notificationList as $noti)
                                    <a href="#" class="text-reset notification-item">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="uil-shopping-basket"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1">{{$noti->message}}</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                        {{date('d M,Y',strtotime($noti->created_at))}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                    @endif
                                
                                </div>
                                <div class="p-2 border-top d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="{{route('merchant.notifications')}}">
                                        <i class="uil-arrow-circle-right me-1"></i> View More..
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{img(Auth::guard('merchant')->user()->picture)}}"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">{{ucwords(Auth::guard('merchant')->user()->name)}}</span>
                                <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="{{ url('/merchant/profile') }}"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">View Profile</span></a>

                                <a class="dropdown-item" href="{{ route('merchant.change-password') }}"><i class="uil uil-keyhole-square-full font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">Change Password</span></a>
                                
                                <a class="dropdown-item"  href="{{ url('/merchant/logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Sign out</span></a>
                                <form id="logout-form" action="{{ url('/merchant/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>

            
                    </div>
                </div>
            </header>
            <style type="text/css">
                .unread
                {
                    background-color: #dae5ff !important;
                }
            </style>