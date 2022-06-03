@extends('seller.layouts.main')
@section('title', 'Add Item')
@section('content')
<link href="{{admin_asset('libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

<div class="page-content">
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Add Item</h4>
          <a class="float-right" href="{{ route('seller.items.index') }}">
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
                  <form method="POST" action="{{ route('seller.items.store') }}" enctype="multipart/form-data">

                    @csrf()
                    <input type="hidden" name="seller_id" value="{{Auth::guard('seller')->user()->id}}">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="name">Item Name</label>
                          <input id="name" name="name" type="text" class="form-control" value="{{old('name')}}" placeholder="Name">
                          @error('name')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>


                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="price">Price</label>
                          <input value="{{old('price')}}" id="price" name="price" type="number" class="form-control" step="0.01" placeholder="Price">
                          @error('price')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label">Product Type </label>
                          <select class="select2 form-control select2-multiple"  data-placeholder="Select Product Type" name="product_type">
                            <option value=""></option>
                            @foreach($ptypes as $pt)
                            <option value="{{$pt->id}}" @if(old('product_type')==$pt->id) selected @endif>{{$pt->name}}</option>
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
                          <label class="form-label" for="manufacturername">Product Category  </label>
                          <select class="select2 form-control select2-multiple"  data-placeholder="Select Category" name="category_id" id="category_id">
                            <option value=""></option>
                            @foreach($categories as $ct)
                            <option value="{{$ct->id}}" @if(old('category_id')==$ct->id) selected @endif>{{$ct->name}}</option>
                            @endforeach
                          </select>
                          @error('category_id')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">

                        <div class="mb-3">
                          <label class="form-label" for="manufacturername">Product Sub Category  </label>
                          <select class="select2 form-control select2-multiple"  data-placeholder="Sub Category ..." name="sub_category_id" id="sub_category_id">

                          </select>
                          @error('sub_category_id')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="images upload">Product Image</label>
                          <input name="picture" type="file" accept="images/*"  class="form-control">
                          @error('picture')
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
                            <option value="Active" @if (old('status')=='Active')
                            selected @endif>Active</option>
                            <option value="Blocked" @if (old('status')=='Blocked')
                            selected @endif>Blocked</option>
                          </select>
                          @error('status')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="additional_bike_delivery_form">
                          <div class="cycle_motorcycle_radio_tab">
                            <div class="">
                              <input type="checkbox" name="add_more" id="add_more" value="1" @if(old('add_more')) checked @endif>
                              <label for="add_more">Add More Details</label>
                            </div>
                          </div>
                          <div id="div1" class="{{old('add_more')?:'hide'}}">
                            <div class="row mt-3">
                              <div class="col-lg-6">
                                <div class="mb-3">
                                  <label class="form-label" for="size">Size :</label>
                                  <input type="text" name="size" class="form-control" value="{{old('size')}}" placeholder="Size">
                                  @error('size')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                              </div>
                              <div class="col-lg-6">

                                <div class="mb-3">
                                  <label class="form-label" for="color">Color :</label>
                                  <input type="text" name="color" class="form-control" value="{{old('color')}}" placeholder="Color">
                                  @error('color')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="mb-3">
                                  <label class="form-label" for="weight">Weight :</label>
                                  <input type="text" name="weight" class="form-control" value="{{old('weight')}}" placeholder="Weight">
                                  @error('weight')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="mb-3">
                                  <label class="form-label" for="length">Length :</label>
                                  <input type="text" name="length" class="form-control" value="{{old('length')}}" placeholder="Length">
                                  @error('length')
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
                        <a href="{{ route('seller.items.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
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

    </div> <!-- container-fluid -->
  </div>
  <!-- End Page-content -->
  @endsection
  @push('script')

  <!-- plugins -->
  <script src="{{admin_asset('libs/select2/js/select2.min.js')}}"></script>
  <script src="{{admin_asset('libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
  <script src="{{admin_asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{admin_asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
  <script src="{{admin_asset('libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
  <script src="{{admin_asset('libs/%40chenfengyuan/datepicker/datepicker.min.js')}}"></script>
  <!-- init js -->
  <script src="{{admin_asset('js/pages/form-advanced.init.js')}}"></script>


  <script type="text/javascript">
    $(document).ready(function () {
      $('#add_more').change(function (e) {
        if(this.checked){
          $('#div1').show();
        }else{
          $('#div1').hide();
        }
      });

      $('#category_id').on('change', function() {
           var id = this.value;
           $("#rider").html('');
           $.ajax({
               type: "GET",
               url: "{{ url('seller/sub-category') }}/"+id,
               success: function(result) {
                  $('#sub_category_id').html(result);
                 }
               });
           });
    });

  </script>
  @endpush
