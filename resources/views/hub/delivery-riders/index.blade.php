@extends('hub.layouts.main')
@section('title', 'Delivery Riders')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">All Delivery Riders </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div>
                    <a href="{{ route('hub.riders.create') }}">
                        <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add Delivery Rider</button></a>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                            <thead>
                                <tr class="bg-transparent">
                                    <th style="width: 20px;">
                                        Delivery Rider Photo 
                                    </th>
                                    <th>Delivery Rider Name</th>
                                    <th>Delivery Rider Address</th>
                                    <th>Hub Name</th>
                                    <th>Contact number</th>
                                    <th>NID Number</th>
                                    <th>vehicle</th>
                                    <th>Plate No.</th>
                                    <th>Status</th>
                                    <th style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($riders)
                                @foreach($riders as $rd)
                                <tr>
                                    <td>
                                        <img src="{{img($rd->picture)}}" class="avatar-xs rounded-circle me-2">
                                    </td>

                                    <td><a href="{{ route('hub.riders.show',$rd->id) }}">{{$rd->name}}</a></td>

                                    <td>
                                        {{$rd->address}}
                                    </td>
                                    <td>{{@$rd->hub->name}}</td>
                                    <td>{{$rd->mobile}}</td>
                                    <td>{{$rd->nid_number}}</td>
                                    <td>{{$rd->vtype->name}} </td>
                                    <td>{{$rd->vehicle?$rd->vehicle->plat_number:'NA'}}</td>
                                    <td>{{$rd->status}}</td>
                                    <td class="d-flex">
                                         <a href="{{ route('hub.riders.edit',$rd->id) }}" class="px-3 text-primary btn btn-link"><i class="uil uil-pen font-size-18"></i></a>
                                         <a href="{{ route('hub.riders.show',$rd->id) }}" class="px-3 text-primary btn btn-link"><i class="uil uil-eye font-size-18"></i></a>
                                    </td>
                             </tr>
                             @endforeach
                              @endif
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
