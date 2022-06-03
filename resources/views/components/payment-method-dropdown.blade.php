<select  class="form-select" name='{{$name}}' id="{{$id}}">
<option value="">Select Payment Method</option>
@foreach($payment_method as $p)
<option value="{{$p->id}}" @if ($selected==$p->id)
selected @endif>{{$p->name}}</option>
@endforeach
</select>