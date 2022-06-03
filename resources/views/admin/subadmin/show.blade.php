@extends('admin.layouts.main')
@section('title', 'Add Admins')
@section('content')

<div class="page-content">
	<div class="container-fluid">

		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0">View User Details</h4>
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
						<div class="form-group row">

								<label for="picture" class="col-xs-2 col-form-label">@lang('admin.picture')</label>

								<div class="col-xs-10">

									@if(isset($user->picture))

									<img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{img($user->picture)}}">

									@endif						

								</div>

							</div>

							<div class="form-group row">

								<label for="name" class="col-xs-2 col-form-label">@lang('admin.name')</label>

								<div class="col-xs-10">

									<input class="form-control" type="text" value="{{ $user->name }}" name="name" required id="name" placeholder="Name">

								</div>

							</div>

							<div class="form-group row">

								<label for="email" class="col-xs-2 col-form-label">@lang('admin.email')</label>

								<div class="col-xs-10">

									<input class="form-control" type="email" value="{{ $user->email }}" name="email" required id="email" placeholder="Email">

								</div>

							</div>

							<div class="form-group row">

								<label for="role_id" class="col-xs-2 col-form-label">@lang('admin.role')</label>

								<div class="col-xs-10">

									<input class="form-control" type="text" value="{{strtoupper($user->role->name)}}" >

								</div>					

							</div>

							<div class="form-group row">

								<label for="role_id" class="col-xs-2 col-form-label">@lang('admin.permission')</label>

								<div class="col-xs-10">

									<input class="form-control" type="text" value="{{strtoupper($user->role->name)}}" >

								</div>					

							</div>

							<div class="form-group row">

								<label for="role_id" class="col-xs-2 col-form-label">@lang('admin.created')</label>

								<div class="col-xs-10">

									<input class="form-control" type="text" value="{{date('d M Y h:i A',strtotime($user->created_at))}}" >

								</div>					

							</div>

							<div class="form-group row">

								<label for="role_id" class="col-xs-2 col-form-label">@lang('admin.permission')</label>

								<div class="col-xs-10" >

									@if($user->role->permissions)

									<table class="table table-striped table-bordered dataTable" id="table-4">

										<thead>

											<tr>

												<th>Action</th>	

												<th>Permission</th>	

											</tr>

										</thead>

										<tbody>

											@foreach($user->role->permissions as $permission)

											<tr>

												<td>{{ucwords($permission->name)}}</td>

												<td><span class="btn btn-success"><i class="fa fa-check"></i></span></td>

											</tr>

											@endforeach

										</tbody>

									</table>

									@endif

								</div>					

							</div>



						</div>

					</div>

				</div>

</div>
</div>
</div>
</div>




				@endsection

				@section('footer_scripts')

				<script type="text/javascript">

					$('.form-control').prop('readonly', true);

				</script>

				@endsection

