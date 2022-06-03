<select  class="form-select" name='{{$name}}' id="{{$id}}">
<option value="">Select Shipment Type</option>
@foreach($shipment_types as $h)
<option value="{{$h['id']}}" @if ($selected==$h['id'])
selected @endif>{{$h['name']}}</option>
@endforeach
</select>