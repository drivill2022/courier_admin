@extends('admin.layouts.main')
@section('title', 'Edit Page Content')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Page</h4>
                    <a href="{{ route('admin.pages.index') }}">
                      <button type="button" class="btn btn-success waves-effect waves-light mb-3">< Back</button></a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                         <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <form class="form-horizontal" action="{{route('admin.pages.update',$page->id)}}" method="POST" enctype="multipart/form-data" role="form">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input id="title" name="title" type="text" class="form-control" value="{{$page->title}}">
                                            @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        
                                        <div class="mb-3">
                                            <label class="form-label" for="mobile">Content</label>
                                            <textarea class="form-control ckeditor" name="content" id="content"> {{$page->content}}</textarea>

                                            @error('content')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                          <label class="form-label" for="statusm">Status:</label>
                                          <select  class="form-select" name="status" id="statusm">
                                            <option value="Active" @if ($page->status=='Active')
                                            selected @endif>Active</option>
                                            <option value="Blocked" @if ($page->status=='Blocked')
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
                                            <a href="{{ route('admin.pages.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
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




    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

@endsection               
@section('footer_scripts')
<!-- ckeditor -->
<script src="{{admin_asset('libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js')}}"></script>

<!--tinymce js-->
<script src="{{admin_asset('libs/tinymce/tinymce.min.js')}}"></script>

<!-- init js -->
<script src="{{admin_asset('js/pages/form-editor.init.js')}}"></script>


<script>
    ClassicEditor
    .create( document.querySelector( '#content' ) )
    .catch( error => {
        console.error( error );
    } );
</script>
@endsection