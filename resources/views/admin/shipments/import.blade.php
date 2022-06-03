@extends('admin.layouts.main')
@section('title', 'Import Shipment')
@section('header_scripts')
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
@endsection
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Import Shipment</h4>
                    <a href="{{ route('admin.shipments.index') }}">
                        <button type="button" class="btn btn-success waves-effect waves-light mb-3">< Back</button></a>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div id="addproduct-accordion" class="custom-accordion">
                        <div class="card">
                            <div class="p-4 border-top">
                                <form method="POST" action="{{ route('admin.shipment.import') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-6">

                                            <div class="mb-3">
                                                <label class="form-label" for="manufacturername">Merchant :</label>
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

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="product_type">Product Type:</label>
                                                    <x-shipment-product-type-dropdown :selected="old('product_type')" id="product_type" name="product_type"  />
                                                    @error('product_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                           <!--  <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="shipment_type">Shipment Type:</label>
                                                    <x-delivery-type-dropdown :selected="old('shipment_type')" id="shipment_type" name="shipment_type"  />
                                                    @error('shipment_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div> -->
                                           <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="excel_file">Excel File:</label>
                                                    <input type="file" name="excel_file" class="form-control">
                                                    @error('excel_file')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <a href="{{asset('public/backend/shipment-import.xlsx')}}" download>Download Sample File</a><br><br>
                                                
                                                <h6>Excel file instrunctions</h6>
                                                <ul>
                                                     <li>Required Fields(receiver_name, contact_no, pickup_date, d_address, product_weight, cod_amount)</li>
                                                     <li>pickup_date should be format dd-mm-yyyy like "13-04-2022".</li>
                                                     <li>product_weight should be like that 500 GM/ 500 gm.</li> 
                                                     <li>d_division, d_district, d_thana should be valid which are in our system.</li>
                                                </ul>
                                            </div>  
                                         

                                        </div>
                                        <div class="row my-4">
                                            <div class="col text-end">
                                                <a href="{{ route('admin.shipments.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                                                <button onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" class="btn btn-success" type="submit"> <i class="uil uil-file-alt me-1"></i>Import </button>
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
        @include('common.shipment-address-script')
        @endsection

@section('footer_scripts')

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <script type="text/javascript">
    $(document).ready(function(){

        $("#pickup_date").datepicker({
             minDate: 0
        }); 

        $('.division_change').change(function () {
            var id = this.value;
            let prefix=$(this).attr('id').substr(0, 2)+'district';
            let t_prefix=$(this).attr('id').substr(0, 2)+'thana';
           $("#"+prefix).html('');
           $("#"+t_prefix).html('');
           $.ajax({
            type: "GET",
            url: "{{ url('get-district') }}/"+id,
            success: function(result) {
                $("#"+prefix).html(result);
            }
           });
        })
    
        $('.district_change').change(function () {
            var id = this.value;
            let prefix=$(this).attr('id').substr(0, 2)+'thana';
           $("#"+prefix).html('');
           $.ajax({
            type: "GET",
            url: "{{ url('get-thana') }}/"+id,
            success: function(result) {
                $("#"+prefix).html(result);
            }
           });
        });
        });


    $(function(){
        $("select[name='merchant']").change(function(){
              var merchant_id = $(this).val();
              $('#s_district').html("");
              $('#s_thana').html("");
              $("#s_address").val("");
              $.ajax({
                  url: "{{ url('admin/merchant-detail') }}"+"/"+merchant_id,
                  method: 'GET',
                  success: function(data) {
                    //$("#contact_no").val(data.mobile);
                    $("#s_latitude").val(data.latitude);
                    $("#s_longitude").val(data.longitude);
                    $("#s_address").val(data.address);
                    /*$('#s_division option:selected').removeAttr("selected");
                    $('#s_district option:selected').removeAttr("selected");
                    $('#s_thana option:selected').removeAttr("selected");*/
                    //alert(data.division);
                    $('#s_division option:selected').prop('selected', false);
                    $('#s_district option:selected').prop('selected', false);
                    $('#s_thana option:selected').prop('selected', false);
                    if(data.division != null)
                    {
                       //$('#s_division option[value="'+data.division+'"]').attr("selected","selected"); 
                       $('#s_division option[value="'+data.division+'"]').prop('selected', true); 
                    }
                    
                    
                       $.ajax({
                            type: "GET",
                            url: "{{ url('get-district') }}/"+data.division,
                            success: function(result) {
                               $("#s_district").html(result);
                               //$('#s_district option[value="'+data.district+'"]').attr("selected","selected");
                               $('#s_district option[value="'+data.district+'"]').prop('selected', true);
                            }
                        });
                     
                     
                     $.ajax({
                        type: "GET",
                        url: "{{ url('get-thana') }}/"+data.district,
                        success: function(result) {
                            $("#s_thana").html(result);
                            //$('#s_thana option[value="'+data.thana+'"]').attr("selected","selected");
                            $('#s_thana option[value="'+data.thana+'"]').prop('selected', true);
                        }
                       });
                    
                  }
              });
          });

    })
 </script>
@endsection