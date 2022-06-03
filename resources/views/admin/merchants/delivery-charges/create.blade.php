@extends('admin.layouts.main')
@section('title', 'Add Delivery Charge')
@section('content')<!-- edit page -->

<div class="page-content">
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Add Delivery Charge</h4>
          <a href="{{ route('admin.delivery-charges.index') }}">
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
                  <form method="POST" action="{{ route('admin.delivery-charges.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="merchant_id">Merchant:</label>
                           <x-merchants-dropdown :selected="old('merchant_id')" name="merchant_id"/>
                          @error('merchant_id')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="product_type">Product Type:</label>
                           @php($ptype=old('product_type')?old('product_type'):'')
                           <x-product-type-dropdown :selected="$ptype" name="product_type" single="1"/>
                          @error('product_type')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="from">From:</label>
                           @php($from=old('from')?old('from'):'')
                           <select id="from" name="from" class="form-control">
                              <option value="1" @if($from == 1) selected @endif>Metro area</option>
                              <option value="2" @if($from == 2) selected @endif>Suburbs area</option>
                              <option value="3" @if($from == 3) selected @endif>Intercity area</option>
                           </select>
                          @error('from')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="to">To:</label>
                           @php($to=old('to')?old('to'):'')
                           <select name="to" id="to" class="form-control">
                              <option value="1" @if($to == 1) selected @endif>Metro area</option>
                              <option value="2" @if($to == 2) selected @endif>Suburbs area</option>
                              <option value="3" @if($to == 3) selected @endif>Intercity area</option>
                           </select>
                          @error('to')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      {{--<div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="del_time">Delivery Time:</label>
                          <input id="del_time" name="del_time" type="text" class="form-control" value="{{old('del_time')}}" placeholder="4-5 hours">
                          @error('del_time')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="s_division">Pickup Division:</label>
                          <x-division-dropdown :selected="old('s_division')" id="s_division" name="s_division" />
                          @error('s_division')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="s_district">Pickup District:</label>
                          <x-district-dropdown :selected="old('s_district')" id="s_district" name="s_district" :division="old('s_division')" />
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
                          <x-thana-dropdown :selected="old('s_thana')" id="s_thana" name="s_thana" :district="old('s_district')" />
                          @error('s_thana')
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
                          <label class="form-label" for="d_district">Delivery District:</label>
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
                      </div> --}}

                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="gm_500">500 GM Charge</label>
                          <input id="gm_500" name="gm_500" type="text" class="form-control" value="{{old('gm_500')}}" placeholder="10 tk">
                          @error('gm_500')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="kg_1">1 KG Charge</label>
                          <input id="kg_1" name="kg_1" type="number" step="0.01" class="form-control" value="{{old('kg_1')}}" placeholder="10 tk">
                          @error('kg_1')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="kg_2">2 KG Charge</label>
                          <input id="kg_2" name="kg_2" type="number" step="0.01" class="form-control" value="{{old('kg_2')}}" placeholder="10 tk">
                          @error('kg_2')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="kg_3">3 KG Charge</label>
                          <input id="kg_3" name="kg_3" type="number" step="0.01" class="form-control" value="{{old('kg_3')}}" placeholder="10 tk">
                          @error('kg_3')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="kg_4">4 KG Charge</label>
                          <input id="kg_4" name="kg_4" type="number" step="0.01" class="form-control" value="{{old('kg_4')}}" placeholder="10 tk">
                          @error('kg_4')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="kg_5">5 KG Charge</label>
                          <input id="kg_5" name="kg_5" type="number" step="0.01" class="form-control" value="{{old('kg_5')}}" placeholder="10 tk">
                          @error('kg_5')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                       <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="kg_6">6 KG Charge</label>
                          <input id="kg_6" name="kg_6" type="number" step="0.01" class="form-control" value="{{old('kg_6')}}" placeholder="10 tk">
                          @error('kg_6')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                       <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="kg_7">7 KG Charge</label>
                          <input id="kg_7" name="kg_7" type="number" step="0.01" class="form-control" value="{{old('kg_7')}}" placeholder="10 tk">
                          @error('kg_7')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                       <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="kg_upto_seven">Upto 7 KG Charge</label>
                          <input id="kg_upto_seven" name="kg_upto_seven" type="number" step="0.01" class="form-control" value="{{old('kg_upto_seven')}}" placeholder="10 tk">
                          @error('kg_upto_seven')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="row mb-4">
                        <div class="col text-end">
                          <a href="{{ route('admin.delivery-charges.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                          <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Save</button>
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

        <!-- end row-->

      </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @endsection
@section('footer_scripts')
 <script type="text/javascript">
    $(document).ready(function(){
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