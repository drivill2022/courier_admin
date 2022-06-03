@extends('seller.layouts.main')
@section('title', 'Dashboard')
@section('content')
<style type="text/css">
    .invalid-feedback{display: inline-block;}
</style>
<style type="text/css">
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
@php($seller=Auth::guard('seller')->user())
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
                            <form class="form-horizontal" action="{{route('seller.profile.update')}}" method="POST" enctype="multipart/form-data" role="form">
                                {{csrf_field()}}                                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input id="name" name="name" type="text" class="form-control" value="{{trim(Auth::guard('seller')->user()->name)}}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="nid_no">NID Number</label>
                                            <input id="nid_no" name="nid_no" type="text" class="form-control" value="{{Auth::guard('seller')->user()->nid_no}}">
                                            @error('nid_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">  
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email ID</label>
                                            <input id="email" name="email" type="text" class="form-control" value="{{trim(Auth::guard('seller')->user()->email)}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="mobile">Contact No.</label>
                                            <input id="mobile" name="mobile" type="text" class="form-control" value="{{trim(Auth::guard('seller')->user()->mobile)}}" maxlength="10">
                                            @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="business_name">Business Name </label>
                                            <input id="business_name" name="business_name" type="text" class="form-control" value="{{trim(Auth::guard('seller')->user()->business_name)}}" maxlength="10">
                                            @error('business_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Address</label>
                                            <input id="address" name="address" type="text" class="form-control" value="{{trim(Auth::guard('seller')->user()->address)}}">
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturername">District :</label>
                                            <select  class="form-select" name="district" id="district">
                                                <option value="">Select District</option>
                                                <option value="1" @if (Auth::guard('seller')->user()->district==1)
                                                    selected @endif>District 1</option>
                                                    <option value="2" @if (Auth::guard('seller')->user()->district==2)
                                                        selected @endif>District 2</option>
                                                        <option value="3" @if (Auth::guard('seller')->user()->district==3)
                                                            selected @endif>District 3</option>

                                                        </select>
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
                                                        <select  class="form-select" name="thana" id="thana">
                                                            <option value="">Select Thana</option>
                                                            <option value="1" @if (Auth::guard('seller')->user()->thana==1)
                                                                selected @endif>Thana 1</option>
                                                                <option value="2" @if (Auth::guard('seller')->user()->thana==2)
                                                                    selected @endif>Thana 2</option>
                                                                    <option value="3" @if (Auth::guard('seller')->user()->thana==3)
                                                                        selected @endif>Thana 3</option>
                                                                    </select>
                                                                    @error('thana')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="manufacturername">Division:</label>
                                                                    <select  class="form-select" name="division" id="division">
                                                                        <option >Select Division </option>
                                                                        <option value="1" @if (Auth::guard('seller')->user()->division==1)
                                                                            selected @endif>Division 1</option>
                                                                            <option value="2" @if (Auth::guard('seller')->user()->division==2)
                                                                                selected @endif>Division 2</option>
                                                                                <option value="3" @if (Auth::guard('seller')->user()->division==3)
                                                                                    selected @endif>Division 3</option>
                                                                                </select>
                                                                                @error('division')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label" for="manufacturername">Product Type (Sales)</label>
                                                                                <select class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="product_type[]" id="product_type">
                                                                                    @foreach($product_type as $pt)
                                                                                    <option value="{{$pt->id}}" @if (in_array($pt->id,seller_product_type($seller->id)?:[]))
                                                                                        selected @endif>{{$pt->name}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('product_type')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label" for="fb_page">Business Facebook Page</label>
                                                                                    <input id="fb_page" name="fb_page" type="text" class="form-control" value="{{Auth::guard('seller')->user()->fb_page}}">
                                                                                    @error('fb_page')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label" for="manufacturername">Payment Method</label>
                                                                                    <select  class="form-select" name="payment_id" id="payment_id">
                                                                                        <option value="" >Select Payment Method</option>
                                                                                        @foreach($payment_method as $pm)
                                                                                        <option value="{{$pm->id}}" @if ($seller->payment_id==$pm->id)
                                                                                            selected @endif>{{$pm->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('payment_id')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-6">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label" for="images upload">Profile Images</label>
                                                                                        @if(isset(Auth::guard('seller')->user()->picture))
                                                                                        <img style="height: 90px; margin-bottom: 15px; border-radius:2em; margin-left: 15px;" src="{{img(Auth::guard('seller')->user()->picture)}}">
                                                                                        @endif
                                                                                        <input name="picture" type="file" multiple="multiple" class="form-control" accept="image/*">
                                                                                        @error('picture')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div> 
                                                                                <div class="col-lg-6">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label" for="images upload">Business Logo</label>
                                                                                        @if(isset(Auth::guard('seller')->user()->business_logo))
                                                                                        <img style="height: 90px; margin-top: 15px;margin-bottom: 15px; border-radius:2em; margin-left: 15px;" src="{{img(Auth::guard('seller')->user()->picture)}}">
                                                                                        @endif
                                                                                        <input name="business_logo" type="file" multiple="multiple" class="form-control" accept="image/*">
                                                                                        @error('business_logo')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 col text-end mt-3">
                                                                                <a href="{{route('seller.profile')}}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
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


                                        @endsection
                                        @section('footer_scripts')
                                        <script type="text/javascript" src="{{admin_asset('js/pages/select2.js')}}"></script>
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('#product_type').select2({width:'resolve',theme:'classic', placeholder: "Select Permissions",
                                                    allowClear: 'true'});
                                            });

                                        </script>
                                        @endsection