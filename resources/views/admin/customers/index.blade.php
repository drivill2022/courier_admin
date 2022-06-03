@extends('admin.layouts.main')
@section('title', 'Manage Customers')
@section('content')

<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">User List</h4>
<a href="{{ route('admin.customers.create') }}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-2"></i> Add User</a>


</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">

<!-- end row -->
<div class="table-responsive mb-4">
<table class="table table-centered table-nowrap mb-0">
<thead>
<tr>
<th scope="col">Photo</th>
<th scope="col">Name</th>
<th scope="col">Mobile</th>
<th scope="col">Email</th>
<th scope="col">Location</th>
<th scope="col">Status</th>
<th scope="col" style="width: 200px;">Action</th>
</tr>
</thead>
<tbody>
@foreach($users as $u)
<tr>
<td>
<img src="{{img($u->picture)}}" class="avatar-xs rounded-circle me-2"></td>
<td>{{-- <a href="{{ route('admin.customers.show',$u->id) }}" class="text-body">{{$u->name}}</a> --}}
{{$u->name}}
</td>
<td>{{$u->mobile}}</td>
<td>{{$u->email}}</td>
<td>{{$u->address}}</td>
<td>Active</td>
<td>
<ul class="list-inline mb-0">
<li class="list-inline-item">
<a href="{{ route('admin.customers.edit',$u->id) }}" class="px-2 text-primary"><i class="uil uil-pen font-size-18"></i></a>
</li>
{{-- <li class="list-inline-item">
<a href="{{ route('admin.customers.show',$u-id) }}" class="px-2 text-primary"><i class="uil uil-eye font-size-18"></i></a>
</li> --}}
</ul>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<!-- end row -->

</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection                                                                         
