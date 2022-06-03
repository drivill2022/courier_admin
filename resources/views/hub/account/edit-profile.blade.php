@extends('hub.layouts.main')
@section('title', 'Dashboard')
@section('content')
<style type="text/css">
    .invalid-feedback{display: inline-block;}
</style>
@php($hub=Auth::guard('hub')->user())
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
               {{--  @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif --}}
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div id="addproduct-billinginfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <form class="form-horizontal" action="{{route('hub.profile.update')}}" method="POST" enctype="multipart/form-data" role="form">
                                {{csrf_field()}}                                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input id="name" name="name" type="text" class="form-control" value="{{trim($hub->name)}}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="phone">Office Phone</label>
                                            <input id="phone" name="phone" type="text" class="form-control" value="{{trim($hub->phone)}}" maxlength="10">
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email ID</label>
                                            <input id="email" name="email" type="text" class="form-control" value="{{trim($hub->email)}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Address</label>
                                            <input id="address" name="address" type="text" class="form-control" value="{{trim($hub->address)}}">
                                            <input type="hidden" value="{{$hub->latitude?:old('latitude')}}" name="latitude" id="latitude">
                                            <input type="hidden" value="{{$hub->longitude?:old('longitude')}}" name="longitude" id="longitude">
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                   <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturername">Division:</label>
                                            <x-division-dropdown :selected="$hub->division" id="division" name="division" />
                                                @error('division')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="manufacturername">District :</label>
                                                <x-district-dropdown :selected="$hub->district" id="district" name="district" :division="$hub->division" />
                                                  @error('district')
                                                  <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="manufacturername">Thana:</label>
                                                <x-thana-dropdown :selected="$hub->thana" id="thana" name="thana" :district="$hub->district" />
                                                 @error('thana')
                                                 <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="supervisor_name">Supervisor Name:</label>
                                            <input id="supervisor_name" name="supervisor_name" type="text" class="form-control" value="{{$hub->supervisor_name}}">
                                            @error('supervisor_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="sup_phone">Phone Number:</label>
                                            <input id="sup_phone" name="sup_phone" type="text" class="form-control" value="{{$hub->sup_phone}}">
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
                                            <input id="sup_nid_no" name="sup_nid_no" type="text" class="form-control" value="{{$hub->sup_nid_no}}">
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
                                             @if($hub->sup_nid_pic)
                                            <img src="{{img($hub->sup_nid_pic)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                            @endif
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
                                            <input id="sup_tin_no" name="sup_tin_no" type="text" class="form-control" value="{{$hub->sup_tin_no}}">
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
                                            @if($hub->sup_tin_pic)
                                            <img src="{{img($hub->sup_tin_pic)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                            @endif
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
                                            @if($hub->tl_picture)
                                            <img src="{{img($hub->tl_picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                            @endif
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
                                            @if($hub->sup_picture)
                                            <img src="{{img($hub->sup_picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                            @endif
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
                                            @if($hub->picture)
                                            <img src="{{img($hub->picture)}}" class="img" style="height: 90px; margin-bottom: 15px; border-radius:2em;">
                                            @endif
                                            <input name="picture" type="file" class="form-control"> 
                                            @error('picture')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror 
                                        </div>
                                    </div> 
                                </div>
                                {{-- <div class="col-md-12">
                                    <label class="form-label" for="images upload">Profile Images</label>
                                    @if(isset($hub->picture))
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em; margin-left: 15px;" src="{{img($hub->picture)}}">
                                    @endif
                                    <input name="picture" type="file" multiple="multiple" class="form-control" accept="image/*">
                                    @error('picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div> --}}

                                <div class="col-md-12 col text-end mt-3">
                                    <a href="{{route('hub.profile')}}" class="btn btn-danger"> <i class="uil uil-times me-1"></i> Cancel </a>
                                    <button class="btn btn-success"> <i class="uil uil-file-alt me-1"></i> Update </button>
                                </div> <!-- end row-->
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end row -->                        
</div> <!-- container-fluid -->
</div>

@include('common.address-script')
@endsection
@section('footer_scripts')
 <script type="text/javascript">
    $('.close').click(function(){
     $(".notify").remove();
    });
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