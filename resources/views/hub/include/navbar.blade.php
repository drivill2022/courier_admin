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
                                <img src="{{img(Auth::guard('hub')->user()->picture)}}" class="img-fluid">
                                <h3>{{ucwords(Auth::guard('hub')->user()->name)}}</h3>
                                <p>HUB: {{strtoupper(Auth::guard('hub')->user()->hbsid)}}</p>
                            </div>
                            <div class="user_profile_section_icons">
                                <ul>
                                    <a href="{{ url('/hub/profile') }}" title="Settings"><li><i class="uil-cog"></i></li></a>
                                    <a  title="Messages"><li><i class="bx uil-envelope"></i></li></a>
                                    <a href="{{ url('/hub/profile') }}" title="Profile"><li><i class="bx uil-user-circle"></i></li></a>
                                    <a href="{{ url('/hub/logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" title="Logout"><li><i class="uil uil-sign-out-alt"></i></li></a>
                                </ul>
                            </div>
                        </div>
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>
                            <li>
                                <a href="{{ route('hub.dashboard') }}">
                                    <i class="uil-home-alt"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                             <li>
                                <a href="{{ route('hub.delivery-charges.index') }}" class="waves-effect">
                                    <i class="uil-location-point"></i>
                                    <span>Manage Delivery Charges</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-store"></i>
                                    <span>Shipments</span>
                                </a>
                                  <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('hub.shipments.index') }}">All Shipments</a></li>
                                    
                                    <li><a href="{{ route('hub.shipments.upcoming') }}">Upcoming Shipments </a></li>
                                    <li><a href="{{ route('hub.shipments.track') }}">Track Shipment </a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa fa-motorcycle"></i>
                                    <span>Riders</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('hub.riders.create') }}">Add Delivery Rider </a></li>
                                    
                                    <li><a href="{{ route('hub.riders.index') }}">All Delivery Riders</a></li>
                                </ul>
                            </li>
                             <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fas fa-money-bill-alt"></i>
                                    <span>Earnings</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('hub.rider_deposit') }}">Rider Amount Deposit</a></li>
                                </ul>
                            </li>

                           
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx uil-book-alt"></i>
                                    <span>Reports</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    
                                    <li><a href="#" class="has-arrow waves-effect">Rider Statement</a>
                                     <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="{{ route('hub.rider_earning_statement','daily') }}">Earning Statements</a></li>
                                         <li><a href="{{ route('hub.rider_shipment_report','daily') }}">Shipment Report</a></li>
                                     </ul>

                                    </li>
                                    <li><a href="#" class="has-arrow waves-effect">Hub Statement</a>
                                     <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="{{ route('hub.hub_earning_statement','daily') }}">Earning Statements</a></li>
                                         <li><a href="{{ route('hub.hub_shipment_report','daily') }}">Shipment Report</a></li>
                                     </ul>

                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>