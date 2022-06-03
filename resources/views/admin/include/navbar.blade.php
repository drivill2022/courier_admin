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
                    <img src="{{img(Auth::guard('admin')->user()->picture)}}" class="img-fluid">
                    <h3>{{ucwords(Auth::guard('admin')->user()->name)}}</h3>
                    <p>{{strtoupper(Auth::guard('admin')->user()->role->name)}}</p>
                </div>
                <div class="user_profile_section_icons">

                    <ul>
                       <li><a href="{{ url('/admin/profile') }}" title="Settings"><i class="uil-cog"></i></a></li>
                       <li><a  title="Messages"><i class="bx uil-envelope"></i></a></li>
                       <li><a href="{{ url('/admin/profile') }}" title="Profile"><i class="bx uil-user-circle"></i></a></li>
                       <li><a class="dropdown-item"  href="{{ url('/admin/logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" title="Logout"><i class="uil uil-sign-out-alt"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                @if(AdminCan('dashboard'))
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="uil-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endif
                @if(AdminCan('manage admin') || AdminCan('manage roles') )
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-user-circle"></i>
                        <span>Manage Sub Admins</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(AdminCan('manage admins') )
                        <li><a href="{{ route('admin.sub-admins.index') }}">Manage Admins</a></li>
                        @endif
                        @if(AdminCan('manage roles') )
                        <li><a href="{{ route('admin.roles.index') }}">Manage Roles</a></li>
                        @endif
                        @if(1!=1)
                        <li><a href="{{ route('admin.permissions.index') }}">@lang('admin.permissions.list')</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(AdminCan('manage merchants'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-store"></i>
                        <span>Merchants</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(AdminCan('add merchant'))
                        <li><a href="{{ route('admin.merchants.create') }}">Add Merchant </a></li>
                        @endif
                        <li><a href="{{ route('admin.merchants.index') }}">All Merchants</a></li>
                        <li><a href="{{ route('admin.merchant-banners.index') }}">Merchant Banners</a></li>
                        <li><a href="{{ route('admin.merchant-account.index') }}">Merchant Accounts</a></li>
                        {{-- <li><a href="blocked-merchant.html">Blocked Merchants </a></li> --}}

                    </ul>
                </li>
                @endif
                @if(AdminCan('manage hubs'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-window-section"></i>
                        <span>Hubs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(AdminCan('add hub'))
                        <li><a href="{{ route('admin.hubs.create') }}">Add Hub </a></li>
                        @endif
                        <li><a href="{{ route('admin.hubs.index') }}">All Hubs </a></li>
                    </ul>
                </li>
                @endif
                @if(AdminCan('manage product type'))
                <li>
                    <a href="{{ route('admin.product-types.index') }}" class="waves-effect">
                        <i class="uil-location-point"></i>
                        <span>Product Types</span>
                    </a>
                </li>
                @endif
                @if(AdminCan('manage sellers'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-shopping-bag "></i>
                        <span>Sellers </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(AdminCan('add seller'))
                        <li><a href="{{ route('admin.sellers.create') }}">Add Seller  </a></li>
                        @endif
                        <li><a href="{{ route('admin.sellers.index') }}">All Sellers</a></li>
                        <li><a href="{{ route('admin.product-types.index') }}">Product Types</a></li>
                        <li><a href="{{ route('admin.sellers.categories.index') }}">Product Categories</a></li>

                        {{--  <li><a href="product-listing.html">Product Listing  </a></li> --}}

                    </ul>
                </li>
                @endif
                @if(AdminCan('vehicle data'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-motorcycle"></i>
                        <span>Vehicles Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.vehicle.brands.index') }}">Vehicle Brands</a></li>
                        <li><a href="{{ route('admin.vehicle.models.index') }}">Vehicle Models</a></li>
                        <li><a href="{{ route('admin.vehicle.regions.index') }}">Vehicle Regions</a></li>
                        <li><a href="{{ route('admin.vehicle.categories.index') }}">Vehicle Categories</a></li>
                    </ul>
                </li>
                @endif 
                @if(AdminCan('manage riders'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-motorcycle"></i>
                        <span>Delivery Riders </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.riders.create') }}">Add Delivery Rider </a></li>
                        <li><a href="{{ route('admin.riders.index') }}">All Delivery Riders</a></li>
                    

                    </ul>
                </li>
                @endif
                @if(AdminCan('manage customers'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-user-circle"></i>
                        <span>Customers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.customers.index') }}">Registered Customers List </a></li>
                        <li><a href="{{ route('admin.customers.index') }}">Blocked Customers </a></li>
                    </ul>
                </li>
                @endif
                @if(AdminCan('manage services'))
                <li>
                    <a href="{{ route('admin.services.index') }}" class="waves-effect">
                        <i class="uil-location-point"></i>
                        <span>Manage Services</span>
                    </a>
                </li>
                @endif 
                @if(AdminCan('mercahnt delivery charges'))
                <li>
                    <a href="{{ route('admin.delivery-charges.index') }}" class="waves-effect">
                        <i class="uil-location-point"></i>
                        <span>Manage Delivery Charges</span>
                    </a>
                </li>
                @endif
                @if(AdminCan('manage reasons'))
                <li>
                    <a href="{{ route('admin.reasons.index') }}" class="waves-effect">
                        <i class="uil-location-point"></i>
                        <span>Manage Reasons</span>
                    </a>
                </li>
                @endif
                @if(AdminCan('manage map'))

                <li>
                    <a href="{{ route('admin.map') }}" class="waves-effect">
                        <i class="uil-location-point"></i>
                        <span>Maps</span>
                    </a>
                </li>
                @endif
                @if(AdminCan('manage shipments'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-store"></i>
                        <span>Shipments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.shipments.index') }}">All Shipments</a></li>

                        <li><a href="{{ route('admin.shipments.upcoming') }}">Upcoming Shipments </a></li>
                        <li><a href="{{ route('admin.shipments.track') }}">Track Shipment </a></li>
                        <li><a href="{{ route('admin.shipments.create') }}">Add Shipment </a></li>     
                        <li><a href="{{ route('admin.shipment.import') }}">Import Shipment</a></li>     
                    </ul>
                </li>
                @endif
                @if(AdminCan('manage reports'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx uil-book-alt"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" class="has-arrow waves-effect">Merchant Statement</a>
                         <ul class="sub-menu" aria-expanded="false">
                          
                             <li><a href="{{ route('admin.merchant_earning_statement','daily') }}">Earning Statements</a></li>
                             <li><a href="{{ route('admin.merchant_shipment_report','daily') }}">Shipment Report</a></li>
                         </ul>

                        </li>

                        <li><a href="#" class="has-arrow waves-effect">Rider Statement</a>
                         <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin.rider_earning_statement','daily') }}">Earning Statements</a></li>
                             <li><a href="{{ route('admin.rider_shipment_report','daily') }}">Shipment Report</a></li>
                         </ul>

                        </li>
                        <li><a href="#" class="has-arrow waves-effect">Hub Statement</a>
                         <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin.hub_earning_statement','daily') }}">Earning Statements</a></li>
                             <li><a href="{{ route('admin.hub_shipment_report','daily') }}">Shipment Report</a></li>
                         </ul>

                        </li>
                         {{-- <li><a href="{{ route('admin.reports','daily') }}">Daily Shipment Report</a></li>
                        <li><a href="{{ route('admin.reports','weekly') }}">Weekly Shipment Report </a></li>
                        <li><a href="{{ route('admin.reports','monthly') }}">Monthly Shipment Report</a></li> --}}
                    </ul>
                </li>
                @endif
                @if(AdminCan('manage earnings'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-money-bill-alt"></i>
                        <span>Earnings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{ route('admin.merchant_payment') }}">Merchant Payment</a></li>
                          <li><a href="{{ route('admin.merchant_transaction',['daily','']) }}">Merchant Transaction</a></li>
                        <!-- <li><a href="{{ route('admin.earnings.index') }}">All Transactions List</a></li>
                        <li><a href="{{ route('admin.payout') }}">Payment Account Section</a></li> -->
                    {{--<li><a href="#" class="has-arrow waves-effect">All Transactions List</a>
                         <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin.merchant_transaction') }}">Merchant Transaction</a></li>
                            <li><a href="{{ route('admin.rider_transaction') }}">Rider Transaction</a></li>
                         </ul>

                    </li>
                     <li><a href="#" class="has-arrow waves-effect">Payment Account Section</a>
                         <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin.merchant_payment') }}">Merchant Payment</a></li>
                            <li><a href="{{ route('admin.rider_payment') }}">Rider Payment</a></li>
                         </ul>

                    </li>--}}
                     <li><a href="{{ route('admin.rider_deposit') }}">Rider Amount Deposit</a></li>
                     <li><a href="{{ route('admin.withdraw_request') }}">Merchant Withdraw Request</a></li>
                    <!--  <li><a href="{{ route('admin.hub_deposit','daily') }}">Hub Amount Deposit</a></li> -->
                     <li><a href="{{ route('admin.hub_deposit') }}">Hub Amount Deposit</a></li>
                     <li><a href="{{ route('admin.available-balance') }}">Merchant Available Balance</a></li>
                    </ul>
                </li>
                @endif
                @if(AdminCan('manage settlements'))
               <!--  <li>
                    <a href="{{ route('admin.settlements.index') }}" class="waves-effect">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Settlement </span>
                    </a>

                </li> -->
                @endif
                @if(AdminCan('manage settings'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.settings.index') }}">Application</a></li>
                        <!-- <li><a href="delivery-charges-chart.html">Delivery Charges Chart</a></li> -->
                        <!-- <li><a href="offer-news.html">Notification </a></li> -->
                        <li><a href="{{ route('admin.pages.edit',5) }}">Policy </a></li>
                        <li><a href="{{ route('admin.pages.edit',4) }}">Terms Of Use </a></li>
                        <li><a href="{{ route('admin.help.index') }}">Help</a></li>
                    </ul>
                </li>
                @endif

                @if(AdminCan('manage pages'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-apps"></i>
                        <span>Website Content </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.pages.index') }}">Pages List</a></li>
                        <li><a href="{{ route('admin.pages.create') }}">Add Page </a></li>
                    </ul>
                </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>