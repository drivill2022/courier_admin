<select  class="form-select" name='{{$name}}' id="{{$id}}">
<option value="">Select Merchant</option>
@foreach($merchants as $m)
<option value="{{$m->id}}" @if ($selected==$m->id)
selected @endif>{{$m->name}}/{{$m->mobile}}</option>
@endforeach
</select>