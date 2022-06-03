@extends('admin.layouts.main')
@section('title', 'Manage Complain')
@section('content')

<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Complain List</h4>



</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-lg-12">
<div> 
<div class="float-end">
</div>
<a href="{{ route('admin.help.create') }}">
<button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add New Complain</button></a>
</div>
<div class="table-responsive mb-4">
<table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
<thead>
    <tr class="bg-transparent">
        <th>Shipment No.</th>
        <th>Merchant Name</th>
        <th>Complain</th>
        <th>Date</th>
        <th>Status</th>
        <th style="width: 120px;">Action</th>
    </tr>
</thead>
<tbody>
    @foreach($list as $s)
    <tr>
        <td>{{$s->shipment_no}}</td>
        <td>{{$s->merchant_name}}</td>
        <td>{{$s->complain}}</td>
        <td>{{MydateTime($s->created_at)}}</td>
        <td>{{($s->status == "0")?"Under Investigation":"Solved"}}</td>
        <td class="d-flex">
            <a href="{{ route('admin.help.edit',$s->id) }}" class="px-3 text-primary"><i class="uil uil-pen font-size-18"></i></a>
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
