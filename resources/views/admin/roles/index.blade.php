@extends('admin.layouts.main')
@section('title', 'Roles')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Admin Roles</h4> <a class="btn btn-success" href="{{ route('admin.roles.create') }}"> Create New Role</a>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                           <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Description</th>                       
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ strtoupper($role->name) }}</td>
                        <td>{{ $role->description?:'N/A' }}</td>
                      
                        <td>{{$role->created_at? date('d M Y h:i A',strtotime($role->created_at)):'N/A' }}</td>
                        <td>
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                                {{-- <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Role?')"><i class="fa fa-trash"></i> Delete</button> --}}
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Description</th>                       
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>


                        </div> <!-- container-fluid -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection