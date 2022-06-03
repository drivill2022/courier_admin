<select  class="form-select" name='{{$name}}' id="{{$id}}" data-placeholder="Select Product Types..." @if(!$single)multiple @endif>
<option value="">@if($single)Product Type @endif</option>
@foreach($product_types as $p)
<option value="{{$p->id}}" @if (in_array($p->id,$selected))
selected @endif>{{$p->name}}</option>
@endforeach
</select>