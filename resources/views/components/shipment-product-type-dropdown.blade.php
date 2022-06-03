<select  class="form-select" name='{{$name}}' id="{{$id}}">
<option value="">Select Product Type</option>
@foreach($product_types as $h)
<option value="{{$h['id']}}" @if ($selected==$h['id'])
selected @endif>{{$h['name']}}</option>
@endforeach
</select>