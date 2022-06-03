@extends('admin.layouts.main')
@section('title', 'Settings')
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
					<h4 class="mb-0">{{ucwords($setting)}} Settings</h4>
					{{-- <a href="{{ route('admin.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> --}}

				</div>
			</div>
		</div>
		<!-- end page title -->
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
						<div class="p-4 border-top">
							 <form class="form-horizontal" action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}

				<div class="form-group row">
					<label for="site_title" class="col-xs-2 col-form-label">@lang('admin.setting.Site_Name')</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('site_title', 'Drivill')  }}" name="site_title" required id="site_title" placeholder="Site Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="site_logo" class="col-xs-2 col-form-label">@lang('admin.setting.Site_Logo')</label>
					<div class="col-xs-10">
						@if(Setting::get('site_logo')!='')
	                    <img style="height: 90px; margin-bottom: 15px;" src="{{ img(Setting::get('site_logo')) }}" class="img img-fluid">
	                    @endif
						<input type="file" accept="image/*" name="site_logo" class="dropify form-control-file" id="site_logo" aria-describedby="fileHelp">
					</div>
				</div>


				<div class="form-group row">
					<label for="site_icon" class="col-xs-2 col-form-label">@lang('admin.setting.Site_Icon')</label>
					<div class="col-xs-10">
						@if(Setting::get('site_icon')!='')
	                    <img style="height: 90px; margin-bottom: 15px;" src="{{ img(Setting::get('site_icon')) }}" class="img img-fluid">
	                    @endif
						<input type="file" accept="image/*" name="site_icon" class="dropify form-control-file" id="site_icon" aria-describedby="fileHelp">
					</div>
				</div>

                <div class="form-group row">
                    <label for="tax_percentage" class="col-xs-2 col-form-label">@lang('admin.setting.Copyright_Content')</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{!! Setting::get('site_copyright', '&copy; '.date('Y').' Drivill') !!}" name="site_copyright" id="site_copyright" placeholder="Site Copyright">
                    </div>
                </div>

				<div class="form-group row">
					<label for="hub_search_radius" class="col-xs-2 col-form-label">Hub Search Radius</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ Setting::get('hub_search_radius', '100')  }}" name="hub_search_radius" required id="hub_search_radius" placeholder="Hub Search Radius" min="1">
					</div>
				</div>
			

				<div class="form-group row">
					<label for="rider_search_radius" class="col-xs-2 col-form-label">Rider Search Radius</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ Setting::get('rider_search_radius', '100')  }}" name="rider_search_radius" required id="rider_search_radius" placeholder="Rider Search Radius" min="1">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="sos_number" class="col-xs-2 col-form-label">@lang('admin.setting.SOS_Number')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ Setting::get('sos_number', '198')  }}" name="sos_number" required id="sos_number" placeholder="SOS Number">
					</div>
				</div>

				

				<div class="form-group row">
					<label for="contact_number" class="col-xs-2 col-form-label">@lang('admin.setting.Contact_Number')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ Setting::get('contact_number', '89798797')  }}" name="contact_number" required id="contact_number" placeholder="Contact Number Line 1">
					</div>
				</div>

				<div class="form-group row">
					<label for="contact_number" class="col-xs-2 col-form-label">@lang('admin.setting.Contact_Number_2')</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('contact_number_2', '080 Bikeman')  }}" name="contact_number_2" required id="contact_number_2" placeholder="Contact Number Line 2">
					</div>
				</div>
				

				<div class="form-group row">
					<label for="contact_email" class="col-xs-2 col-form-label">@lang('admin.setting.Contact_Email')</label>
					<div class="col-xs-10">
						<input class="form-control" type="email" value="{{ Setting::get('contact_email', '')  }}" name="contact_email" required id="contact_email" placeholder="Contact Email">
					</div>
				</div>

				
				<div class="form-group row">
					<label for="map_key" class="col-xs-2 col-form-label">@lang('admin.setting.map_key')</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('map_key')  }}" name="map_key" required id="map_key" placeholder="@lang('admin.setting.map_key')">
					</div>
				</div>

				

				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">@lang('admin.setting.Update_Site_Settings')</button>
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


