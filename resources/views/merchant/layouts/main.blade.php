<!doctype html>
<html lang="en">
<head>
        <!-- App favicon -->
        @include('merchant.include.headerlinks')
        @yield('header_styles')
        @yield('header_scripts')
</head>

    
    <body>
        <!-- Begin page -->
        <div id="layout-wrapper">
            @include('merchant.include.header')
            <!-- ========== Left Sidebar Start ========== -->
            @include('merchant.include.navbar')
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content main-content2">
                <!-- page content start -->
               @include('common.notify')
                @yield('content')
                <!-- End Page-content -->
                @include('merchant.include.footer')
                
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <!-- JAVASCRIPT -->
         @include('merchant.include.footerlinks')
         @yield('footer_scripts')
    </body>
</html>