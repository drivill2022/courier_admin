@extends('admin.layouts.main')
@section('title', 'Settings')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Payment Settlement</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">


                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <form>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="productname">Product ID</label>
                                            <input id="productname" name="productname" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturername">Seller ID </label>
                                            <select  class="form-select">

                                              <option >Seller 1</option>
                                              <option >Seller 2</option>
                                              <option >Seller 3</option>

                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-lg-6">

                                    <div class="mb-3">
                                        <label class="form-label" for="manufacturername">Merchant ID </label>
                                        <select  class="form-select">

                                          <option >Merchant 1</option>
                                          <option >Merchant  2</option>
                                          <option >Merchant  3</option>

                                      </select>
                                  </div>
                              </div>
                              <div class="col-lg-6">

                                <div class="mb-3">
                                    <label class="form-label" for="manufacturername">Hub ID </label>
                                    <select  class="form-select">

                                      <option >Hub 1</option>
                                      <option >Hub  2</option>
                                      <option >Hub  3</option>

                                  </select>
                              </div>
                          </div>


                          <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="productname">Service Changes</label>
                                <input id="productname" name="productname" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="mb-3">
                                <label class="form-label" for="manufacturername">Pay</label>
                                <input id="manufacturername" name="manufacturername" type="text" class="form-control">
                            </div>
                        </div>




                    </div>

                    <div class="row my-4">
                        <div class="col text-end">
                            <a href="#" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                            <a href="#" class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Done </a>
                        </div> <!-- end col -->
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
</div>
<!-- end row -->

<!-- end row-->

</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection
