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
                                <img src="{{img(Auth::guard('merchant')->user()->picture)}}" class="img-fluid">
                                <h3>{{ucwords(Auth::guard('merchant')->user()->name)}}</h3>
                                <p>Merchant: {{strtoupper(Auth::guard('merchant')->user()->mrid)}}</p>
                            </div>
                            <div class="user_profile_section_icons">
                                <ul>
                                    <a href="{{ url('/merchant/profile') }}" title="Settings"><li><i class="uil-cog"></i></li></a>
                                    <a  title="Messages"><li><i class="bx uil-envelope"></i></li></a>
                                    <a href="{{ url('/merchant/profile') }}" title="Profile"><li><i class="bx uil-user-circle"></i></li></a>
                                    <a class="dropdown-item"  href="{{ url('/merchant/logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" title="Logout"><li><i class="uil uil-sign-out-alt"></i></li></a>
                                </ul>
                            </div>
                        </div>
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>
                            <li>
                                <a href="{{ route('merchant.dashboard') }}">
                                    <i class="uil-home-alt"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                       
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-store"></i>
                                    <span>Shipments</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('merchant.shipment.index') }}">All Shipments</a></li>
                                    <li><a href="{{ route('merchant.shipment.upcoming') }}">Upcoming Shipments</a></li>
                                    <li><a href="{{ route('merchant.shipment.track') }}">Track Shipment</a></li>
                                    <li><a href="{{ route('merchant.shipment.create') }}">Add Shipment</a></li>
                                    <li><a href="{{ route('merchant.shipment.import') }}">Import Shipment</a></li>
                                    

                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx uil-book-alt"></i>
                                    <span>Reports</span>
                                </a>
                                 <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('merchant.merchant_earning_statement','daily') }}">Earning Statements</a></li>
                                     <li><a href="{{ route('merchant.merchant_shipment_report','daily') }}">Shipment Report</a></li>
                                </ul>
                            </li>
                            
                           <!--  <li>
                                <a href="{{ route('merchant.graph') }}" class="waves-effect">
                                    <i class="bx uil-chart"></i>
                                    <span>Graph</span>
                                </a>
                                
                            </li>  --> 
                             <li>
                                <a href="{{ route('merchant.payment-history','daily') }}" class="waves-effect">
                                    <i class="bx uil-chart"></i>
                                    <span>Payment History</span>
                                </a>
                                
                            </li>                        

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-user-circle"></i>
                                    <span>Profile</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    
                                    <li><a href="{{ route('merchant.profile') }}">View Profile</a></li>
                                    <li><a href="{{ route('merchant.edit.profile') }}">Edit Profile </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>