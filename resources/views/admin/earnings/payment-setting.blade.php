@extends('admin.layouts.main')
@section('title', 'Payment Settings')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Payment Setting</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div id="addproduct-accordion" class="custom-accordion">
                    <div class="card">

                        <div class="row mt-4 mb-4 px-2">
                            <div class="col-12">
                                <h5>Payment Modes</h5>
                                <div class="px-2 mt-3">
                                    <div class="additional_bike_delivery_form">
                                        <div class="cycle_motorcycle_radio_tab">
                                         <div class="">
                                            <input type="radio" checked name="tab" value="igotnone" onclick="show1();" /> Cash 
                                        </div>
                                        <div class="">
                                            <input type="radio" name="tab" value="igottwo" onclick="show2();" /> Paystack (Card Payments)
                                        </div>
                                    </div>
                                    <div id="div1" class="hide">
                                       <div class="row mt-3">
                                        <div class="col-lg-12">

                                         <div class="mb-3">
                                             <label class="form-label" for="images upload">Paystack Secret key: </label>
                                             <input id="manufacturername" name="manufacturername" type="text" class="form-control" placeholder="pk_test_92900e5274f6b84b3602036fc71b4cb63996965c">  
                                         </div>
                                     </div>
                                     <div class="col-lg-12">

                                         <div class="mb-3">
                                             <label class="form-label" for="manufacturername">Paystack Publishable key:</label>
                                             <input id="manufacturername" name="manufacturername" type="text" class="form-control" placeholder="pk_test_92900e5274f6b84b3602036fc71b4cb63996965c">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>


     </div>
 </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div id="addproduct-accordion" class="custom-accordion">
            <div class="card">

                <div class="row mt-4 mb-4 px-2">
                    <div class="col-12">
                        <h5>Payment Settings</h5>
                        <div class="p-4 border-top">
                            <form>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="productname"> Daily Target:</label>
                                            <input id="productname" name="productname" type="text" class="form-control" placeholder="10">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="productname">Vat percentage(%):</label>
                                            <input id="productname" name="productname" type="text" class="form-control" placeholder="7.5">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="productname"> Commission Percentage(%):</label>
                                            <input id="productname" name="productname" type="text" class="form-control" placeholder="5">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="productname">Provider Commission Percentage(%):</label>
                                            <input id="productname" name="productname" type="text" class="form-control" placeholder="95">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="productname"> Delivery ID:</label>
                                            <input id="productname" name="productname" type="text" class="form-control" placeholder="#ABC50321">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturername">Currency ( ₦ ) :</label>
                                            <select  class="form-select">
                                              <option >Nigerian NAIRA (NGN)</option>
                                              <option >US Dollar (USD)</option>
                                              <option >Indian Rupee (INR)</option>
                                          </select>
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
</div>
<!-- end row -->

<!-- end row-->

</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection
