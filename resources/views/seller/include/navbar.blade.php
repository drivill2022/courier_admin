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
                                <img src="{{img(Auth::guard('seller')->user()->picture)}}" class="img-fluid">
                                <h3>{{ucwords(Auth::guard('seller')->user()->name)}}</h3>
                                <p>Seller: {{strtoupper(Auth::guard('seller')->user()->slid)}}</p>
                            </div>
                            <div class="user_profile_section_icons">
                                <ul>
                                    <a href="{{ url('/seller/profile') }}" title="Settings"><li><i class="uil-cog"></i></li></a>
                                    <a  title="Messages"><li><i class="bx uil-envelope"></i></li></a>
                                    <a href="{{ url('/seller/profile') }}" title="Profile"><li><i class="bx uil-user-circle"></i></li></a>
                                    <a class="dropdown-item"  href="{{ url('/seller/logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" title="Logout"><li><i class="uil uil-sign-out-alt"></i></li></a>
                                </ul>
                            </div>
                        </div>
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>
                            <li>
                                <a href="{{ route('seller.dashboard') }}">
                                    <i class="uil-home-alt"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                       
                             <li>
                                <a href="all-orders.html" class="waves-effect">
                                    <i class="fa fa-first-order"></i>                             
                                    <span>Orders</span>
                                </a>
                                
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-user-circle"></i>
                                    <span>Profile </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="profile.html">Seller Profile  </a></li>

                                    <li><a href="edit-seller_profile.html">Edit Profile  </a></li>

                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                    <span>Item Management </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('seller.items.index') }}">All Items </a></li>
                                    <li><a href="{{ route('seller.items.create') }}">Add Item </a></li>
                                    
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx uil-book-alt"></i>
                                    <span>Reports</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    
                                    <li><a href="daily-report.html">Daily Report</a></li>
                                    <li><a href="Weekly-report.html">Weekly Report </a></li>
                                    <li><a href="monthly-report.html">Monthly Report</a></li>

                                </ul>
                            </li>


                            <li>
                                <a href="offer-news.html" class="waves-effect">
                                    <i class="fa fa-gift"></i>
                                    <span>Offers & News </span>
                                </a>
                                
                            </li>

                            <li>
                                <a href="notification.html" class="waves-effect">
                                    <i class="fa fa-bell"></i>
                                    <span>Notification </span>
                                </a>
                                
                            </li>

                            <li>
                                <a href="seller-setting.html" class="waves-effect">
                                    <i class="fa fa-cog"></i>
                                    
                                    <span>Settings </span>
                                </a>
                                
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>