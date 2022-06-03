<select  class="form-select thana_change" name='{{$name}}' id="{{$id}}">
<option value="">Select Thana</option>
@foreach($thanas as $d)
<option value="{{$d->id}}" @if ($selected==$d->id)
selected @endif>{{$d->name}}</option>
@endforeach
</select>