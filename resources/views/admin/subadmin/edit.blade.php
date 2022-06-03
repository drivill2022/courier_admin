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
					<h4 class="mb-0">Edit Admin</h4>
					<a href="{{ route('admin.sub-admins.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
						<div class="p-4 border-top">
							<form class="form-horizontal" action="{{route('admin.sub-admins.update', $user->id )}}" method="POST" enctype="multipart/form-data" role="form">
								{{csrf_field()}}
								<input type="hidden" name="_method" value="PATCH">
								<div class="form-group row">
									<label for="role_id" class="col-xs-12 col-form-label">Role</label>
									<div class="col-xs-10">
										<select name="role_id" id="role_id" class="form-control" required>
											<option value="">Select Role</option>
											@if($roles)
											@foreach($roles as $role)
											<option value="{{$role->id}}" @if($role->id == $user->role_id) selected @endif>{{strtoupper($role->name)}}</option>
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
									<label for="name" class="col-xs-12 col-form-label">Name</label>
									<div class="col-xs-10">
										<input class="form-control" type="text" value="{{ $user->name }}" name="name" required id="name" placeholder="Name">
										@error('name')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>			

								<div class="form-group row">
									<label for="email" class="col-xs-12 col-form-label">Email</label>
									<div class="col-xs-10">
										<input class="form-control" type="email" required name="email" value="{{$user->email}}" id="email" placeholder="Email">
										@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="form-group row">
									<label for="mobile" class="col-xs-12 col-form-label">Mobile</label>
									<div class="col-xs-10">
										<input class="form-control" type="text" required name="mobile" value="{{$user->mobile}}" id="mobile" placeholder="Mobile Number" maxlength="10">
										@error('mobile')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

							

								<div class="form-group row">
									<label for="picture" class="col-xs-12 col-form-label">Picture</label>
									<div class="col-xs-10">
										@if($user->picture)
										<img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{img($user->picture)}}">
										@endif
										<input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
										@error('picture')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="form-group row">
									<label for="address" class="col-xs-12 col-form-label">Address</label>
									<div class="col-xs-10">
										<input class="form-control" type="text" required name="address" value="{{$user->address}}" id="address" placeholder="Address" maxlength="255">
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
										<button type="submit" class="btn btn-primary">Update Admin</button>
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


