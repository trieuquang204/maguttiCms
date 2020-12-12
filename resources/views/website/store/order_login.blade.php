@extends('website.app')
@section('content')
	<x-website.partials.page-header  :title="trans('store.cart.buy')"/>
    <section>
        <div class="container">
        	<div class="row d-flex">
        		<div class="col-12 col-sm-6 auth-box ">
					<div class="auth-box-content h-100">
						<h3 class="text-primary text-center auth-box-title">{{trans('store.order.register')}}</h3>
						@include('website.auth.form.register')
					</div>
				</div>
				<div class="col-12 col-sm-6 login-box">
					<div class="login-box-content h-100">
						<h3 class="text-primary text-center login-box-title">{{trans('store.order.registered_user')}}</h3>
						<div class="mt-2 alert alert-color-4">
							{{trans('store.order.registered_user_login_message')}}
						</div>
						@include('website.auth.form.login')
					</div>
				</div>
			</div>
        </div>
    </section>
@endsection
