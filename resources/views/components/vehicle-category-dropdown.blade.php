<select  class="form-select" name='{{$name}}' id="{{$id}}">
<option value="">Select Vehicle Category</option>
@foreach($categories as $c)
<option value="{{$c->name}}" @if ($selected==$c->name)
selected @endif>{{$c->name}}</option>
@endforeach
</select>