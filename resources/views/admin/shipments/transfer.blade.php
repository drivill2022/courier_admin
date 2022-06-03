@extends('admin.layouts.main')
@section('title', 'Transfer Shipment')
@section('content')

<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Transfer Shipment </h4>
</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-lg-12">
<div id="addproduct-accordion" class="custom-accordion">
<div class="card">
<div class="p-4 border-top">
<form method="POST" action="{{ route('admin.shipments.transfer.post',$shipment->id) }}" enctype="multipart/form-data">
@csrf
    <div class="row">
        {{-- <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label" for="manufacturername">Pickup Categories :</label>
                <select  class="form-select">
                  <option >Local Pickup</option>
                  <option >Nationwide Pickup</option>
              </select>
          </div>
      </div> --}}
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

</div>
<div class="row my-4">
<div class="col text-end">
<input type="hidden" name="assign" value="1">
<a href="{{ route('admin.shipments.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
<button class="btn btn-success" onclick="return confirm('Are you sure?')"> <i class="uil uil-file-alt me-1"></i> Transfer </button>
</div> <!-- end col -->
</div> 
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- End Page-content -->
@endsection
@section('footer_scripts')
<script type="text/javascript">
 $(document).ready(function() {
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
       });

</script>
@endsection
