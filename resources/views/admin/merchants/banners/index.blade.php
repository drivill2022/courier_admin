@extends('admin.layouts.main')
@section('title', 'Manage Merchant Banner')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Merchant Banners</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <a href="{{ route('admin.merchant-banners.create') }}">
                                    <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add Merchant Banner</button></a>
                                </div>
                                <div class="mb-4">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($banners as $k=>$b)
                                            <tr>
                                                <td><img src="{{img($b->image)}}" class="avatar-lg me-2"></td>
            
                                                <td class="d-flex">
                                                   
                                                      <form action="{{ route('admin.merchant-banners.destroy', $b->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                     <a href="{{ route('admin.merchant-banners.edit',$b->id) }}" class="px-3 text-primary"><i class="uil uil-pen font-size-18"></i></a>
                                                     <button class="px-3 text-danger btn btn-link" onclick="return confirm('Are you sure you want to delete this record?')" > <i class="uil uil-trash-alt font-size-18"></i></button>
                                                </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

  @endsection