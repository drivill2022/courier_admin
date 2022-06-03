@extends('admin.layouts.main')
@section('title', 'Edit Merchant')
@section('content')
<style type="text/css">
    .invalid-feedback{display: inline-block;}

    /*.select2-results__option[aria-selected=true] {
        display: none;
    }
    input.select2-search__field {
        width: auto !important;
    }

    .select2-container--classic .select2-selection--multiple {
        background-color: white;
        border: 1px solid #d9d9d9;
        border-radius: 0px;     
    }
    .select2-container--classic .select2-selection--multiple {
        width: 100% !important;
        color: #55595c;
        background-color: #fff;
        border-radius: 0px  !important;
        background-color: white !important;
        border: 1px solid #d9d9d9 !important;
    }*/

    .select2-container .select2-selection--multiple .select2-search__field {
    border: 0;
    color: #ddd;
}

.select2-container .select2-selection--multiple .select2-selection__rendered {
    padding: 3px;
}
.select2-container .select2-search--inline .select2-search__field {
    font-size: 13px;
    margin-top: 8px;
    margin-left: 5px;
 }
</style>
<!-- <link rel="stylesheet" href="{{ admin_asset('css/select2.css') }}"> -->
<div class="page-content">
    <div class="container-fluid">

        {{--@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif--}}

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Merchant</h4>
                    <a href="{{ route('admin.merchants.index') }}">
                      <button type="button" class="btn btn-primary waves-effect waves-light mb-3">< Back</button></a>
                  </div>
              </div>
          </div>
          <!-- end page title -->

          <div class="row">
            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <div class="card">


                        <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                            <div class="p-4 border-top">
                              <form method="POST" action="{{ route('admin.merchants.update', $merchant->id) }}" enctype="multipart/form-data">
                                @csrf
                                 <input type="hidden" name="_method" value="PATCH">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Merchant  Name</label>
                                            <input id="name" name="name" type="text" class="form-control" value="{{$merchant->name}}">
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
                                            <input id="email" name="email" type="email" class="form-control" value="{{$merchant->email}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="mobile">Contact No</label>
                                            <input id="mobile" name="mobile" type="text" class="form-control" value="{{$merchant->mobile}}" maxlength="12">
                                            @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="nid_number">NID Number</label>
                                                <input id="nid_number" name="nid_number" type="text" class="form-control" value="{{$merchant->nid_number}}" maxlength="12">
                                                @error('nid_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Address</label>
                                            <textarea class="form-control" id="address" name="address" rows="2">{{$merchant->address}}</textarea>
                                             <input type="hidden" value="{{$merchant->latitude?:old('latitude')}}" name="latitude" id="latitude">
                                                <input type="hidden" value="{{$merchant->longitude?:old('longitude')}}" name="longitude" id="longitude">
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="buss_name">Business Name</label>
                                            <input id="buss_name" name="buss_name" type="text" class="form-control" value="{{$merchant->buss_name}}">
                                            @error('buss_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="buss_phone">Business Phone</label>
                                            <input id="buss_phone" name="buss_phone" type="text" class="form-control" value="{{$merchant->buss_phone}}">
                                            @error('buss_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="buss_address">Business Address</label>
                                            <input id="address" name="buss_address" type="text" class="form-control" value="{{$merchant->buss_address}}">
                                            @error('buss_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="fb_page">Merchant Business Facebook Page</label>
                                            <input id="fb_page" name="fb_page" type="text" class="form-control" value="{{$merchant->fb_page}}">
                                            @error('fb_page')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                 <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturername">Division:</label>
                                            <x-division-dropdown :selected="$merchant->division" id="division" name="division" />
                                            @error('division')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturername">District :</label>
                                            <x-district-dropdown :selected="$merchant->district" id="district" name="district" :division="$merchant->division" />
                                          @error('district')
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="manufacturername">Thana:</label>
                                         <x-thana-dropdown :selected="$merchant->thana" id="thana" name="thana" :district="$merchant->district" />
                                       @error('thana')
                                       <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                    <div class="row">
                        <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="fb_page">Payment Method</label>
                                        <x-payment-method-dropdown :selected="$merchant->payment_method" />
                                        @error('payment_method')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="fb_page">Product Types</label>
                                        <x-product-type-dropdown :selected="$merchant->product_type" />
                                        @error('product_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="statusm">Status:</label>
                                <select  class="form-select" name="status" id="statusm">
                                  <option value="Active" @if ($merchant->status=='Active')
                                  selected @endif>Active</option>
                                  <option value="Blocked" @if ($merchant->status=='Blocked')
                                  selected @endif>Blocked</option>

                                  <option value="Onboarding" @if ($merchant->status=='Onboarding')
                                  selected @endif>Onboarding</option>
                              </select>
                              @error('status')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="images upload">Merchant Photo</label>
                                @if($merchant->picture)
                                <img src="{{img($merchant->picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                @endif
                                <input name="picture" id="picture" type="file" multiple="multiple" class="form-control" accept="images/*"> 
                                @error('picture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="images upload">Merchant Business Logo</label>
                                @if($merchant->business_logo)
                                <img src="{{img($merchant->business_logo)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                @endif
                                <input name="business_logo" id="business_logo" type="file" multiple="multiple" class="form-control"> 
                                @error('business_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="images upload">Trade Licence Photo</label>
                                 @if($merchant->trade_lic_no)
                                <img src="{{img($merchant->trade_lic_no)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                @endif
                                <input name="trade_lic_no" id="trade_lic_no" type="file" multiple="multiple" class="form-control"> 
                                @error('trade_lic_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col text-end">
                            <a href="{{ route('admin.merchants.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                            <button class="btn btn-success" type="submit"> <i class="uil uil-file-alt me-1"></i> Save </button>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- end row -->



</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@include('common.address-script')

@endsection
@section('footer_scripts')
<!-- <script type="text/javascript" src="{{admin_asset('js/pages/select2.js')}}"></script> -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#product_type').select2({width:'resolve',theme:'classic', placeholder: "Select Permissions",
            allowClear: 'true'});
        
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