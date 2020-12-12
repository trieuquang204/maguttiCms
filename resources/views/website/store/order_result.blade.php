@extends('website.app')
@section('content')

    <main class="my-5">
        <div class="container">
            <h1 class="text-primary">{{trans('store.payment.title')}}</h1>

            @include('flash::notification')
        	<a href="{{$order->getPermalink()}}" class="btn btn-primary">
        		{{trans('store.payment.back')}}
        	</a>
        </div>
    </main>

@endsection
