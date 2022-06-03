<select  class="form-select" name='{{$name}}' id="{{$id}}">
<option value="">Select Hub</option>
@foreach($hubs as $h)
<option value="{{$h->id}}" @if ($selected==$h->id)
selected @endif>{{$h->name}}</option>
@endforeach
</select>