@extends('admin.layouts.main')
@section('title', 'Edit Item')
@section('content')
<link href="{{admin_asset('libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

<div class="page-content">
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Edit Item</h4>
          <a class="float-right" href="{{ route('admin.sellers.items.index',$item->seller_id) }}">
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
                  <form method="POST" action="{{ route('admin.sellers.items.update',[$item->seller_id,$item->id]) }}" enctype="multipart/form-data">

                    @csrf()
                    @method('PATCH')
                    <input type="hidden" name="seller_id" value="{{$item->seller_id}}">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="name">Item Name</label>
                          <input id="name" name="name" type="text" class="form-control" value="{{$item->name}}" placeholder="Name">
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
                          <input value="{{$item->price}}" id="price" name="price" type="number" class="form-control" step="0.01" placeholder="Price">
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
                            <option value="{{$pt->id}}" @if($item->product_type==$pt->id) selected @endif>{{$pt->name}}</option>
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
                            <option value="{{$ct->id}}" @if($item->category_id==$ct->id) selected @endif>{{$ct->name}}</option>
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
                          {!!get_sub_category($item->category_id,$item->sub_category_id)!!}
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
                          @if($item->picture)
                        <img src="{{img($item->picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                        @endif
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
                            <option value="Active" @if ($item->status=='Active')
                            selected @endif>Active</option>
                            <option value="Blocked" @if ($item->status=='Blocked')
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
                              <input type="checkbox" name="add_more" id="add_more" value="1" @if($item->weight || $item->color || $item->length || $item->size) checked @endif>
                              <label for="add_more">Add More Details</label>
                            </div>
                          </div>
                          <div id="div1" class="{{($item->weight || $item->color || $item->length || $item->size)?:'hide'}}">
                            <div class="row mt-3">
                              <div class="col-lg-6">
                                <div class="mb-3">
                                  <label class="form-label" for="size">Size :</label>
                                  <input type="text" name="size" class="form-control" value="{{$item->size}}" placeholder="Size" id="size">
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
                                  <input type="text" name="color" class="form-control" value="{{$item->color}}" placeholder="Color">
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
                                  <input type="text" name="weight" class="form-control" value="{{$item->weight}}" placeholder="Weight">
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
                                  <input type="text" name="length" class="form-control" value="{{$item->length}}" placeholder="Length">
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
                        <a href="{{ route('admin.sellers.items.index',$item->seller_id) }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
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
               url: "{{ url('admin/sellers/categories') }}/"+id,
               success: function(result) {
                  $('#sub_category_id').html(result);
                 }
               });
           });
    });

  </script>
  @endpush
