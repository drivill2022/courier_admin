@extends('admin.layouts.main')
@section('title', 'Hub Deposit')
@section('content')
@php $active = Request::segment(3); 
$current = route('admin.hub_deposit').'/';
 @endphp
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Hub Deposit</h4>
                                
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                        <div class="row">
                            <div class="col-lg-12">
                                

                                <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All Hub Deposit</h4>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">

                            <div class="row">
                             <!-- end col-->

                                <div class="col-md-6 col-xl-4">
                                    <div class="mb-3">
                                                    <label class="form-label" for="manufacturername">Hub :</label>
                                                    <x-hubs-dropdown :selected="$hub_id" />
                                        
                                            </div>
                                    <div class="card">
                                        <div class="card-body">
                                             
                                            <div>
                                                <h4 class="mb-1 mt-1">{{config('constants.currency')}}<span data-plugin="counterup">{{@$total_earnings}}</span></h4>
                                                <p class="text-muted mb-0">Total COD Amount</p>
                                            </div>
                                           <!--  <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
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
                                                <th>Shipment No.</th>
                                                <th>Hub Name</th>
                                                <th>Available COD Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($hubDepositList))
                                            @foreach($hubDepositList as $value)
                                            <tr style="background-color: @if(in_array($value['shipment_id'],$amount_deposite)) #FF6251 @else #B2DD8B @endif">
                                                <td>{{$value['shipment_no']}}</td>
                                                <td>{{getHubDetail($hub_id)}}</td>
                                                <td>{{config('constants.currency')}}{{$value['total_earnings']}}</td>
                                                <td>
                                                    @if(!in_array($value['shipment_id'],$amount_deposite))
                                                   <button class="btn btn-sm btn-success collected" data-hubid="{{$hub_id}}" data-amount="{{$value['total_earnings']}}" data-shipmentid="{{$value['shipment_id']}}">Collected</button>
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
           $(document).on( 'click', 'tr td button.collected', function postinput(){
            if (confirm('Are you sure , are you collected amount?')) {
                   var amount = $(this).attr('data-amount'); // this.value
                   var hub_id = $(this).attr('data-hubid'); // this.value
                   var shipment_id = $(this).attr('data-shipmentid'); // this.value
                   var _token = $('input[name="_token"]').attr('value'); // this.value
                   var url = "<?php echo url('/').'/admin/changeHubDepositStatus';?>"
                                $.ajax({ 
                                    url: url,
                                    type: 'POST',
                                    method: 'POST',
                                     headers: {
                                            'X-CSRF-Token': _token 
                                       },
                                    data: jQuery.param({ amount : amount, hub_id : hub_id, shipment_id : shipment_id, _token : _token}) ,
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
      $('#hub_id').on('change', function () {
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
