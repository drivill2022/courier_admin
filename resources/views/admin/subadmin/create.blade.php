@extends('admin.layouts.main')
@section('title', 'Add Admins')
@section('content')
<style type="text/css">
	.invalid-feedback{display: inline-block;}
</style>
<div class="page-content">
	<div class="container-fluid">

		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0">Add Admin</h4>
					<a href="{{ route('admin.sub-admins.index') }}" class="btn btn-primary pull-right"><i class="fa fa-angle-left"></i> Back</a>

				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
						<div class="p-4 border-top">
							<form class="form-horizontal" action="{{route('admin.sub-admins.store')}}" method="POST" enctype="multipart/form-data" role="form">
								{{csrf_field()}}
								<div class="form-group row">
									<label for="role_id" class="col-xs-12 col-form-label">Role<span class="">*</span></label>
									<div class="col-xs-10">
										<select name="role_id" id="role_id" class="form-control">
											<option value="">Please Select Role</option>
											@if($roles)
											@foreach($roles as $role)
											<option value="{{$role->id}}" @if(old('role_id') == $role->id) selected @endif>{{strtoupper($role->name)}}</option>
											@endforeach
											@endif
										</select>
										@error('role_id')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="form-group row">
									<label for="name" class="col-xs-12 col-form-label">Name <span class="">*</span></label>
									<div class="col-xs-10">
										<input class="form-control" type="text" value="{{ old('name') }}" name="name" id="name" placeholder="Please Enter Name">
										@error('name')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>			

								<div class="form-group row">
									<label for="email" class="col-xs-12 col-form-label">Email<span class="">*</span></label>
									<div class="col-xs-10">
										<input class="form-control" type="email" name="email" value="{{old('email')}}" id="email" placeholder="Please Enter Email">
										@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="form-group row">
									<label for="mobile" class="col-xs-12 col-form-label">Mobile<span class="">*</span></label>
									<div class="col-xs-10">
										<input class="form-control" type="text" name="mobile" value="{{old('mobile')}}" id="mobile" placeholder="Please Enter Mobile Number" maxlength="10">
										@error('mobile')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div class="form-group row">
									<label for="password" class="col-xs-12 col-form-label">Password<span class="">*</span></label>
									<div class="col-xs-10">
										<input class="form-control" type="password" name="password" id="password" placeholder="Please Enter Password">
										@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div class="form-group row">
									<label for="password_confirmation" class="col-xs-12 col-form-label">Confirm Password<span class="">*</span></label>
									<div class="col-xs-10">
										<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
										@error('password_confirmation')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div class="form-group row">
									<label for="picture" class="col-xs-12 col-form-label">Picture<!-- <span class="">*</span> --></label>
									<div class="col-xs-10">
										<input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
										@error('picture')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="form-group row">
									<label for="address" class="col-xs-12 col-form-label">Address<span class="">*</span></label>
									<div class="col-xs-10">
										<input class="form-control" type="text" name="address" value="{{old('address')}}" id="address" placeholder="Please Enter Address" maxlength="255">
										@error('address')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								

								<div class="form-group row">
									<label for="zipcode" class="col-xs-12 col-form-label"></label>
									<div class="col-xs-10">
										<button type="submit" class="btn btn-primary">Add</button>
										<a href="{{route('admin.sub-admins.index')}}" class="btn btn-default">Cancel</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- end row -->                        
	</div> <!-- container-fluid -->
</div>


@endsection
