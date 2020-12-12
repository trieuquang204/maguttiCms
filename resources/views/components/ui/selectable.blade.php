{{ $label ?? '' }}
<select name="{{$name}}" id="{{$name}}" {{ $attributes->merge(['class' => $class]) }} >
    <option value="">{{trans('admin.label.'.$config->label)}}</option>
    @foreach($items as $item)
        <option value="{{ $item->$value}}">{{$item->$caption}}</option>
    @endforeach
</select>