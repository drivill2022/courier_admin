@extends('merchant.layouts.main')
@section('title', 'Cancel Shipment')
@section('content')

<div class="page-content">
	<div class="container-fluid">

		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0">Cancel Shipment</h4>



				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">

						<div class="mt-2">

							<div class="product-desc">


								<div class="tab-content p-3 text-muted">

									<form method="POST" action="{{ route('merchant.shipment.cancel.post',$shipment->id) }}" enctype="multipart/form-data">
										@csrf
										<div class="row">


											<div class="col-lg-12">

												<div class="mb-3">
													<label class="form-label" for="reason">Reason for Cancel Shipment</label>
													<select class="form-select" name="reason">
														<option value="">Select Reason</option>
														@if(!empty($reasons))
														@foreach($reasons as $reason)
														<option value="{{$reason->title}}">{{$reason->title}}</option>
														@endforeach
														@endif
													</select>
													@error('reason')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
											<!-- <div class="col-lg-6">

												<div class="mb-3">
													<label class="form-label" for="cash_status">Case Status</label>
													<select  class="form-select" name="cash_status">
														<option value="">Select Cash Status</option>
														<option value="Solved">Solved</option>
														<option value="Refund">Refund</option>
														<option value="Pending Under Investigation">Pending Under Investigation</option>
														<option value="Not Paid">Not Paid</option>

													</select>
													@error('cash_status')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div> -->
											<div class="col-lg-12">

												<div class="mb-3">
													<label class="form-label" for="manufacturername"> Note :</label>
													<textarea class="form-control" id="metadescription" rows="1" name="note"></textarea>
													@error('note')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>


										</div>

										<div class="row mb-4 mt-4">
											<div class="col text-end">
												<a href="{{ route('merchant.shipment.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
												<button type="submit" class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Update </button>
											</div> <!-- end col -->
										</div>

									</form>

								</div>


							</div>
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
