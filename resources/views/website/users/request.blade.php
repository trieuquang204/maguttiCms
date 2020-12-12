@extends('website.app')
@section('content')

    <main class="my-5">
        <div class="container">
            @include('website.partials.pagetitle')

            <div class="col-12 mb0 text-center">{!! $article->description !!}</div>
        </div>
    </main>

@endsection
