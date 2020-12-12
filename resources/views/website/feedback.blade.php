@extends('website.app')
@section('content')

    <main class="my-5">
        <div class="container">

            @include('website.partials.page_banner')

            @include('website.partials.pagetitle')

            @include('flash::notification')
        </div>
    </main>
    
@endsection
