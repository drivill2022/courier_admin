@extends('merchant.layouts.main')
@section('title', 'Add Shipment')
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
                    <h4 class="mb-0">Add Shipment</h4>
                    <a href="{{ route('merchant.shipment.index') }}">
                        <button type="button" class="btn btn-success waves-effect waves-light mb-3">< Back</button></a>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div id="addproduct-accordion" class="custom-accordion">
                        <div class="card">
                            <div class="p-4 border-top">
                                <form method="POST" action="{{ route('merchant.shipment.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                       
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="receiver_name">Receiver Name:</label>
                                                    <input id="receiver_name" name="receiver_name" type="text" class="form-control" name="receiver_name" value="{{old('receiver_name')}}"> 
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
                                                    <input id="contact_no" name="contact_no" type="text" class="form-control" name="contact_no" value="{{old('contact_no')}}">
                                                    @error('contact_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="pickup_date">Pickup Date:</label>
                                                    <input id="pickup_date" name="pickup_date" type="text"
                                                     class="form-control" name="pickup_date" value="{{old('pickup_date')}}">
                                                    @error('pickup_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="s_address">Pickup Address:</label>
                                                    <input id="s_address" name="s_address" type="text" class="form-control" name="s_address" value="{{old('s_address')?old('s_address'):$merchant->address}}">
                                                    <input value="{{old('s_latitude')}}" type="hidden" name="s_latitude" id="s_latitude">
                                                    <input value="{{old('s_longitude')}}" type="hidden" name="s_longitude" id="s_longitude">
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
                                                    <x-division-dropdown :selected="old('s_division')?old('s_division'):$merchant->division" id="s_division" name="s_division" />
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
                                                    <x-district-dropdown :selected="old('s_district')?old('s_district'):$merchant->district" id="s_district" name="s_district" :division="old('s_division')" />
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
                                                    <x-thana-dropdown :selected="old('s_thana')?old('s_thana'):$merchant->thana" id="s_thana" name="s_thana" :district="old('s_district')" />
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
                                                    <input id="d_address" name="d_address" type="text" class="form-control" name="d_address" value="{{old('d_address')}}">
                                                    <input value="{{old('d_latitude')}}" type="hidden" name="d_latitude" id="d_latitude">
                                                    <input value="{{old('d_longitude')}}" type="hidden" name="d_longitude" id="d_longitude">
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
                                                    <x-division-dropdown :selected="old('d_division')" id="d_division" name="d_division" />
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
                                                    <x-district-dropdown :selected="old('d_district')" id="d_district" name="d_district" :division="old('d_division')" />
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
                                                    <x-thana-dropdown :selected="old('d_thana')" id="d_thana" name="d_thana" :district="old('d_district')" />
                                                    @error('d_thana')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div> 

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="product_detail">Product Details:</label>
                                                    <input id="product_detail" name="product_detail" type="text" class="form-control" value="{{old('product_detail')}}">
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
                                                   <!--  <input id="product_weight" name="product_weight" type="text" class="form-control" value="{{old('product_weight')}}"> -->
                                                   @php $weight = array(
                                                    '500 GM' => '500 GM',
                                                    '1 KG' => '1 KG',
                                                    '2 KG' => '2 KG',
                                                    '3 KG' => '3 KG',
                                                    '4 KG' => '4 KG',
                                                    '5 KG' => '5 KG',
                                                    '6 KG' => '6 KG',
                                                    '7 KG' => '7 KG',
                                                    'Upto 7 KG' => 'Upto 7 KG',
                                                  ); @endphp
                                                    <select id="product_weight" name="product_weight" class="form-control">
                                                    @foreach($weight as $value)
                                                      <option value="{{$value}}" @if(old('product_weight') == $value) selected @endif>{{$value}}</option>
                                                    @endforeach
                                                    </select>
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
                                                    <x-shipment-product-type-dropdown :selected="old('product_type')" id="product_type" name="product_type"  />
                                                    @error('product_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="shipment_type">Shipment Type:</label>
                                                    <x-delivery-type-dropdown :selected="old('shipment_type')" id="shipment_type" name="shipment_type"  />
                                                    @error('shipment_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div> -->
                                              <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="cod_amount">COD Amount:</label>
                                                    <input id="cod_amount" name="cod_amount" type="text" class="form-control" value="{{old('cod_amount')}}">
                                                    @error('cod_amount')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
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


                                        </div>
                                        <div class="row my-4">
                                            <div class="col text-end">
                                                <a href="{{ route('merchant.shipment.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                                                <button class="btn btn-success" type="submit"> <i class="uil uil-file-alt me-1"></i>Request For Pickup </button>
                                            </div> <!-- end col -->
                                        </div>
                                    </form>
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
        @include('common.shipment-address-script')
        @endsection

@section('footer_scripts')

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <script type="text/javascript">
    $(document).ready(function(){

        district_select();
        thana_select();

        function district_select()
        {
           var division_change = $('.division_change');
           var id = "{{$merchant->division}}";
           let prefix=$(division_change).attr('id').substr(0, 2)+'district';
           $("#"+prefix).html('');
           $.ajax({
            type: "GET",
            url: "{{ url('get-district') }}/"+id,
            success: function(result) {
                $("#"+prefix).html(result);
                var district = "{{$merchant->district}}";
                $(".district_change").val(district);
            }
           });
        }

        function thana_select()
        {
            var district_change = $('.district_change');
            var id = "{{$merchant->district}}";
            let prefix=$(district_change).attr('id').substr(0, 2)+'thana';
           $("#"+prefix).html('');
           $.ajax({
            type: "GET",
            url: "{{ url('get-thana') }}/"+id,
            success: function(result) {
                $("#"+prefix).html(result);
                var thana = "{{$merchant->thana}}";
                $(".thana_change").val(thana);
            }
           });
        }

        $("#pickup_date").datepicker({
             minDate: 1
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