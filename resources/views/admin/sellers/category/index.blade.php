@extends('admin.layouts.main')
@section('title', 'Manage Categories')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">All Categories</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <a href="{{ route('admin.sellers.categories.create') }}">
                                    <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add Category</button></a>
                                </div>
                                <div class="table-responsive mb-4">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th style="width: 30px">Image</th>
                                                <th>Name</th>
                                                <th>Parent Category</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories as $ct)
                                            <tr>
                                                <td>
                                                    <img src="{{img($ct->picture)}}" class="avatar-xs rounded-circle me-2">
                                                </td>
                                                
                                                <td>{{ucwords($ct->name)}}</td>
                                                <td> {{$ct->parent?$ct->parent->name:'No Parent'}} </td>
                                                <td>{{trim($ct->status)}}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('admin.sellers.categories.edit',$ct->id) }}" class="px-3 text-primary"><i class="uil uil-pen font-size-18"></i></a>

                                                    
                                                  
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