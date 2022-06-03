@extends('admin.layouts.main')
@section('title', 'Add Permission')
@section('content')
<div class="page-content">
	<div class="container-fluid">

		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0">Add Permission</h4> <a href="{{ route('admin.permissions.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>
				</div>
			</div>
		</div>
		<!-- end page title -->
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
						<div class="p-4 border-top">
							<form class="form-horizontal" action="{{route('admin.permissions.store')}}" method="POST" enctype="multipart/form-data" role="form">
								{{csrf_field()}}
								<div class="form-group row">
									<label for="name" class="col-xs-12 col-form-label">Name</label>
									<div class="col-xs-10">
										<input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Permission Name">
									</div>
								</div>

								<div class="form-group row">
									<label for="slug" class="col-xs-12 col-form-label">URL Slug</label>
									<div class="col-xs-10">
										<input class="form-control" type="text" value="{{ old('slug') }}" name="slug" required id="slug" placeholder="Permission Route">
									</div>
								</div>

								<div class="form-group row">
									<label for="zipcode" class="col-xs-12 col-form-label"></label>
									<div class="col-xs-10">
										<button type="submit" class="btn btn-primary">Add</button>
										<a href="{{route('admin.permissions.index')}}" class="btn btn-default">Cancel</a>
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

