@extends('admin.layouts.main')
@section('title', 'Admins')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Manage Sub-Admins</h4> <a class="btn btn-success" href="{{ route('admin.sub-admins.create') }}"> Add New</a>
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
                                    <th>Name</th>
                                    <th>Role</th>                       
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ strtoupper($user->role->name) }}</td>
                                    <td>{{ $user->email }}</td> 
                                    <td>
                                        <form action="{{ route('admin.sub-admins.destroy', $user->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <a href="{{ route('admin.sub-admins.show', $user->id) }}" class="btn btn-info"><i class="fa fa-search"></i> View</a>
                                            <a href="{{ route('admin.sub-admins.edit', $user->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                                            <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this account?')"><i class="fa fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Role</th>                       
                                    <th>Email</th>
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

