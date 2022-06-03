@extends('admin.layouts.main')
@section('title', 'Payment Account Section')
@section('content')
@php $merchant_id = Request::segment(3) @endphp
@php $current_url = route('admin.merchant_payment').'/'; 
$active = Request::url(); 
$filter = Request::get('filter');
@endphp
<div class="page-content">
    <div class="container-fluid">
        <div class="tab-content p-3 text-muted">
          
<!--  <form method="POST" action="{{ route('admin.earnings.store') }}" enctype="multipart/form-data"> -->
        @csrf
<div class="row">
    <div class="col-lg-12">
        <div id="addproduct-accordion" class="custom-accordion">
            <div class="card">

                <div class="row mt-4 mb-4 px-2">
                    <div class="col-12">
                      

                        <h5>Merchant Payment</h5>
                        <div class="p-4 border-top">
                            <form>
 
                                <div class="row">
                                   
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="merchant">Select Merchant</label>
                                            <select  class="form-select" name='merchant' id="merchant">
                                            <option value="">Select Merchant</option>
                                            @foreach($merchants as $m)
                                            <option value="{{$m->id}}" @if (old('merchant')==$m->id || $merchant_id == $m->id)
                                                selected @endif>{{$m->name}}({{$m->buss_name}})</option>
                                                @endforeach
                                            </select>
                                            @error('merchant')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                      </div>
                                  </div>
                          @if($filter == 'paid')
                          <div class="col-lg-6 dv_rem_amt">
                              <div class="mb-3">
                                  <label class="form-label" for="currn_amount">Paid Amount<!-- ((Total COD Amount) - (Total Shipment Charge) - (Total Paid Amt)) --></label>
                                  <input type="number" value="{{$paid_cod}}" class="form-control" readonly>
                              </div>
                          </div>
                           @else
                          <div class="col-lg-6 dv_rem_amt">
                              <div class="mb-3">
                                  <label class="form-label" for="currn_amount">Current Amount<!-- ((Total COD Amount) - (Total Shipment Charge) - (Total Paid Amt)) --></label>
                                  <input id="currn_amount" name="currn_amount" type="number" value="" class="form-control" readonly>
                              </div>
                          </div>
                          <div class="col-lg-12 pull-right pay_btn"><!-- <button class="btn btn-success collected pay_all col-2 pull-right">Pay All</button> --></div>
                        
                          @endif

                          <!-- <div class="col-lg-6">
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
                          </div> -->
                      </div>
                      <!-- <div id="amount_remaining"></div>
                      <div class="row my-4">
                        <span class="text-success">Paid Amount: {{$paid_cod}}</span>
                        <div class="col text-end">
                            <a href="{{ route('admin.merchant_transaction',['daily','']) }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                           <button onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" class="btn btn-success"><i class="uil uil-file-alt me-1"></i> Save </button>
                        </div> 
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</div>


</div>
</div>
</div>
<!-- end row -->
<!-- </form> -->

                   
                
                       <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                    <div class="card-body">
                                       
                                        <ul class="my-3 nav nav-pills nav-justified bg-light" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                              <a class="nav-link @if($filter != 'paid') active @endif" href="{{$active}}?filter=remaining"
                                              role="tab">
                                              <span class="d-none d-sm-block">Shipment List(Remaining Amount)</span>
                                          </a>
                                        </li>
                                          <li class="nav-item waves-effect waves-light">
                                              <a class="nav-link @if($filter == 'paid') active @endif" href="{{$active}}?filter=paid"
                                              role="tab">
                                              <span class="d-none d-sm-block">Shipment List(Paid Amount)</span>
                                          </a>
                                        </li>
                                         
                                    </ul>

                                  <div class="tab-content p-3 text-muted">
                                  
                                  @if($filter == 'paid')
                                  <div class="tab-pane active" id="weekly_tab" role="tabpanel">
                                    <div class="table-responsive mb-4">
                                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                            <thead>
                                                <tr class="bg-transparent">
                                                    
                                                   <!--  <th><input type="checkbox" name="shipment" value=""></th> -->
                                                    <th>Shipment ID</th>
                                                    <th>Customer Name </th>
                                                    <th>COD Amount</th>
                                                    <th>Shipment Charge</th>
                                                    <th>Payment Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($paid_shipments as $s)
                                                <tr>
                                                    <!--  <td><input type="checkbox" name="shipment" value="{{$s->id}}"></td> -->
                                                    <td>{{$s->shipment_no ?: 'NA'}}</td>
                                                    <td>{{$s->receiver_name}}</td>
                                                    <td>{{$s->cod_amount}}</td>
                                                    <td>{{$s->shipment_cost?: '0'}}</td>
                                                    <td>{{$s->payment_date}}</td>
                                                    
                                                  
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table -->
                                   </div>
                                  @else
                                 <div class="tab-pane active" id="monthly_tab" role="tabpanel">  
                                  <form id="pay_form">
                                  
                                    <div class="table-responsive mb-4">
                                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                            <thead>
                                                <tr class="bg-transparent">
                                                     <th class="nosort"><input type="checkbox" name="shipment" id="checkAll" value=""></th>
                                                    <th>Shipment ID</th>
                                                    <th>Customer Name </th>
                                                    <th>COD Amount</th>
                                                    <th>Shipment Charge</th>
                                                    <th>Current Amount</th>
                                                   <!--  <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @php $cod_amount = $shipment_cost = $total_current = 0; @endphp
                                                @foreach($remaining_shipments as $s)
                                                @php $current = $s->cod_amount - $s->shipment_cost; @endphp
                                                <tr style="background-color: @if($current < 0) #FF6251 @else #B2DD8B @endif">
                                                    <td><input type="checkbox" name="shipment[]" value="{{$s->id}}" class="checkbox_change" data-currentamount="{{$current}}"></td>
                                                    <td>{{$s->shipment_no ?: 'NA'}}</td>
                                                    <td>{{$s->receiver_name}}</td>
                                                    <td>{{$s->cod_amount}}</td>
                                                    <td>{{$s->shipment_cost?: '0'}}</td>
                                                    <td>{{$current}}</td>
                                                    
                                                   <!--  <td>
                                                      @if(!in_array($s->id,$shipment_ids))
                                                      <button class="btn btn-sm btn-success collected" data-shipmentid="{{$s->id}}">Paid</button>
                                                      @else
                                                      
                                                      @endif
                                                    </td> -->
                                                    
                                                </tr> 
                                                @php 
                                                  $cod_amount = $cod_amount + $s->cod_amount;
                                                  $shipment_cost = $shipment_cost + $s->shipment_cost; 
                                                  $total_current = $total_current + $current; 
                                                @endphp
                                                @endforeach
                                                <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total COD: {{$cod_amount}}</td>
                                                    <td>Total Charge: {{$shipment_cost}}</td>
                                                    <td>Total Current: {{$total_current}}</td>
                                                  
                                                </tr> 
                                              </tfoot>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table -->


                                    <div id="payAll" class="modal fade" role="dialog">
                                      <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <input type="hidden" name="merchant" value="{{@$merchant_id}}">
                                            <h4 class="modal-title">Marchant Payment</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                                          </div>
                                          <div class="modal-body">
                                           
                                            <div class="col-lg-12">
                                                  <div class="mb-3">
                                                      <label class="form-label" for="status">Transaction ID</label>
                                                      <input type="text" name="txn_id" value="" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                  <div class="mb-3">
                                                      <label class="form-label" for="status">Payment Mode</label>
                                                      <select  class="form-select" name="payment_mode" required>
                                                        <option value="0">Nagad</option>
                                                        <option value="1">Bank Deposit</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>

                                      </div>
                                    </div>
                                  </form>
                                 </div>
                                 @endif
                                </div>


                            </div>
                          </div> 
                        </div>
                      
                  </div>
</div>
</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection
@section('footer_scripts')
<script type="text/javascript">

  $("#pay_form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = "<?php echo url('/').'/admin/payMerchantPayment';?>"
    var _token = $('input[name="_token"]').attr('value'); // this.value

    $.ajax({
        url: url,
        type: 'POST',
        method: 'POST',
         headers: {
                'X-CSRF-Token': _token 
           },
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
          if(data.status == true)
          {
              alert(data.msg);
          }
          location.reload();   // show response from the php script.
        }
    });
    
});

      /*$(".pay_all").click(function(){
        if($('[type="checkbox"]').is(":checked")){
           // $('.checkboxStatus').html("Congratulations! "+$('[type="checkbox"]:checked').length+" checkbox checked");
          $('#payAll').modal('show'); 
        }else{
            alert("Sorry! please select any shipment.");
         }
         return false;

       });*/

       $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

       $(".modal-footer button, .modal-header button").click(function(){
            $('#payAll').modal('hide'); 
        });

        $(document).on( 'click', 'tr td button.collected', function postinput(){
            if (confirm('Are you sure , are you paid amount?')) {
                   var shipment_id = $(this).attr('data-shipmentid'); // this.value
                   var merchant_id = "{{@$merchant_id}}"; // this.value
                   //alert(merchant_id);
                   var _token = $('input[name="_token"]').attr('value'); // this.value
                   var url = "<?php echo url('/').'/admin/payMerchantPayment';?>"
                                $.ajax({ 
                                    url: url,
                                    type: 'POST',
                                    method: 'POST',
                                     headers: {
                                            'X-CSRF-Token': _token 
                                       },
                                    data: jQuery.param({ shipment_id : shipment_id,merchant : merchant_id, _token : _token}) ,
                                }).done(function(responseData) {
                                  location.reload();  
                                }).fail(function() {
                                    console.log('Failed');
                                }); 
                     } else {
                    //alert('Why did you press cancel? You should have confirmed');
                }  
                               
          });

            $(document).ready(function(){ 
                        showCurrentAmount($("#merchant").val());
                        $("#merchant").on('change', function postinput(){
                        /*var merchant_id = $(this).val(); // this.value
                        showCurrentAmount(merchant_id);*/
                        var merchant_id = $(this).val(); // get selected value
                        var active = "{{$current_url}}";
                        if (merchant_id) { // require a URL
                            window.location = active+merchant_id; // redirect
                        }
                        else
                        {
                          window.location = active;
                        }
                        return false;
                               
                });

                function showCurrentAmount(merchant_id)
                {
                   if(merchant_id != '')
                            {
                               var url = "<?php echo url('/').'/admin/getMerchantRemAmt/';?>"
                                $.ajax({ 
                                    url: url+merchant_id,
                                    type: 'GET'
                                }).done(function(responseData) {
                                     
                                      $("#currn_amount").val(responseData);
                                      if(responseData < 0)
                                      {
                                      	$(".pay_btn").html('<button class="btn btn-success collected pay_all col-2 pull-right">Collected</button>');
                                      }
                                      else
                                      {
                                      	$(".pay_btn").html('<button class="btn btn-success collected pay_all col-2 pull-right">Pay All</button>');
                                      }
                                      //payclick();
                                      $(".pay_all").click(function(){
                								        if($('[type="checkbox"]').is(":checked")){
                								           // $('.checkboxStatus').html("Congratulations! "+$('[type="checkbox"]:checked').length+" checkbox checked");
                								          $('#payAll').modal('show'); 
                								        }else{
                								            alert("Sorry! please select any shipment.");
                								         }
                								         return false;

                								       });
                                    
                                }).fail(function() {
                                    console.log('Failed');
                                });   
                            }
                }

               $("#pay_amount").on('keyup', function(){
                  var currn_amount = parseFloat($("#currn_amount").val());
                  var pay_amount = parseFloat($("#pay_amount").val());
                  console.log(jQuery.type(currn_amount)+"/"+jQuery.type(pay_amount));
                  if(pay_amount < 0)
                  {
                     $("#amount_remaining").html("<div class='error'>The pay amount must be greater than 0.</div>");
                  }
                  else
                  {
                     if(!isNaN(pay_amount) && !isNaN(currn_amount)){
                       var rem_amount = (currn_amount - pay_amount);
                      if(rem_amount < 0)
                      {
                         $("#amount_remaining").html("<div class='error'>Pay Amount shuold be less then or equal to current amount</div>");
                      }
                      else
                      {
                         $("#amount_remaining").html("Remaining Amount: "+rem_amount);

                      }
                    }
                  }
                 
                 
               });


        $(document).on( 'click', 'tr td button.collected', function postinput(){
            if (confirm('Are you sure , are you paid amount?')) {
                   var shipment_id = $(this).attr('data-shipmentid'); // this.value
                   var merchant_id = "{{@$merchant_id}}"; // this.value
                   //alert(merchant_id);
                   var _token = $('input[name="_token"]').attr('value'); // this.value
                   var url = "<?php echo url('/').'/admin/payMerchantPayment';?>"
                                $.ajax({ 
                                    url: url,
                                    type: 'POST',
                                    method: 'POST',
                                     headers: {
                                            'X-CSRF-Token': _token 
                                       },
                                    data: jQuery.param({ shipment_id : shipment_id,merchant : merchant_id, _token : _token}) ,
                                }).done(function(responseData) {
                                  location.reload();  
                                }).fail(function() {
                                    console.log('Failed');
                                }); 
                     } else {
                    //alert('Why did you press cancel? You should have confirmed');
                }  
                               
          });
        });

      $(document).on('click', 'tr td input.checkbox_change, tr th input#checkAll', function postinput(){
         var selected = [];
        $('tr td input.checkbox_change:checked').each(function() {
            selected.push($(this).attr('data-currentamount'));
        });

        var sum = selected.reduce(function(a, b){
            return parseInt(a) + parseInt(b);
        }, 0);
          
          $("#currn_amount").val(sum);
          if(sum < 0)
          {
            $(".pay_btn .pay_all").html('Collected');
          }
          else
          {
            $(".pay_btn .pay_all").html('Pay All');
          }
          /*if(sum <= 0)
          {
            $("#currn_amount").val(currn_amount);
          }
          else
          {
            $("#currn_amount").val(sum);
          }*/
      });



/*        $(document).ready(function(){ 
                        showCurrentAmount($("#merchant").val());
                        $("#merchant").on('change', function postinput(){
                            var merchant_id = $(this).val(); // this.value
                        showCurrentAmount(merchant_id);
                               
                });

                function showCurrentAmount(merchant_id)
                {
                   if(merchant_id != '')
                            {
                               var url = "<?php echo url('/').'/admin/getMerchantRemAmt/';?>"
                                $.ajax({ 
                                    url: url+merchant_id,
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
                  var currn_amount = parseFloat($("#currn_amount").val());
                  var pay_amount = parseFloat($("#pay_amount").val());
                  console.log(jQuery.type(currn_amount)+"/"+jQuery.type(pay_amount));
                  if(pay_amount < 0)
                  {
                     $("#amount_remaining").html("<div class='error'>The pay amount must be greater than 0.</div>");
                  }
                  else
                  {
                     if(!isNaN(pay_amount) && !isNaN(currn_amount)){
                       var rem_amount = (currn_amount - pay_amount);
                      if(rem_amount < 0)
                      {
                         $("#amount_remaining").html("<div class='error'>Pay Amount shuold be less then or equal to current amount</div>");
                      }
                      else
                      {
                         $("#amount_remaining").html("Remaining Amount: "+rem_amount);

                      }
                    }
                  }
                 
                 
               });
        });*/


  </script>
@endsection