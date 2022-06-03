<select  class="form-select division_change" name='{{$name}}' id="{{$id}}">
<option value="">Select Division</option>
@foreach($divisions as $d)
<option value="{{$d->id}}" @if ($selected==$d->id)
selected @endif>{{$d->name}}</option>
@endforeach
</select>
