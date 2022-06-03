<select  class="form-select" name='{{$name}}' id="{{$id}}">
<option value="">Select Vehicle Model</option>
@foreach($models as $m)
<option value="{{$m->name}}" @if ($selected==$m->name)
selected @endif>{{$m->name}}</option>
@endforeach
</select>