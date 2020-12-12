@error($field)
    <span {{$attributes->merge(['class' => 'text-danger'])}}>{{$message}}</span>
@enderror