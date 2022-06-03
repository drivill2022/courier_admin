@extends('merchant.layouts.main')
@section('title', 'Shipment Action')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Cancel Order/ Status Order/ Claim Order</h4>
                </div>
            </div> </div> <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <div class="card">
                        <div class="p-4 border-top">
                            <form>
                                <div class="row">  
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="shipment_no">Shipment Number</label>
                                            <input id="shipment_no" name="shipment_no" type="text" class="form-control" value="#SPM00000101" value="{{$shipment->shipment_no}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="ajent_name">Agent Name</label>
                                            <input id="ajent_name" name="ajent_name" type="text" class="form-control" value="{{$shipment->receiver_name}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="productname">Date & Time</label>
                                            <input type="datetime-local" value="2019-08-19T13:45:00" id="example-datetime-local-input" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturername">Resign For Claim</label>
                                            <select  class="form-select">
                                              <option >Rider isn't here </option>
                                              <option >Wrong Address</option>
                                              <option>Wrong item Send</option>
                                              <option> Cancel By User</option>
                                          </select>
                                      </div>
                                  </div>




                                  <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label class="form-label" for="manufacturername">Claim Note 1:</label>
                                        <textarea class="form-control" id="metadescription" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label class="form-label" for="manufacturername">Claim Note 2:</label>
                                        <textarea class="form-control" id="metadescription" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label class="form-label" for="manufacturername">Claim Note 3:</label>
                                        <textarea class="form-control" id="metadescription" rows="2"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row my-4">
                              <div class="col text-end">
                                  <a href="#" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                                  <a href="#" class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Save </a>
                              </div> <!-- end col -->
                          </div>
                      </form>
                  </div>
              </div>
          </div>


      </div>
  </div>
</div>
<!-- end row -->

<!-- end row-->

</div> <!-- container-fluid -->

<!-- End Page-content -->
@endsection
