@extends('admin.layouts.main')
@section('title', 'Edit Merchant Banner')
@section('content')<!-- edit page -->

<div class="page-content">
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Edit Merchant Banner</h4>
          <a href="{{ route('admin.merchant-banners.index') }}">
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
                     <form method="POST" action="{{ route('admin.merchant-banners.update', $banner->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="mb-3">
                                <label class="form-label" for="images upload">Image(Dimension:1125px*300px)</label>
                                <input name="image" id="image" type="file" multiple="multiple" class="form-control" accept="images/*"> 
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                                <br><br>
                                <img src="{{img($banner->image)}}" class="avatar-lg me-2">
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