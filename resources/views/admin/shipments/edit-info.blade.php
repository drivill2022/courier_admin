@extends('admin.layouts.main')
@section('title', 'Assign Rider')
@section('header_scripts')
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
@endsection
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Update Information</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <div class="card">
                        <div class="p-4 border-top">
                            <form method="POST" action="{{ route('admin.shipment.info.update',$shipment->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
    
   {{-- <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="manufacturername">Shipment Status:</label>
            <select  class="form-select" name="status" id="statusr">
                @php($status=old('status')?:$shipment->status)
                {!! shipment_staus_option($status)!!}
            </select>
            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>--}}

      <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="manufacturername">Hub :</label>
            <select  class="form-select" name='hub' id="hub">
                <option value="">Select Hub</option>
                @php($hid=$shipment->rider?$shipment->rider->hub_id:old('hub'))
                @php($rid=$shipment->rider?$shipment->rider->rider_id:old('rider'))
                
                @foreach($hubs as $hb)

                <option value="{{$hb->id}}" @if ($hid==$hb->id)
                    selected @endif>{{$hb->name}}</option>
                    @endforeach

                </select>
                @error('hub')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label" for="rider">Rider :</label>
                <select  class="form-select" name="rider" id="rider">
                  {!!hub_riders($hid,$rid)!!}
              </select>
              @error('rider')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div> 

   {{--<div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="pickup_date">Pickup Date:</label>
            <input id="pickup_date" name="pickup_date" type="text"
             class="form-control" name="pickup_date" value="{{$shipment->pickup_date}}">
            @error('pickup_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>--}}
 
    <div class="row my-4">
                            <div class="col text-end">
                                <a href="{{ route('admin.shipments.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                                <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Save </button>
                            </div> <!-- end col -->
                        </div> 
                    </form>
</div>
<!-- End Page-content -->
@include('common.shipment-address-script')
@endsection
@section('footer_scripts')
<script type="text/javascript" src="{{admin_asset('js/pages/form-advanced.init.js')}}"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $("#pickup_date").datepicker({
             minDate: 0
        }); 


     $('#hub').on('change', function() {
         var hub = this.value;
         $("#rider").html('');
         $.ajax({
             type: "GET",
             url: "{{ url('get-riders') }}/"+hub,
             success: function(result) {
              $('#rider').html(result);
          }
      });
     });

     $('.division_change').change(function () {
        var id = this.value;
        let prefix=$(this).attr('id').substr(0, 2)+'district';
        $("#"+prefix).html('');
        $.ajax({
            type: "GET",
            url: "{{ url('get-district') }}/"+id,
            success: function(result) {
                $("#"+prefix).html(result);
            }
        });
    })

     $('.district_change').change(function () {
        var id = this.value;
        let prefix=$(this).attr('id').substr(0, 2)+'thana';
        $("#"+prefix).html('');
        $.ajax({
            type: "GET",
            url: "{{ url('get-thana') }}/"+id,
            success: function(result) {
                $("#"+prefix).html(result);
            }
        });
    })
 })
</script>
@endsection
