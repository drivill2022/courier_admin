<select  class="form-select" name='{{$name}}' id="{{$id}}">
<option value="">Select Vehicle Brand</option>
@foreach($brands as $b)
<option value="{{$b->name}}" @if ($selected==$b->name)
selected @endif>{{$b->name}}</option>
@endforeach
</select>