@extends('admin.layouts.main')
@section('title', 'View Item')
@section('content')

<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">Item Details</h4>
<div class="">
<a href="{{ route('admin.sellers.items.index',$item->seller_id) }}">
<button class="btn btn-primary">< Back</button> 
</a>
</div>
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
<h5 class="pb-3 nav-tabs-custom">Seller: {{ucwords($item->seller->name)}}</h5>
<div class="tab-content border border-top-0 p-4">

<div class="tab-pane fade show active" id="specifi" role="tabpanel">
<div class="table-responsive">
    <table class="table table-nowrap mb-0">
        <tbody>
            <tr>
                <th scope="row" style="width: 20%;">Item Photo</th>
                <td>
                    <img src="{{img($item->picture)}}" alt="" class="avatar-xs rounded-circle me-2">
                </td>
            </tr>
           
            <tr>
                <th scope="row">Item  Name</th>
                <td>{{ucwords($item->name)}}</td>
            </tr>
            <tr>
                <th scope="row">Price</th>
                <td>{{$item->price}}</td>
            </tr>
            <tr>
                <th scope="row">Product Type</th>
                <td>{{$item->producttype->name}}</td>
            </tr>
            <tr>
                <th scope="row">Category</th>
                 <td>{{$item->category->name}}</td>
            </tr>
              @if($item->subcategory)
            <tr>
                <th scope="row">Sub Category</th>
                 <td>{{$item->subcategory->name}}</td>
            </tr>
            @endif
            <tr>
                <th scope="row">item Status</th>
                <td>{{$item->status}}</td>
            </tr>
            @if($item->size)
            <tr>
                <th scope="row">Size</th>
                <td>{{$item->size}}</td>
            </tr>
            @endif
            @if($item->color)
             <tr>
                <th scope="row">Color</th>
                <td>{{$item->color}}</td>
            </tr>
            @endif
            @if($item->weight)
             <tr>
                <th scope="row">Weight</th>
                <td>{{$item->weight}}</td>
            </tr>
            @endif
            @if($item->length)
             <tr>
                <th scope="row">Length</th>
                <td>{{$item->length}}</td>
            </tr>
            @endif
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
