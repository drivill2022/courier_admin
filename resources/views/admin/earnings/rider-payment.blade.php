@extends('admin.layouts.main')
@section('title', 'Payment Account Section')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="tab-content p-3 text-muted">
          
 <form method="POST" action="{{ route('admin.rider-earnings') }}" enctype="multipart/form-data">
        @csrf
<div class="row">
    <div class="col-lg-12">
        <div id="addproduct-accordion" class="custom-accordion">
            <div class="card">

                <div class="row mt-4 mb-4 px-2">
                    <div class="col-12">
                        <h5>Rider Payment</h5>
                        <div class="p-4 border-top">
                            <form>

                                <div class="row">
                                   
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
                                
                              <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="pay_amount"> Pay Amount</label>
                                    <input id="pay_amount" name="pay_amount" type="number" class="form-control">
                                     @error('pay_amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                     @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="status">Payment Mode</label>
                                    <select  class="form-select" name="payment_mode">
                                      <option value="0">Cash</option>
                                      <option value="1">Paystack (Card Payments)</option>

                                  </select>
                              </div>
                          </div>
                      </div>
                      <div id="amount_remaining"></div>
                      <div class="row my-4">
                        <div class="col text-end">
                            <a href="{{ route('admin.rider_transaction') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
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
</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection
@section('footer_scripts')
<script type="text/javascript">
        $(document).ready(function(){ 
                        showCurrentAmount($("#rider").val());
                        $("#rider").on('change', function postinput(){
                            var rider_id = $(this).val(); // this.value
                        showCurrentAmount(rider_id);
                               
                });

                function showCurrentAmount(rider_id)
                {
                   if(rider_id != '')
                            {
                               var url = "<?php echo url('/').'/admin/getRiderRemAmt/';?>"
                                $.ajax({ 
                                    url: url+rider_id,
                                    type: 'GET'
                                }).done(function(responseData) {
                                     var html = '<div class="col-lg-6 dv_rem_amt">\
                                                  <div class="mb-3">\
                                                      <label class="form-label" for="currn_amount">  Current Amount</label>\
                                                      <input id="currn_amount" name="currn_amount" type="number" value="'+responseData+'" class="form-control" readonly>\
                                                  </div>\
                                              </div>';
                                      console.log(html);
                                      $(".dv_rem_amt").remove();
                                      $(html).insertAfter(".col-lg-6:first");

                                    
                                }).fail(function() {
                                    console.log('Failed');
                                });   
                            }
                }

               $("#pay_amount").on('keyup', function(){
                  var currn_amount = $("#currn_amount").val();
                  var pay_amount = $("#pay_amount").val();
                  var rem_amount = (currn_amount - pay_amount);
                  if(rem_amount < 0)
                  {
                     $("#amount_remaining").html("<div class='error'>You Can't pay amount greater to current amount</div>");
                  }
                  else
                  {
                     $("#amount_remaining").html("Remaining Amount: "+rem_amount);

                  }
                 
               });
        });


  </script>
@endsection