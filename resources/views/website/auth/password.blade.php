@extends('website.app')
@section('content')
	<x-website.partials.page-header  :title="trans('message.password_forgot')"/>
	<section>
        <div class="container">
			<div class="row">
				<div class="col-12 col-lg-5 mx-auto auth-box">
					<div class="auth-box-content">
						<h2 class="text-primary text-center mb-3">{{ trans('message.password_forgot_enter_email') }}</h2>
						@include('website.auth.form.password')
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
