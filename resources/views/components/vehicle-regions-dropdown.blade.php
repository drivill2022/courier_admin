<select  class="form-select" name='{{$name}}' id="{{$id}}">
<option value="">Select Vehicle Region</option>
@foreach($regions as $r)
<option value="{{$r->name}}" @if ($selected==$r->name)
selected @endif>{{$r->name}}</option>
@endforeach
</select>