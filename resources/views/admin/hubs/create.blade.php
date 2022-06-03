@extends('admin.layouts.main')
@section('title', 'Add Hub')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Add New Hub</h4>
                    <a href="{{ route('admin.hubs.index') }}">
                      <button type="button" class="btn btn-primary waves-effect waves-light mb-3">< Back</button></a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                           <form method="POST" action="{{ route('admin.hubs.store') }}" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Hub Name:</label>
                                            <input id="name" name="name" type="text" class="form-control" value="{{old('name')}}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="phone">Office Phone Number:</label>
                                            <input id="phone" name="phone" type="text" class="form-control" value="{{old('phone')}}" maxlength="12">
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="email">Email</label>
                                                <input id="email" name="email" type="email" class="form-control" value="{{old('email')}}">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="password">Password</label>
                                                <input id="password" name="password" type="password" class="form-control" value="{{old('password')}}">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" value="{{old('password_confirmation')}}">
                                                @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Hub Address:</label>
                                            <textarea class="form-control" id="address" name="address" rows="2" onFocus="geolocate()">{{old('address')}}</textarea>
                                           <input type="hidden" value="{{old('latitude')}}" name="latitude" id="latitude">
                                                <input type="hidden" value="{{old('longitude')}}" name="longitude" id="longitude">
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                     <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="home_address">Home Address:</label>
                                            <textarea class="form-control" id="home_address" name="home_address" rows="2" onFocus="geolocate()">{{old('home_address')}}</textarea>
                                            @error('home_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                   {{-- <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="division">Division:</label>
                                        <x-division-dropdown :selected="old('division')" id="division" name="division" />
                                      @error('division')
                                      <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                  </div>
                              </div>
                                    <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="district">District:</label>
                                               <x-district-dropdown :selected="old('district')" id="district" name="district" :division="old('division')" />
                                               @error('district')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                          </div>
                                      </div>
                                      <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="thana">Thana:</label>
                                           <x-thana-dropdown :selected="old('thana')" id="thana" name="thana" :district="old('district')" />
                                          @error('thana')
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                      </div>
                                  </div>--}}
                                  

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="supervisor_name">Supervisor Name:</label>
                                            <input id="supervisor_name" name="supervisor_name" type="text" class="form-control" value="{{old('supervisor_name')}}">
                                            @error('supervisor_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="sup_phone">Phone number:</label>
                                            <input id="sup_phone" name="sup_phone" type="text" class="form-control" value="{{old('sup_phone')}}">
                                            @error('sup_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="sup_nid_no">Supervisor NID Number:</label>
                                            <input id="sup_nid_no" name="sup_nid_no" type="text" class="form-control" value="{{old('sup_nid_no')}}">
                                            @error('sup_nid_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="images upload">Supervisor NID Photo:</label>
                                            <input name="sup_nid_pic" type="file" class="form-control" accept="images/*">
                                             @error('sup_nid_pic')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror  
                                        </div>
                                    </div>

                                    <div class="col-lg-6"> 
                                        <div class="mb-3">
                                            <label class="form-label" for="sup_tin_no">Supervisor TIN number:</label>
                                            <input id="sup_tin_no" name="sup_tin_no" type="text" class="form-control" value="{{old('sup_tin_no')}}">
                                             @error('sup_tin_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="images upload">Supervisor TIN Photo:</label>
                                            <input name="sup_tin_pic" type="file" class="form-control" accept="images/*">  
                                            @error('sup_tin_pic')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="images upload">Trade licence photo:</label>
                                            <input name="tl_picture" type="file" class="form-control" accept="images/*">  
                                             @error('tl_picture')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="images upload">Supervisor photo:</label>
                                            <input name="sup_picture" type="file" class="form-control"> 
                                            @error('sup_picture')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="images upload">Hub photo:</label>
                                            <input name="picture" type="file" class="form-control"> 
                                            @error('picture')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror 
                                        </div>
                                    </div> 
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="statusm">Status:</label>
                                            <select  class="form-select" name="status" id="statusm">
                                              <option value="Active" @if (old('status')=='Active')
                                              selected @endif>Active</option>
                                              <option value="Blocked" @if (old('status')=='Blocked')
                                              selected @endif>Blocked</option>
                                          </select>
                                          @error('status')
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col text-end">
                                        <a href="{{ route('admin.hubs.index') }}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                                        <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Save </button>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@include('common.address-script')
@endsection

@section('footer_scripts')
 <script type="text/javascript">
    $(document).ready(function(){
        $('#division').change(function () {
            var id = this.value;
            
           $.ajax({
            type: "GET",
            url: "{{ url('get-district') }}/"+id,
            success: function(result) {
                $("#district").html(result);
            }
           });
        })
    
        $('#district').change(function () {
            var id = this.value;
           $.ajax({
            type: "GET",
            url: "{{ url('get-thana') }}/"+id,
            success: function(result) {
                $("#thana").html(result);
            }
           });
        })
    })
 </script>
@endsection