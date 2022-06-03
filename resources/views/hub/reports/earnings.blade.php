@extends('hub.layouts.main')
@section('title', 'Earning Reports')
@section('content')

<div class="page-content">
<div class="container-fluid">
<div class="row">
<div class="col-12">


<div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
<h4 class="mb-0">Earning Details - </h4>
<input type="datetime-local" value="2019-08-19T13:45:00" id="example-datetime-local-input" class="form-control date_form_width">

</div>
</div>

</div>
<div class="row">
<div class="col-md-6 col-xl-3">
<div class="card">
<div class="card-body">
<div class="float-end mt-2">
<div id="total-revenue-chart"></div>
</div>
<div>
<h4 class="mb-1 mt-1">$<span data-plugin="counterup">1000</span></h4>
<p class="text-muted mb-0">Total Earning</p>
</div>
<p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
</p>
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
<h4 class="mb-1 mt-1">$<span data-plugin="counterup">900</span></h4>
<p class="text-muted mb-0">Received Payment</p>
</div>
<p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
</p>
</div>
</div>
</div> <!-- end col-->

<div class="col-md-6 col-xl-3">
<div class="card">
<div class="card-body">
<div class="float-end mt-2">
<div id="orders-chart"> </div>
</div>
<div>
<h4 class="mb-1 mt-1">$<span data-plugin="counterup">100</span></h4>
<p class="text-muted mb-0">Pending Payment</p>
</div>
<p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
</p>
</div>
</div>
</div> <!-- end col-->

<div class="col-md-6 col-xl-3">
<div class="card">
<div class="card-body">
<div class="float-end mt-2">
<div id="customers-chart"> </div>
</div>
<div>
<h4 class="mb-1 mt-1"><span data-plugin="">10/10/2020</span></h4>
<p class="text-muted mb-0">Last Receiving Payment Date </p>
</div>
<p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
</p>
</div>
</div>
</div>




</div> 
<!-- start page title -->

<!-- end page title -->

<div class="row">
<div class="col-lg-12">

<div class="table-responsive mb-4">
<table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
<thead>
<tr class="bg-transparent">

<th>Date</th>
<th>Total Earnig</th>
<th>Received Payment</th>
<th>Pending Payment</th>
<th>Payment Mode</th>
<th>Payment Id</th>
<th>Payment By</th>
</tr>
</thead>
<tbody>
<tr>

<td>15 Aug,2020</td>
<td>$100</td>
<td>$90</td>
<td>$10</td>
<td>
COD
</td>
<td>#ABC12345</td>
<td>Pizza Hurt</td>
</tr>
<tr>

<td>15 Aug,2020</td>
<td>$100</td>
<td>$90</td>
<td>$10</td>
<td>
COD
</td>
<td>#ABC12345</td>
<td>Pizza Hurt</td>

</tr>
<tr>

<td>15 Aug,2020</td>
<td>$100</td>
<td>$90</td>
<td>$10</td>
<td>
COD
</td>
<td>#ABC12345</td>
<td>Pizza Hurt</td>

</tr>




</tbody>
</table>
</div>
<!-- end table -->
</div>
</div>
<!-- end row -->

</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection

