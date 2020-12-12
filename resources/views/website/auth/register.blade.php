@extends('website.app')
@section('content')
	<x-website.partials.page-header  :title="trans('message.register')"/>
	<section>
        <div class="container">
			<div class="row">
				<div class="col-12 col-lg-6 mx-auto auth-box">
					<h2 class="text-primary text-center auth-box-title">{{ trans('message.register_account') }}</h2>
					<div class="auth-box-content">
					@include('website.auth.form.register')
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
