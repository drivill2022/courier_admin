@extends('admin.layouts.main')
@section('title', 'Manage Delivery Charges')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">All Merchant Delivery Charges</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <a href="{{ route('admin.delivery-charges.create') }}">
                                    <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add Delivery Charge</button></a>
                                </div>
                                <div class="mb-4">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th>Merchant</th>
                                                <th>Product</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Charge 500gm</th>
                                                <th>Charge 1kg</th>
                                                <th>Charge 2kg</th>
                                                <th>Charge 3kg</th>
                                                <th>Charge 4kg</th>
                                                <th>Charge 5kg</th>
                                                <th>Charge 6kg</th>
                                                <th>Charge 7kg</th>
                                                <th>Charge Upto 7kg</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($dcharges as $k=>$d)
                                            <tr>
                                                <td>{{ucwords(@$d->merchant->name)}}</td>
                                                <td>{{ucwords($d->ptype->name)}} </td>
                                                <td>{{delivery_charges_area($d->from)}} </td>
                                                <td>{{delivery_charges_area($d->to)}} </td>
                                                <td>{{$d->gm_500}} </td>
                                                <td>{{$d->kg_1}} </td>
                                                <td>{{$d->kg_2}} </td>
                                                <td>{{$d->kg_3}} </td>
                                                <td>{{$d->kg_4}} </td>
                                                <td>{{$d->kg_5}} </td>
                                                <td>{{$d->kg_6}} </td>
                                                <td>{{$d->kg_7}} </td>
                                                <td>{{$d->kg_upto_seven}} </td>
                                                <td class="d-flex">
                                                   
                                                      <form action="{{ route('admin.delivery-charges.destroy', $d->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                     <a href="{{ route('admin.delivery-charges.edit',$d->id) }}" class="px-3 text-primary"><i class="uil uil-pen font-size-18"></i></a>
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