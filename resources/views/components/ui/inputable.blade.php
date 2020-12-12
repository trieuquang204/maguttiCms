@if($label??'')
<label for="{{$key}}">{{$label??''}}:</label>
@endif
<input
        type="{{ $type??'text' }}"
        id="{{ $key }}"
        name="{{$key}}"
        {{$redonly??''}}
        {{$requered??''}}
        placeholder="{{$placeholder ?? $key}}"
        {{ $attributes->merge(["class" => ""])}}
>

