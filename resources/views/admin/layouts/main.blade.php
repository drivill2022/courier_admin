<!doctype html>
<html lang="en">
<head>
        <!-- App favicon -->
        @include('admin.include.headerlinks')
        @yield('header_styles')
        @yield('header_scripts')
</head>

    
    <body>
        <!-- Begin page -->
        <div id="layout-wrapper">
            @include('admin.include.header')
            <!-- ========== Left Sidebar Start ========== -->
            @include('admin.include.navbar')
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content main-content2">
                <!-- page content start -->
               @include('common.notify')
                @yield('content')
                <!-- End Page-content -->
                @include('admin.include.footer')
                
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <!-- JAVASCRIPT -->
         @include('admin.include.footerlinks')
         @yield('footer_scripts')
    </body>
</html>