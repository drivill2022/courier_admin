@extends('admin.layouts.main')
@section('title', 'Add Merchant Bank Account')
@section('content')<!-- edit page -->

<div class="page-content">
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Add Merchant Bank Account</h4>
          <a href="{{ route('admin.merchant-account.index') }}">
            <button type="button" class="btn btn-success waves-effect waves-light mb-3">< Back</button></a>
          </div>
        </div>
      </div>
      <!-- end page title -->

      <div class="row">
        <div class="col-lg-12">
          <div id="addproduct-accordion" class="custom-accordion">
            <div class="card">
              <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                <div class="p-4 border-top">
                  <form method="POST" action="{{ route('admin.merchant-account.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                     <div class="col-md-6">
                      <div class="mb-3">
                              <label class="form-label" for="manufacturername">Merchant :</label>
                                  <select  class="form-select" name='merchant' id="merchant">
                                  <option value="">Select Merchant</option>
                                  @foreach($merchants as $m)
                                  <option value="{{$m->id}}">{{$m->name}}</option>
                                      @endforeach
                                  </select>
                                  @error('merchant')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                      </div>
                    </div>
                       <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="acc_holder_name">Account Holder Name</label>
                                <input name="acc_holder_name" id="acc_holder_name" type="text" class="form-control"> 
                                @error('acc_holder_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="bank_name">Bank Name</label>
                                <input name="bank_name" id="bank_name" type="text" class="form-control"> 
                                @error('bank_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="branch_name">Branch Name</label>
                                <input name="branch_name" id="branch_name" type="text" class="form-control"> 
                                @error('branch_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="account_number">Account Number</label>
                                <input name="account_number" id="account_number" type="text" class="form-control"> 
                                @error('account_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>
                       <!--   <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="routing_name">Routing Name</label>
                                <input name="routing_name" id="routing_name" type="text" class="form-control"> 
                                @error('routing_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div> -->
                     
                      <div class="row mb-4">
                        <div class="col text-end">
                          <a href="{{ route('admin.merchant-account.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                          <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Save</button>
                        </div> <!-- end col -->
                      </div> <!-- end row-->
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
    </div>
    <!-- End Page-content -->

    @endsection
@section('footer_scripts')
 <script type="text/javascript">
    $(document).ready(function(){
        $('.division_change').change(function () {
            var id = this.value;
            let prefix=$(this).attr('id').substr(0, 2)+'district';
           $("#"+prefix).html('');
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
        })
    })
 </script>
@endsection