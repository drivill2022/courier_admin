@extends('admin.layouts.main')
@section('title', 'Edit Category')
@section('content')
 <style type="text/css">
        .input-checkbox{
            margin-left: 10px;
        }
        #child_category{
            display: none;
        }
    </style>
<div class="page-content">
  <div class="container-fluid">
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Edit Category</h4>
          <a href="{{ route('admin.sellers.categories.index') }}">
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
                  <form method="POST" action="{{ route('admin.sellers.categories.update', $category->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">

                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="name">Category  Name</label>
                          <input id="name" name="name" type="text" class="form-control" value="{{$category->name}}">
                          @error('name')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div> 
                      
                      @if($categories->count()>0)
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label mt-4" for="type">Is Child Category</label>
                          <span>&nbsp;</span> 
                          <input class="mt-4" type="checkbox" name="type" id="type" @if($category->parent_category_id) checked @endif class="input-checkbox">
                        </div>
                      </div> 

                        <div class="col-lg-6" id="child_category">
                        <div class="mb-3">
                          <label class="form-label" for="parent_category_id">Parent Category</label>
                          <select class="form-control" id="parent_category_id" name="parent_category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $ct)
                            <option value="{{$ct->id}}" @if ($category->parent_category_id==$ct->id)
                              selected @endif>{{$ct->name}}</option>
                              @endforeach
                            </select>
                            @error('parent_category_id')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>
                     @endif
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="images upload">Category Photo:</label>
                        @if($category->picture)
                        <img src="{{img($category->picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                        @endif
                        <input name="picture" id="picture" type="file" multiple="multiple" class="form-control" accept="images/*"> 
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
                          <option value="Active" @if ($category->status=='Active')
                            selected @endif>Active</option>
                            <option value="Blocked" @if ($category->status=='Blocked')
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
                            <a href="{{ route('admin.sellers.categories.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                            <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Update </button>
                          </div> <!-- end col -->
                        </div>
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
<script type="text/javascript">
  $(document).ready(function () {
   $('#type').change(function (e) {
    if(this.checked){
      $('#child_category').show();
    }else{
      $('#child_category').hide();
    }
   });
 });
</script>
@endsection