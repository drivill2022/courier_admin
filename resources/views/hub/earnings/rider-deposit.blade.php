@extends('hub.layouts.main')
@section('title', 'Rider Deposit')
@section('content')
@php $active = Request::segment(3); 
$current = route('hub.rider_deposit').'/';
@endphp
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Rider Deposit</h4>
                                    
                                    

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                        <div class="row">
                            <div class="col-lg-12">
                                

                                <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All Rider Deposit</h4>
                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                        
                                            <div class="row">
                                             <!-- end col-->

                                                <div class="col-md-6 col-xl-3">

                                                <div class="mb-3">
                                                    <label class="form-label" for="rider">Rider :</label>
                                                    <select  class="form-select" name='rider' id="rider">
                                                    <option value="">Select Rider</option>
                                                    @foreach($riders as $m)
                                                    <option value="{{$m->id}}" @if ($rider_id==$m->id)
                                                        selected @endif>{{$m->name}}</option>
                                                        @endforeach
                                                    </select>
                                              </div></div>
                                              <!--   <div class="card">
                                                    <div class="card-body">
                                                        <div class="float-end mt-2">
                                                            <div id="total-revenue-chart"></div>
                                                        </div>
                                                        <div>
                                                <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{@$total_earnings}}</span></h4>
                                                <p class="text-muted mb-0">Total COD Amount</p>
                                            </div>  -->
                                                <div class="row">
                                                     <div class="col-md-6 col-xl-3">
                                                       <div class="card">
                                                         <div class="card-body">
                                                         <div class="float-end mt-2">
                                                            <div id="total-revenue-chart"></div>
                                                        </div>
                                                        <div>
                                                          <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{@$total_earnings}}</span></h4>
                                                          <p class="text-muted mb-0">Total COD Amount</p>
                                                      </div>
                                                     </div>
                                                   </div>
                                                    </div>
                                                  
                                                   <div class="col-md-6 col-xl-3">
                                                     <div class="card">
                                                  <div class="card-body">
                                                        <div class="float-end mt-2">
                                                            <div id="total-revenue-chart"></div>
                                                        </div>
                                                        <div>
                                                          <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{@$hubdeposite}}</span></h4>
                                                          <p class="text-muted mb-0">Total COD Collected</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                    </div> 
                                                  
                                                   <div class="col-md-6 col-xl-3">
                                                      <div class="card">
                                                       <div class="card-body">
                                                        <div class="float-end mt-2">
                                                            <div id="total-revenue-chart"></div>
                                                        </div>
                                                        <div>
                                                          <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{@$total_earnings - @$hubdeposite}}</span></h4>
                                                          <p class="text-muted mb-0">Total Peding COD</p>
                                                      </div>
                                                     </div>
                                                   </div>
                                                    </div>
                                                  </div>
                                                       <!--  <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div> <!-- end col-->

                                             
                                            </div> 


                                                 <div class="row">
                                <div class="col-lg-12">
                                    
                                    <div class="table-responsive mb-4">
                                        <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <tr class="bg-transparent">
                                                <th>Shipment No.</th>
                                                <!-- <th>Rider Name</th> -->
                                                <th>Available COD Amount</th>
                                                   <th>Delivery Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                              @if(!empty($riderDepositList))
                                            @foreach($riderDepositList as $value)
                                           <!--  <tr style="background-color: @if(in_array($value['total_earnings'],$amount_deposite)) #FF6251 @else #B2DD8B @endif"> -->

                                             <tr style="background-color: @if(in_array($value['shipment_id'],$amount_deposite)) #FF6251 @else #B2DD8B @endif">

                                                <td>{{$value['shipment_no']}}</td>
                                               <!--  <td>{{getHubDetail($rider_id)}}</td> -->
                                                <td>{{config('constants.currency')}}{{$value['total_earnings']}}</td>
                                                <td>{{MydateTime(GetDeliveryDate($value['shipment_id'])->created_at)}}</td>
                                                <td>
                                                    @if(!in_array($value['shipment_id'],$amount_deposite))
                                                   <button class="btn btn-sm btn-success collected" data-riderid="{{$rider_id}}" data-amount="{{$value['total_earnings']}}" data-shipmentid="{{$value['shipment_id']}}">Collected</button>
                                                   @else
                                                   
                                                   @endif
                                                </td>
                                            </tr>
                                           @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    </div>
                                    <!-- end table -->
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
@section('footer_scripts')
<script type="text/javascript">
        $(document).ready(function(){ 
           $(".collected").on('click', function postinput(){
            if (confirm('Are you sure , are you collected amount?')) {
                   var amount = $(this).attr('data-amount'); // this.value
                   var rider_id = $(this).attr('data-riderid'); // this.value
                   var shipment_id = $(this).attr('data-shipmentid'); // this.value
                   var _token = $('input[name="_token"]').attr('value'); // this.value
                   var url = "<?php echo url('/').'/hub/changeRiderDepositStatus';?>"
                                $.ajax({ 
                                    url: url,
                                    type: 'POST',
                                    method: 'POST',
                                     headers: {
                                            'X-CSRF-Token': _token 
                                       },
                                    data: jQuery.param({ amount : amount, rider_id : rider_id, shipment_id : shipment_id, _token : _token}) ,
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


        $(function(){
      // bind change event to select
      $('#rider').on('change', function () {
          var url = $(this).val(); // get selected value
          var active = "{{$current}}";
          if (url) { // require a URL
              window.location = active+url; // redirect
          }
          else
          {
            window.location = active;
          }
          return false;
      });
    });
</script>
@endsection
