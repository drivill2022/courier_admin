@extends('merchant.layouts.main')
@section('title', 'Dashboard')
@section('content')
<style type="text/css">
    .invalid-feedback{display: inline-block;}

    .select2-results__option[aria-selected=true] {
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
    }
</style>
<link rel="stylesheet" href="{{ admin_asset('css/select2.css') }}">
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <form class="form-horizontal" action="{{route('merchant.profile.update')}}" method="POST" enctype="multipart/form-data" role="form">
                                {{csrf_field()}}                                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input id="name" name="name" type="text" class="form-control" value="{{trim(Auth::guard('merchant')->user()->name)}}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="mobile">Mobile No.</label>
                                            <input id="mobile" name="mobile" type="text" class="form-control" value="{{trim(Auth::guard('merchant')->user()->mobile)}}" maxlength="10">
                                            @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email ID</label>
                                            <input id="email" name="email" type="text" class="form-control" value="{{trim(Auth::guard('merchant')->user()->email)}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="mb-3">
                                            <label class="form-label" for="nid_number">NID Number</label>
                                            <input id="nid_number" name="nid_number" type="text" class="form-control" value="{{trim(Auth::guard('merchant')->user()->nid_number)}}">
                                            @error('nid_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Address</label>
                                            <input id="address" name="address" type="text" class="form-control" value="{{trim(Auth::guard('merchant')->user()->address)}}">
                                             <input type="hidden" value="{{Auth::guard('merchant')->user()->latitude?:old('latitude')}}" name="latitude" id="latitude">
                                                <input type="hidden" value="{{Auth::guard('merchant')->user()->longitude?:old('longitude')}}" name="longitude" id="longitude">
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturername">Division:</label>
                                            <x-division-dropdown :selected="Auth::guard('merchant')->user()->division" id="division" name="division" />
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
                                                <x-district-dropdown :selected="Auth::guard('merchant')->user()->district" id="district" name="district" :division="Auth::guard('merchant')->user()->division" />
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
                                                <x-thana-dropdown :selected="Auth::guard('merchant')->user()->thana" id="thana" name="thana" :district="Auth::guard('merchant')->user()->district" />
                                                 @error('thana')
                                                 <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="buss_name">Business Name</label>
                                <input id="buss_name" name="buss_name" type="text" class="form-control" value="{{trim(Auth::guard('merchant')->user()->buss_name)}}">
                                @error('buss_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="buss_phone">Business Phone</label>
                                <input id="buss_phone" name="buss_phone" type="text" class="form-control" value="{{trim(Auth::guard('merchant')->user()->buss_phone)}}">
                                @error('buss_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="buss_address">Business Address</label>
                                <input id="address" name="buss_address" type="text" class="form-control" value="{{trim(Auth::guard('merchant')->user()->buss_address)}}">
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
                                            <input id="fb_page" name="fb_page" type="text" class="form-control" value="{{Auth::guard('merchant')->user()->fb_page}}">
                                            @error('fb_page')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="fb_page">Payment Method</label>
                                        <x-payment-method-dropdown :selected="Auth::guard('merchant')->user()->payment_method" />
                                        @error('payment_method')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                 <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="fb_page">Product Types</label>
                                        <x-product-type-dropdown :selected="Auth::guard('merchant')->user()->product_type" />
                                        @error('payment_method')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                               
                                <div class="col-lg-6">
                                    <label class="form-label" for="images upload">Profile Images</label>
                                    @if(isset(Auth::guard('merchant')->user()->picture))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em; margin-left: 15px;" src="{{img(Auth::guard('merchant')->user()->picture)}}">
                                    @endif
                                    <input name="picture" type="file" multiple="multiple" class="form-control" accept="image/*">
                                    @error('picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div> 
                                <div class="col-lg-6">
                                    <label class="form-label" for="images upload">Business Logo</label>
                                    @if(isset(Auth::guard('merchant')->user()->business_logo))
                                    <img style="height: 90px; margin-top: 15px;margin-bottom: 15px; border-radius:2em; margin-left: 15px;" src="{{img(Auth::guard('merchant')->user()->business_logo)}}">
                                    @endif
                                    <input name="business_logo" type="file" multiple="multiple" class="form-control" accept="image/*">
                                    @error('business_logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label" for="images upload">Trade License Photo</label>
                                    @if(isset(Auth::guard('merchant')->user()->trade_lic_no))
                                    <img style="height: 90px; margin-top: 15px;margin-bottom: 15px; border-radius:2em; margin-left: 15px;" src="{{img(Auth::guard('merchant')->user()->trade_lic_no)}}">
                                    @endif
                                    <input name="trade_lic_no" type="file" multiple="multiple" class="form-control" accept="image/*">
                                    @error('trade_lic_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-md-12 col text-end mt-3">
                                    <a href="{{route('merchant.profile')}}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                                    <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Update </button>
                                </div> <!-- end row-->
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end row -->                        
</div> <!-- container-fluid -->
</div>

@include('common.address-script')

@endsection
@section('footer_scripts')
<script type="text/javascript" src="{{admin_asset('js/pages/select2.js')}}"></script>
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