{{ $label ?? '' }}
<select name="{{$name}}" id="{{$name}}" {{ $attributes->merge(['class' => "suggest-remote". $class]) }}
      data-model="{{$config->model}}"
      data-value="{{$value}}"
      data-caption="{{$caption}}"
      data-fields="{{$config->searchFields ?? ''}}"
      data-placeholder="{{trans('admin.label.'.$config->label)}}"
      data-where="{{$config->where ?? ''}}">
</select>