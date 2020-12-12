@extends('emails.master')
@section('content')
	<p>{{ trans('website.mail_message.contact')}}</p>
	<p><strong>{{ $subject }}</strong></p>
	<ul>
		<li><b>{{ trans('website.name')}}</b>: {{ $name }} {{ $surname }}</li>
		<li><b>{{ trans('website.company')}}</b>: {{ $company }}</li>
		<li><b>{{ trans('website.email')}}</b>: {{ $email }}</li>
		@if ($product)
			<li><b>Info request from product</b>: {{ $product }}</li>
		@endif
	</ul>
	<br />
	<p>
		<b>{{ trans('website.message_email')}}</b></p>
	    <p>
		@foreach ($messageLines as $messageLine)
			{{ $messageLine }}<br>
		@endforeach
	</p>
@endsection
