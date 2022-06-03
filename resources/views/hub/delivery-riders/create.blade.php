@extends('hub.layouts.main')
@section('title', 'Add Rider')
@section('content')

<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Add Delivery Rider</h4>
<div>
<a href="{{ route('hub.riders.index') }}">
<button type="button" class="btn btn-success waves-effect waves-light mb-3">< Back</button></a>
</div>

</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-lg-12">
<div id="addproduct-accordion" class="custom-accordion">
<div class="card">
<div class="p-4 border-top">
<form method="POST" action="{{ route('hub.riders.store') }}" name="add-riders" enctype="multipart/form-data">
    @csrf
<div class="row">
<div class="col-lg-6"> 
<div class="mb-3"> <label class="form-label" for="name"> Name:</label>
<input id="name" name="name" type="text" class="form-control" value="{{old('name')}}">
@error('name')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="email">Email</label>
<input id="email" name="email" type="email" class="form-control" value="{{old('email')}}">
@error('email')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="password">Password</label>
<input id="password" name="password" type="password" class="form-control" value="{{old('password')}}">
@error('password')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="password_confirmation">Confirm Password</label>
<input id="password_confirmation" name="password_confirmation" type="password" class="form-control" value="{{old('password_confirmation')}}">
@error('password_confirmation')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="address"> Address:</label>
<textarea name="address" class="form-control" id="address" rows="2">{{old('address')}}</textarea>
<input type="hidden" value="{{old('latitude')}}" name="latitude" id="latitude">
<input type="hidden" value="{{old('longitude')}}" name="longitude" id="longitude">
@error('address')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="division">Division:</label>
                                                <x-division-dropdown :selected="old('division')" id="division" name="division" />
                                                @error('division')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="district">District:</label>
                                                <x-district-dropdown :selected="old('district')" id="district" name="district" :division="old('division')" />
                                                @error('district')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="thana">Thana:</label>
                                                <x-thana-dropdown :selected="old('thana')" id="thana" name="thana" :district="old('district')" />
                                                @error('thana')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
<div class="col-lg-6">

<div class="mb-3">
<label class="form-label" for="mobile">Mobile number:</label>
<input id="mobile" name="mobile" type="text" class="form-control" value="{{old('mobile')}}">
@error('mobile')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
{{--  <div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="otp">OTP verification:</label>
<input id="otp" name="otp" type="text" class="form-control"  value="{{old('otp')}}">
@error('otp')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div> --}}
<div class="col-lg-6">

<div class="mb-3">
<label class="form-label" for="nid_number">NID number:</label>
<input id="nid_number" name="nid_number" type="text" class="form-control" value="{{old('nid_number')}}">
@error('nid_number')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">

<div class="mb-3">
<label class="form-label" for="images upload">NID photo: </label>
<input name="nid_picture" type="file" accept="images/*" class="form-control">
@error('nid_picture')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror  
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="images upload">Father NID photo: </label>
<input name="father_nid_pic" type="file" accept="images/*" class="form-control">
@error('father_nid_pic')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">

<div class="mb-3">
<label class="form-label" for="father_nid">Fathers NID number: </label>
<input id="father_nid" name="father_nid" type="text" class="form-control" value="{{old('father_nid')}}">
@error('father_nid')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">

<div class="mb-3">
<label class="form-label" for="images upload">Delivery Rider Photo: </label>
<input name="picture" type="file" accept="images/*" class="form-control">
@error('picture')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror  
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="statusm">Gender:</label>
<select  class="form-select" name="gender" id="genderm">
<option value="Male" @if (old('gender')=='Male')
selected @endif>Male</option>
<option value="Female" @if (old('gender')=='Female')
selected @endif>Female</option>
<option value="Other" @if (old('gender')=='Other')
selected @endif>Other</option>
</select>
@error('gender')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="statusm">Status:</label>
<select  class="form-select" name="status" id="statusm">
<option value="Active" @if (old('status')=='Active')
selected @endif>Active</option>
<option value="Blocked" @if (old('status')=='Blocked')
selected @endif>Blocked</option>
<option value="Onboarding" @if (old('status')=='Onboarding')
selected @endif>Onboarding</option>
</select>
@error('status')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>

<div class="col-lg-6">
    <div class="mb-3">
        <label class="form-label" for="father_mobile">Father's Mobile Number: </label>
        <input id="father_mobile" name="father_mobile" type="number" class="form-control" value="{{old('father_mobile')}}">
        @error('father_mobile')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-lg-12">
<div class="additional_bike_delivery_form">
<div class="cycle_motorcycle_radio_tab">
<label class="form-label" for="vehicle_type">Rider Vehicle Type:</label>
@foreach($vehicles as $vt)
<div class="">
<input type="radio" name="vehicle_type_id" value="{{$vt->id}}" onclick="showVehicleDetails('{{$vt->id}}');" @if($vt->id==old('vehicle_type_id')) checked @endif  id="vehicle_type_{{$vt->name}}"> <label class="form-label" for="vehicle_type_{{$vt->name}}">{{$vt->name}}</label>

</div>
@endforeach
</div>
@error('vehicle_type_id')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
<div id="div1" class="{{(2==old('vehicle_type_id'))?:"hide"}}">
<div class="row mt-3">
<div class="col-lg-6">

<div class="mb-3">
<label class="form-label" for="images upload">Driving Licence Photo: </label>
<input name="dl_photo" type="file" accept="images/*" class="form-control">  @error('dl_photo')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="dl_number">DL Number:</label>
<input id="dl_number" name="dl_number" type="text" class="form-control" value="{{old('dl_number')}}">
@error('dl_number')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6"> <div class="mb-3"> <label class="form-label" for="brand">Brand:</label>
<x-vehicle-brands-dropdown :selected="old('brand')"/>  
@error('brand')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="model">Model:</label>
<x-vehicle-models-dropdown :selected="old('model')"/>    
   
@error('model')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="region">Region:</label>

<x-vehicle-regions-dropdown :selected="old('region')"/>    

@error('region')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="category">Category:</label>


<x-vehicle-category-dropdown :selected="old('category')"/>    
@error('category')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="plat_number">Plate Number:</label>
<input id="plat_number" name="plat_number" type="text" class="form-control" value="{{old('plat_number')}}">
@error('plat_number')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="mb-3">
<label class="form-label" for="token_number">Token number:</label>
<input id="token_number" name="token_number" type="text" class="form-control" value="{{old('token_number')}}">
@error('token_number')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="col-lg-6"> <div class="mb-3"> <label class="form-label" for="images upload">Registration Photo: </label>
<input name="rc_photo" type="file" multiple="multiple" class="form-control"> 
@error('rc_photo')
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
<a href="{{ route('hub.riders.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
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
<!-- end row -->

<!-- end row-->

</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@include('common.address-script')

@endsection
@section('footer_scripts')

<!-- select 2 plugin -->
<script src="{{admin_asset('libs/select2/js/select2.min.js')}}"></script>
<!-- dropzone plugin -->
<script src="{{admin_asset('libs/dropzone/min/dropzone.min.js')}}"></script>
<!-- init js -->
<script src="{{admin_asset('js/pages/ecommerce-add-product.init.js')}}"></script>


<script type="text/javascript">
function showVehicleDetails(id){
document.getElementById('div1').style.display ='none';
if(id==2){
document.getElementById('div1').style.display ='block';
}
}

$(document).ready(function(){
        $('#division').change(function () {
            var id = this.value;
            
            $.ajax({
                type: "GET",
                url: "{{ url('get-district') }}/"+id,
                success: function(result) {
                    $("#district").html(result);
                }
            });
        })

        $('#district').change(function () {
            var id = this.value;
            $.ajax({
                type: "GET",
                url: "{{ url('get-thana') }}/"+id,
                success: function(result) {
                    $("#thana").html(result);
                }
            });
        })
    })

</script>

@endsection