@extends('admin.layouts.main')
@section('title', 'Manage Hubs')
@section('content')

<div class="page-content">
    <div class="container-fluid"> 
    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">All Hubs</h4>
                    <a href="{{ route('admin.hubs.create') }}">
                        <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add Hub</button></a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div>

                    
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                            <thead>
                                <tr class="bg-transparent">
                                    <th>Hub ID</th>
                                    <th>Hub Name</th>
                                    <th>Hub Address</th>
                                    <th>Phone number</th>
                                    <th>Supervisor Name</th>
                                    <th>Supervisor Contact No.</th>
                                    <th>Total Delivery Rider</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach($hubs as $h)
                                <tr>
                                    <td><a href="{{ route('admin.hubs.show',$h->id) }}">{{$h->hbsid}}</a></td>
                                    <td><a href="{{ route('admin.hubs.show',$h->id) }}">{{ucwords($h->name)}} </a></td>
                                    <td>
                                        {{trim($h->address)}}
                                    </td>
                                    <td>{{$h->phone}}</td>
                                    <td>{{ucwords($h->supervisor_name)}}</td>
                                    <td>{{$h->sup_phone}}</td>
                                    <td>{{$h->total_riders}} </td>
                                    <td class="d-flex">
                                        <a href="{{ route('admin.hubs.edit',$h->id) }}" class="btn btn-primary px-2 mx-1"><i class="uil uil-pen font-size-15">Edit</i></a>
                                         <a href="{{ route('admin.hubs.show',$h->id) }}" class="btn btn-primary px-2 mx-1"><i class="uil uil-eye font-size-15">View</i></a>
                                         <form action="{{ route('admin.hubs.destroy', $h->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="px-3 mx-1 btn btn-danger" onclick="return confirm('Are you sure you want to delete this hub?')" > <i class="uil uil-trash-alt font-size-18"></i>Delete</button>
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
