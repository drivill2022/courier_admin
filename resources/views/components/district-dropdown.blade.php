<select  class="form-select district_change" name='{{$name}}' id="{{$id}}">
<option value="">Select District</option>
@foreach($districts as $d)
<option value="{{$d->id}}" @if ($selected==$d->id)
selected @endif>{{$d->name}}</option>
@endforeach
</select>

