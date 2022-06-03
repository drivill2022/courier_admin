@extends('admin.layouts.main')
@section('title', 'Payment Account Section')
@section('content')
<div class="page-content">
    <div class="container-fluid">
       <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#merchant-payment" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Merchant Payment</span>
                        </a>
                    </li>
                     <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#rider-payment"
                            role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Rider Payment</span>
                        </a>
                    </li>
       </ul>
        <div class="tab-content p-3 text-muted">
<div class="tab-pane active" id="merchant-payment" role="tabpanel">
          
 <form method="POST" action="{{ route('admin.earnings.store') }}" enctype="multipart/form-data">
        @csrf
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Payment Section</h4>

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
                                            <input type="radio" checked name="payment_mode" value="0" onclick="show1();" /> Cash 
                                        </div>
                                        <div class="">
                                            <input type="radio" name="payment_mode" value="1" onclick="show2();" /> Paystack (Card Payments)
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
                        <h5>Payment Pay Section</h5>
                        <div class="p-4 border-top">
                            <form>

                                <div class="row">
                                    <!-- <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_name"> Product ID</label>
                                            <input id="product_name" name="product_name" type="text" class="form-control">
                                        </div>
                                    </div> -->
                                    <!--  <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="shipment">Select Shipment No.</label>
                                            <select  class="form-select" name='shipment' id="shipment">
                                            <option value="">Select Shipment</option>
                                            @foreach($shipments as $m)
                                            <option value="{{$m->id}}" @if (old('shipment')==$m->id)
                                                selected @endif>{{$m->shipment_no}}</option>
                                                @endforeach
                                            </select>
                                            @error('shipment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                      </div>
                                  </div> -->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="merchant">Select Merchant</label>
                                            <select  class="form-select" name='merchant' id="merchant">
                                            <option value="">Select Merchant</option>
                                            @foreach($merchants as $m)
                                            <option value="{{$m->id}}" @if (old('merchant')==$m->id)
                                                selected @endif>{{$m->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('merchant')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                      </div>
                                  </div>
                                <!--   <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="seller">Select Seller</label>
                                       <select  class="form-select" name='seller' id="seller">
                                          <option value="">Select Seller</option>
                                          @foreach($sellers as $s)
                                          <option value="{{$s->id}}" @if (old('seller')==$s->id)
                                              selected @endif>{{$m->name}}</option>
                                              @endforeach
                                          </select>
                                          @error('seller')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                  </div>
                              </div> -->
                              
                              <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="pay_amount"> Pay Amount</label>
                                    <input id="pay_amount" name="pay_amount" type="text" class="form-control">
                                     @error('pay_amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                     @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="status">Change Status</label>
                                    <select  class="form-select" name="status">
                                      <option value="1">Done</option>
                                      <option value="0">Pending</option>

                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="row my-4">
                        <div class="col text-end">
                            <a href="{{ route('admin.earnings.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                           <button class="btn btn-success"><i class="uil uil-file-alt me-1"></i> Save </button>
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
</form>
</div>
<div class="tab-pane" id="rider-payment" role="tabpanel">
          
 <form method="POST" action="{{ route('admin.rider-earnings') }}" enctype="multipart/form-data">
        @csrf
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Payment Section</h4>

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
                                            <input type="radio" checked name="payment_mode" value="0" onclick="show1();" /> Cash 
                                        </div>
                                        <div class="">
                                            <input type="radio" name="payment_mode" value="1" onclick="show2();" /> Paystack (Card Payments)
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
                        <h5>Payment Pay Section</h5>
                        <div class="p-4 border-top">
                            <form>

                                <div class="row">
                                    <!-- <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_name"> Product ID</label>
                                            <input id="product_name" name="product_name" type="text" class="form-control">
                                        </div>
                                    </div> -->
                                    <!--  <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="shipment">Select Shipment No.</label>
                                            <select  class="form-select" name='shipment' id="shipment">
                                            <option value="">Select Shipment</option>
                                            @foreach($shipments as $m)
                                            <option value="{{$m->id}}" @if (old('shipment')==$m->id)
                                                selected @endif>{{$m->shipment_no}}</option>
                                                @endforeach
                                            </select>
                                            @error('shipment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                      </div>
                                  </div> -->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="merchant">Select Rider</label>
                                            <select  class="form-select" name='rider' id="rider">
                                            <option value="">Select Rider</option>
                                            @foreach($riders as $m)
                                            <option value="{{$m->id}}" @if (old('rider')==$m->id)
                                                selected @endif>{{$m->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('rider')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                      </div>
                                  </div>
                                <!--   <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="seller">Select Seller</label>
                                       <select  class="form-select" name='seller' id="seller">
                                          <option value="">Select Seller</option>
                                          @foreach($sellers as $s)
                                          <option value="{{$s->id}}" @if (old('seller')==$s->id)
                                              selected @endif>{{$m->name}}</option>
                                              @endforeach
                                          </select>
                                          @error('seller')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                  </div>
                              </div> -->

                              <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="pay_amount"> Pay Amount</label>
                                    <input id="pay_amount" name="pay_amount" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="status">Change Status</label>
                                    <select  class="form-select" name="status">
                                      <option value="1">Done</option>
                                      <option value="0">Pending</option>

                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="row my-4">
                        <div class="col text-end">
                            <a href="{{ route('admin.earnings.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                           <button class="btn btn-success"><i class="uil uil-file-alt me-1"></i> Save </button>
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
</form>
</div>
<!-- end row-->
</div>
</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection
@section('footer_scripts')
<script type="text/javascript">
        $(document).ready(function(){ 
                        $("#merchant").on('change', function postinput(){
                             riders = [];
                            var merchant_id = $(this).val(); // this.value
                            if(merchant_id != '')
                            {
                               var url = "<?php echo url('/').'/admin/getMerchantRemAmt/';?>"
                                $.ajax({ 
                                    url: url+merchant_id,
                                    type: 'GET'
                                }).done(function(responseData) {
                                     var html = '<div class="col-lg-6 dv_rem_amt">\
                                                  <div class="mb-3">\
                                                      <label class="form-label" for="rem_amount">  Remaining Amount</label>\
                                                      <input id="rem_amount" type="text" value="'+responseData+'" class="form-control" readonly>\
                                                  </div>\
                                              </div>';
                                      console.log(html);
                                      $(".dv_rem_amt").remove();
                                      $(html).insertAfter("#merchant-payment .col-lg-6:first");
                                    //$("#amount_remaining").(responseData);
                                }).fail(function() {
                                    console.log('Failed');
                                });   
                            }
                               
                });

               $("#rider").on('change', function postinput(){
                             riders = [];
                            var merchant_id = $(this).val(); // this.value
                            if(merchant_id != '')
                            {
                               var url = "<?php echo url('/').'/admin/getRiderRemAmt/';?>"
                                $.ajax({ 
                                    url: url+merchant_id,
                                    type: 'GET'
                                }).done(function(responseData) {
                                     var html = '<div class="col-lg-6 dv_rem_amt">\
                                                  <div class="mb-3">\
                                                      <label class="form-label" for="rem_amount">  Remaining Amount</label>\
                                                      <input id="rem_amount" type="text" value="'+responseData+'" class="form-control" readonly>\
                                                  </div>\
                                              </div>';
                                      console.log(html);
                                      $(".dv_rem_amt").remove();
                                      $(html).insertAfter("#rider-payment .col-lg-6:first");
                                    //$("#amount_remaining").(responseData);
                                }).fail(function() {
                                    console.log('Failed');
                                });   
                            }
                               
                });

        });


  </script>
@endsection