@extends('merchant.layouts.main')
@section('title', 'Notifications')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-5 mt-3">
                        <div class="col-md-6">
                            <h4 class="card-title">Notification List</h4>
                        </div>
                     
                    </div>
                    <!-- Nav tabs -->
                    <!-- Tab panes -->
                 
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive mb-4 px-3">
                                    <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                                        <thead>
                                            <tr class="bg-transparent">
                                                <th>Date</th>
                                                <th>Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $value)
                                            <tr class="@if($value->is_viewed == "0") unread @endif">
                                                <td>{{date('d M,Y',strtotime($value->created_at))}}</td>
                                                <td>{{$value->message}}</td>
                                                <td><a class="btn btn-primary" href="{{route('merchant.notification-detail',$value->id)}}">View</a></td>
                                            </tr>
                                           @endforeach
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

</div> <!-- container-fluid -->
<!-- End Page-content -->
@endsection
