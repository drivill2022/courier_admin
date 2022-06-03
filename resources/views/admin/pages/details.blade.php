@extends('admin.layouts.main')
@section('title', 'View Page Content')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">View Page</h4>
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
                                            
                                            <h4>{{$page->title}}</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        
                                        <div class="mb-3">
                                            {!! $page->content !!}
                                            @error('content')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
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
