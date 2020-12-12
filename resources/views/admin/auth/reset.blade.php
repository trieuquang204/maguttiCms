@extends('admin.service')
@section('content')
	<main id="login-main">
		<div id="login-block">
			<div class="card">
				<img src="{!! asset('cms/images/logo.png')!!}" alt="CMS Login">
				<hr>
				@include('shared.notification')
				<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/password/reset') }}">
					{{ csrf_field() }}
					<input type="hidden" name="token" value="{{ $token }}">
					<div class="form-group">
						<div class="col-12">
							<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required autofocus>
						</div>
					</div>
					<div class="form-group">
						<div class="col-12">
							<input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
						</div>
					</div>
					<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
						<div class="col-12">
							<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>

							<p class="mt-3">{{trans('website.message.password')}}</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-12">
							<button type="submit" class="btn btn-block btn-primary">
								Reset Password
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		@include('admin.footer')
	</main>
@endsection
