<style type="text/css">
	.notify {
/*    margin-top: 210px;*/    
    font-size: 16px;
    font-weight: 900;
    text-align: center;
    margin: 95px 15px -75px;
}
.close:focus, .close:hover {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    opacity: .5;
}

button.close {
    padding: 0;
    cursor: pointer;
    background: 0 0;
    border: 0;
    -webkit-appearance: none;
}
.close {
    text-shadow: none;
}
.close {
    float: right;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .2;
}
</style>

@if(Session::has('flash_error'))
<div class="notify">
    <div class="alert alert-danger alert-dismissible mt-5">
        <button type="button" class="close" data-dismiss="alert" aria-label="close">×</button>
        {{ Session::get('flash_error') }}
    </div>
</div>
@endif
@if(Session::has('flash_success'))
<div class="notify">
    <div class="alert alert-success alert-dismissible mt-5">
        <button type="button" class="close" data-dismiss="alert" aria-label="close">×</button>
        {{ Session::get('flash_success') }}
    </div>
 </div>
@endif
@section('footer_scripts')
<script type="text/javascript">
    $('.close').click(function(){
     $(".notify").remove();
    });
</script>
@endsection