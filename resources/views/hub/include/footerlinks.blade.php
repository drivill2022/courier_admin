<script src="{{asset('public/backend/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/backend/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/backend/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('public/backend/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('public/backend/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('public/backend/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('public/backend/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>

{{-- add scripts above app js --}}
@stack('script')

<!-- Required datatable js -->
<script src="{{asset('public/backend/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

<!-- Responsive examples -->
<script src="{{asset('public/backend/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/backend/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- init js -->
<script src="{{asset('public/backend/js/pages/ecommerce-datatables.init.js')}}"></script>
<script src="{{asset('public/backend/js/app.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
      $('select#merchant,select#hub,select#rider').select2();
      $("#edit_assign").change(function(){$('select#merchant,select#hub,select#rider').select2();});
	});
</script>

