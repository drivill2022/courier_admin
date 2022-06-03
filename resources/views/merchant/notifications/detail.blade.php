@extends('merchant.layouts.main')
@section('title', 'Notification Details')
@section('content')

<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Notification Details</h4>
<div class="pull-right"><a class="btn btn-primary" href="{{route('merchant.notifications')}}">Back</a></div>
</div>
</div>
</div>
<!-- end page title -->
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<div class="mt-2">
<div class="product-desc">
<div class="tab-content border border-top-0 p-4">
<div class="tab-pane fade show active" id="specifi" role="tabpanel">
<div class="table-responsive">
<table class="table table-nowrap mb-0">
    <tbody>
        <tr>
            <th scope="row" style="width: 20%;">Date</th>
            <td>
                {{MydateTime($value->created_at)}}
            </td>
        </tr>
         <tr>
            <th scope="row" style="width: 20%;">Message</th>
            <td>
                {{$value->message}}
            </td>
        </tr>

       
    </tbody>
</table>
</div>
</div>
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
