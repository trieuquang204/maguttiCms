<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body>
<div class="flex-center position-ref full-height">

    {{--



<select name="" id="" class="form-control">
    @foreach ($tree as $category)
        <option value="{{$category->id}}">|{{str_repeat('__',$category->level)}} {{ $category->slug }}</option>
    @endforeach
</select>


--}}





    <ul>
        {{-- $articles->where('parent_id', null) filter using where collection --}}
        @foreach ($articles->where('parent_id', null) as $article)
            <li>{!! $article->title !!}</li>
            <ul>
                @foreach ($articles->where('parent_id', $article->id) as $child)
                    @include('website/tree/small_tree', ['child_article' => $child])
                @endforeach
            </ul>
        @endforeach
    </ul>


</div>
</body>
</html>
