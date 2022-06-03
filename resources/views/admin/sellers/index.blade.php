@extends('admin.layouts.main')
@section('title', 'Manage Sellers')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">All Sellers</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <a href="{{ route('admin.sellers.create') }}">
                                    <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add Seller</button></a>
                                </div>
                                <div class="table-responsive mb-4">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th style="width: 30px">Business Logo</th>
                                                <th style="width: 20px;">Seller Photo</th>
                                                <th>Seller  ID</th>
                                                <th>Seller  Name</th>
                                                <th>Contact No.</th>
                                                <th>Location</th>
                                                <th>Product Sales</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sellers as $sl)
                                            <tr>
                                                <td>
                                                    <img src="{{img($sl->business_logo)}}" class="avatar-xs rounded-circle me-2">
                                                </td>
                                                <td>
                                                    <img src="{{img($sl->picture)}}" class="avatar-xs rounded-circle me-2">
                                                </td>
                                                <td><a href="{{ route('admin.sellers.show',$sl->id) }}">{{$sl->slid}}</a></td>
                                                <td><a href="{{ route('admin.sellers.show',$sl->id) }}">{{ucwords($sl->name)}}</a></td>
                                                <td> {{$sl->mobile}} </td>
                                                <td>{{trim($sl->address)}}</td>
                                                <td>{!!seller_product_type($sl->id,'name',1)!!}</td>
                                                
                                                <td class="d-flex">
                                                    <a href="{{ route('admin.sellers.edit',$sl->id) }}" class="px-3 text-primary"><i class="uil uil-pen font-size-18"></i></a>

                                                    <a href="{{ route('admin.sellers.items.index',$sl->id) }}" class="px-3 text-primary"><i class="uil uil-pen font-size-18"></i></a>

                                                    <a href="{{ route('admin.sellers.show',$sl->id) }}" class="px-3 text-primary"><i class="uil uil-eye font-size-18"></i></a>
                                                   {{--  <a href="javascript:void(0);" class="px-3 text-danger"><i class="uil uil-trash-alt font-size-18"></i></a> --}}
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