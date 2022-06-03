@extends('admin.layouts.main')
@section('title', 'Roles')
@section('content')
<!-- edit page -->
<style type="text/css">
    .select2-results__option[aria-selected=true] {
        display: none;
    }
    input.select2-search__field {
        width: auto !important;
    }

    .select2-container--classic .select2-selection--multiple {
        background-color: white;
        border: 1px solid #d9d9d9;
        border-radius: 0px;     
    }
    .select2-container--classic .select2-selection--multiple {
        width: 100% !important;
        color: #55595c;
        background-color: #fff;
        border-radius: 0px  !important;
        background-color: white !important;
        border: 1px solid #d9d9d9 !important;
    }
</style>
<link rel="stylesheet" href="{{ admin_asset('css/select2.css') }}">
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Add Role</h4> <a href="{{ route('admin.roles.index') }}" class="btn btn-primary pull-right"><i class="fa fa-angle-left"></i> Back</a>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                           <form class="form-horizontal" action="{{route('admin.roles.store')}}" method="POST" enctype="multipart/form-data" role="form">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="name" class="col-xs-2 col-form-label">Role Name</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Role Name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-xs-2 col-form-label">Description</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" value="{{ old('description') }}" name="description" required id="description" placeholder="Role Description">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-xs-2 col-form-label">Role Permissions</label>
                                <div class="col-xs-10">
                                    <select class="form-control" name="permissions[]" id="permissions" multiple placeholder="Select Permissions">
                                        @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}" @if(in_array($permission->id, old('permissions')?:[])) selected @endif >{{ucwords($permission->name)}}</option> 
                                        @endforeach                           
                                    </select>
                                </div>
                            </div>          

                            <div class="form-group row">
                                <label for="zipcode" class="col-xs-2 col-form-label"></label>
                                <div class="col-xs-10">
                                    <button type="submit" class="btn btn-primary">Add Role</button>
                                    <a href="{{route('admin.roles.index')}}" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </form>


                    </div> <!-- container-fluid -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript" src="{{admin_asset('js/pages/select2.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#permissions').select2({width:'resolve',theme:'classic', placeholder: "Select Permissions",
            allowClear: 'true'});
    });
    
</script>
@endsection