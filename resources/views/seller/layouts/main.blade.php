<!doctype html>
<html lang="en">
<head>
        <!-- App favicon -->
        @include('seller.include.headerlinks')
        @yield('header_styles')
        @yield('header_scripts')
</head>

    
    <body>
        <!-- Begin page -->
        <div id="layout-wrapper">
            @include('seller.include.header')
            <!-- ========== Left Sidebar Start ========== -->
            @include('seller.include.navbar')
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content main-content2">
                <!-- page content start -->
               @include('common.notify')
                @yield('content')
                <!-- End Page-content -->
                @include('seller.include.footer')
                
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <!-- JAVASCRIPT -->
         @include('seller.include.footerlinks')
         @yield('footer_scripts')
    </body>
</html>