@extends('seller.layouts.main')
@section('title', 'Manage Seller Items')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">All Items</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <a href="{{ route('seller.items.create') }}">
                                        <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add Item</button></a>

                                </div>
                                <div class="table-responsive mb-4">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th style="width: 20px;"> Photo</th>
                                                <th>Item Name</th>
                                                <th>Price</th>
                                                <th>Product Type</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $it)
                                            <tr>
                                                <td>
                                                    <img src="{{img($it->picture)}}" class="avatar-xs rounded-circle me-2">
                                                </td>
                                                
                                                <td><a href="{{ route('seller.items.show',$it->id) }}">{{$it->name}}</a></td>
                                                <td> {{$it->price}} </td>
                                                <td>{{ucwords($it->producttype?$it->producttype->name:'')}}</td>
                                                <td>{{ucwords($it->category?$it->category->name:'')}}</td>
                                                <td> {{$it->status}} </td>
                                                <td class="d-flex">
                                                    <a href="{{ route('seller.items.edit',$it->id) }}" class="px-3 text-primary"><i class="uil uil-pen font-size-18"></i></a>
                                                    <a href="{{ route('seller.items.show',$it->id) }}" class="px-3 text-primary"><i class="uil uil-eye font-size-18"></i></a>
                                                  
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