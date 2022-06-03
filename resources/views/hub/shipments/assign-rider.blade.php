@extends('hub.layouts.main')
@section('title', 'Assign Rider')
@section('content')

<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Assign Rider</h4>
</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-lg-12">
<div id="addproduct-accordion" class="custom-accordion">
<div class="card">
<div class="p-4 border-top">
<form method="POST" action="{{ route('hub.shipments.update',$shipment->id) }}" enctype="multipart/form-data">
@csrf
@method('PATCH')
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
      @php $s_status = $shipment->status; @endphp
      @if($shipment->status == 1 || $shipment->status == 8)
        <input type="hidden" name="status" value="2">
      @else
      <input type="hidden" name="status" value="{{$shipment->status}}">
      @endif
       @if($shipment->status == 4)
      <div class="col-lg-6 transitDv">
            <div class="mb-3">
                <label class="form-label" for="rider">Shipment Tracking Number:</label>
                <input type="text" name="shipment_no" class="form-control"  value="{{$shipment->shipment_no?:old('shipment_no')}}" @if($shipment->shipment_no) readonly @endif>
              @error('shipment_no')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    @endif

      <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="manufacturername">Hub :</label>
            <input  class="form-control" name='hub' id="hub" value="{{Auth::guard('hub')->user()->name}}" readonly>
      </div>
  </div>
  <div class="col-lg-6">
    <div class="mb-3">
        <label class="form-label" for="rider">Rider :</label>
        <select  class="form-select" name="rider" id="rider">
          @php($rid=$shipment->rider?$shipment->rider->rider_id:old('rider'))
          {!!hub_riders(Auth::guard('hub')->user()->id,$rid)!!}
      </select>
      @error('rider')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
</div>
  <!-- <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="shipment_type">Shipment Type:</label>
            <x-delivery-type-dropdown :selected="$shipment->shipment_type" id="shipment_type" name="shipment_type"  />
                @error('shipment_type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div> -->

   @if($shipment->status == 4)

     <div class="col-lg-6 transitDv">
            <div class="mb-3">
                <label class="form-label" for="rider">COD Amount:</label>
                <input type="number" name="cod_amount" class="form-control" value="{{$shipment->cod_amount?:old('cod_amount')}}" readonly>
        </div>
    </div>

        <div class="col-lg-6 transitDv">
            <div class="mb-3">
                <label class="form-label" for="rider">Shipment Charge:</label>
                <input type="number" name="shipment_cost" class="form-control" step="0.01" value="{{$shipment->shipment_cost?:old('shipment_cost')}}">
              @error('shipment_cost')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
   @endif

   @if($s_status == 8)
    <div class="col-lg-6 returnDv">
            <div class="mb-3">
                <label class="form-label" for="rider">Shipment Charge:</label>
                <input type="number" name="shipment_cost" class="form-control" step="0.01" value="{{$shipment->shipment_cost/2}}" readonly>
        </div>
    </div>
     @endif

<div class="col-lg-12">
<div class="additional_bike_delivery_form">
    <div class="cycle_motorcycle_radio_tab">
       <div class="">
        <input type="radio" checked name="assign" value="1" onclick="show(0);" id="rider_assign"><label for="rider_assign">Rider</label>  
    </div>
    <div class="">
       <input type="radio" name="assign" value="2" onclick="show(1);" id="edit_assign"><label for="edit_assign">Edit Details</label>  
       
   </div>
</div>

<div id="div1" class="{{old('assign')==2?:'hide'}}">
       <div class="row mt-3">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label" for="manufacturername">Merchant :</label>
                <select  class="form-select" name='merchant' id="merchant">
                    <option value="">Select Merchant</option>
                    @foreach($merchants as $m)
                    <option value="{{$m->id}}" @if ($shipment->merchant_id==$m->id)
                        selected @endif>{{$m->name}}</option>
                        @endforeach

                    </select>
                    @error('merchant')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="receiver_name">Receiver Name:</label>
                    <input id="receiver_name" name="receiver_name" type="text" class="form-control" value="{{$shipment->receiver_name}}"> 
                    @error('receiver_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="contact_no">Contact Number:</label>
                    <input id="contact_no" name="contact_no" type="text" class="form-control" value="{{$shipment->contact_no}}">
                    @error('contact_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label" for="s_address">Pickup Address:</label>
                    <input id="s_address" name="s_address" type="text" class="form-control" name="s_address" value="{{$shipment->s_address}}">
                    <input value="{{$shipment->s_latitude?:old('s_latitude')}}" type="hidden" name="s_latitude" id="s_latitude">
                    <input value="{{$shipment->s_longitude?:old('s_longitude')}}" type="hidden" name="s_longitude" id="s_longitude">
                    @error('s_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="s_division">Pickup Division:</label>
                    <x-division-dropdown :selected="$shipment->s_division" id="s_division" name="s_division" />
                        @error('s_division')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="s_district">Pickup District :</label>
                        <x-district-dropdown :selected="$shipment->s_district" id="s_district" name="s_district" :division="$shipment->s_division" />
                            @error('s_district')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="s_thana">Pickup Thana:</label>
                            <x-thana-dropdown :selected="$shipment->s_thana" id="s_thana" name="s_thana" :district="$shipment->s_district" />
                                @error('s_thana')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="d_address">Delivery Address:</label>
                                <input id="d_address" name="d_address" type="text" class="form-control" name="d_address" value="{{$shipment->d_address}}">
                                <input value="{{$shipment->d_latitude?:old('d_latitude')}}" type="hidden" name="d_latitude" id="d_latitude">
                                <input value="{{$shipment->d_longitude?:old('d_longitude')}}" type="hidden" name="d_longitude" id="d_longitude">
                                @error('d_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="d_division">Delivery Division:</label>
                                <x-division-dropdown :selected="$shipment->d_division" id="d_division" name="d_division" />
                                    @error('d_division')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="d_district">Delivery District :</label>
                                    <x-district-dropdown :selected="$shipment->d_district" id="d_district" name="d_district" :division="$shipment->d_division" />
                                        @error('d_district')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="d_thana">Delivery Thana:</label>
                                        <x-thana-dropdown :selected="$shipment->d_thana" id="d_thana" name="d_thana" :district="$shipment->d_district" />
                                            @error('d_thana')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_detail">Product Detail:</label>
                                            <input id="product_detail" name="product_detail" type="text" class="form-control" value="{{$shipment->product_detail}}">
                                            @error('product_detail')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_weight">Product Weight:</label>
                                            <input id="product_weight" name="product_weight" type="text" class="form-control" value="{{$shipment->product_weight}}">
                                            @error('product_weight')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_type">Product Type:</label>
                                            <x-shipment-product-type-dropdown :selected="$shipment->product_type" id="product_type" name="product_type"  />
                                                @error('product_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="note">Note:</label>
                                                    <textarea class="form-control" id="note" rows="2" name="note">{{$shipment->note}}</textarea>
                                                    @error('note')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>
                      
        


<div class="row my-4">
<div class="col text-end">
<a href="{{ route('hub.shipments.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
<button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Save </button>
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
<script type="text/javascript" src="{{admin_asset('js/pages/form-advanced.init.js')}}"></script>
<script type="text/javascript">
function show(type){
document.getElementById('div1').style.display ='none';
if(type==1){
document.getElementById('div1').style.display ='block';
}
}

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
