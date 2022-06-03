@extends('admin.layouts.main')
@section('title', 'Add Category')
@section('content') <!-- edit page -->
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
          <h4 class="mb-0">Add Category</h4>
          <a href="{{ route('admin.sellers.categories.index') }}">
            <button type="button" class="btn btn-success waves-effect waves-light mb-3">< Back</button></a>
          </div>
        </div>
      </div>
      <!-- end page title -->
      @if (count($errors) > 0)
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

      <div class="row">
        <div class="col-lg-12">
          <div id="addproduct-accordion" class="custom-accordion">
            <div class="card">


              <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                <div class="p-4 border-top">
                  <form method="POST" action="{{ route('admin.sellers.categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="name">Category  Name</label>
                          <input id="name" name="name" type="text" class="form-control" value="{{old('name')}}">
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
                          <input class="mt-4 ml-4" type="checkbox" name="type" id="type" @if(old('type')) checked @endif class="input-checkbox">
                        </div>
                      </div> 

                        <div class="col-lg-6" id="child_category">
                        <div class="mb-3">
                          <label class="form-label" for="parent_category_id">Parent Category</label>
                          <select class="form-control" id="parent_category_id" name="parent_category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $ct)
                            <option value="{{$ct->id}}" @if (old('parent_category_id')==$ct->id)
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
                     <div class="col-lg-6">
                        <div class="mb-3">
                          <label class="form-label" for="name">Category Photo</label>
                          <input type="file" class="form-control" id="file"  name='picture' required accept="image/*">
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

                  <div class="row mb-4">
                    <div class="col text-end">
                      <a href="{{ route('admin.sellers.categories.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                      <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Save </button>
                    </div> <!-- end col -->
                  </div> <!-- end row-->
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