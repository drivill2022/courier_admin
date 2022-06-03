@extends('merchant.layouts.main')
@section('title', 'Assign Rider')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Send To Pickup</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

         <!--   @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->

        <div class="row">
            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <div class="card">
                        <div class="p-4 border-top">
                            <form method="POST" action="{{ route('merchant.request-for-pickup') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="shipment_id" value="{{$shipment->id}}">
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
                                                    <label class="form-label" for="note">Note:</label>
                                                    <textarea class="form-control" id="note" rows="2" name="note">{{old('note')}}</textarea>
                                                    @error('note')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                    </div>
                                     <div class="col-lg-12">
                                           <div class="col text-end">
                                                <a href="{{ route('merchant.shipment.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                                                <button class="btn btn-success" type="submit"> <i class="uil uil-file-alt me-1"></i>Send To Pickup </button>
                                            </div> <!-- end col -->
                                    </div>
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
<script type="text/javascript" src="{{admin_asset('js/pages/form-advanced.init.js')}}"></script>
<script type="text/javascript">


    function show(type){
        document.getElementById('div1').style.display ='none';
        if(type==1){
            document.getElementById('div1').style.display ='block';
        }
    }

    $(document).ready(function() {   
    
     if($('#statusr').val() == 4)
     {
        $(".transitDv").show();
     }
     else
     {
        $(".transitDv").hide();
     }
     $('#statusr').on('change', function() {
         var statusr = this.value;
         if(statusr == 4)
         {
           $(".transitDv").show();
         }
         else
         {
            $(".transitDv").hide();
         }
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
