{{ $label ?? '' }}
<input {{ $attributes->merge(["class" => ""]) }}
       type ="{{$config['type'] ?? 'text'}}"
       placeholder = "{{trans('admin.label.'.$config['label'])}}"
/>

