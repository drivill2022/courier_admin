@extends('admin.layouts.main')
@section('title', 'Add Seller')
@section('content')
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
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Seller</h4>
                    <a href="{{ route('admin.sellers.index') }}">
                        <button type="button" class="btn btn-success waves-effect waves-light mb-3">< Back</button></a>

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
                                    <form method="POST" action="{{ route('admin.sellers.update', $seller->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="_method" value="PATCH">
                                 <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="name">Seller  Name</label>
                          <input id="name" name="name" type="text" class="form-control" value="{{$seller->name}}">
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
                          <input id="nid_no" name="nid_no" type="text" class="form-control" value="{{$seller->nid_no}}">
                          @error('nid_no')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="email">Email</label>
                          <input id="email" name="email" type="email" class="form-control" value="{{$seller->email}}">
                          @error('email')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="mobile">Contact Number</label>
                          <input id="mobile" name="mobile" type="text" class="form-control" value="{{$seller->mobile}}" maxlength="12">
                          @error('mobile')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="business_name">Business Name</label>
                          <input id="business_name" name="business_name" type="text" class="form-control" value="{{$seller->business_name}}">
                          @error('business_name')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>


                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="address"> Address:</label>
                          <textarea class="form-control" id="address" name="address" rows="2">{{$seller->address}}</textarea>
                          @error('address')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">

                        <div class="mb-3">
                          <label class="form-label" for="district">District :</label>
                          <select  class="form-select" name="district" id="district">
                            <option value="">Select District</option>
                            <option value="1" @if ($seller->district==1)
                            selected @endif>District 1</option>
                            <option value="2" @if ($seller->district==2)
                            selected @endif>District 2</option>
                            <option value="3" @if ($seller->district==3)
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
                           <option value="1" @if ($seller->thana==1)
                           selected @endif>Thana 1</option>
                           <option value="2" @if ($seller->thana==2)
                           selected @endif>Thana 2</option>
                           <option value="3" @if ($seller->thana==3)
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
                          <option value="">Select Division </option>
                          <option value="1" @if ($seller->division==1)
                          selected @endif>Division 1</option>
                          <option value="2" @if ($seller->division==2)
                          selected @endif>Division 2</option>
                          <option value="3" @if ($seller->division==3)
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
                        <label class="form-label" for="fb_page">Seller Business Facebook Page</label>
                        <input id="fb_page" name="fb_page" type="text" class="form-control" value="{{$seller->fb_page}}">
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
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label" for="images upload">Seller Photo:</label>
                        @if($seller->picture)
                        <img src="{{img($seller->picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
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
                        <label class="form-label" for="images upload">Seller Business Logo:</label>
                        @if($seller->business_logo)
                        <img src="{{img($seller->business_logo)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                        @endif
                        <input name="business_logo" id="business_logo" type="file" multiple="multiple" class="form-control"> 
                        @error('business_logo')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror 
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="statusm">Status:</label>
                      <select  class="form-select" name="status" id="statusm">
                        <option value="Active" @if ($seller->status=='Active')
                        selected @endif>Active</option>
                        <option value="Blocked" @if ($seller->status=='Blocked')
                        selected @endif>Blocked</option>
                      </select>
                      @error('status')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>


                        <div class="row my-4">
                            <div class="col text-end">
                                <a href="{{ route('admin.sellers.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                             <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Update </button>
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