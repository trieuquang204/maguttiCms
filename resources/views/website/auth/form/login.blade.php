@include('flash::notification')
<form class="login-form" method="post" action="{{url_locale('users/login')}}">
	{!! csrf_field() !!}
	@if (isset($redirectTo))
		<input type="hidden" name="redirectTo" value="{{$redirectTo}}">
	@endif
	<div class="form-group">
		<input type="email" class="form-control" name="email" value="" placeholder="{{trans('website.email')}}" equired>
	</div>
	<div class="form-group">
		<input type="password" class="form-control" name="password" value="" autocomplete="off" placeholder="{{trans('website.password')}}" required>
	</div>
	<div class="login-form-support d-flex flex-wrap justify-content-between">
		<div>
			<div class="form-checkbox">
				<input type="checkbox" class="form-input" name="remember" id="remember">
				<label for="remember">
					{{ trans('message.remember_me') }}
				</label>
			</div>
		</div>
		<div>
			<a class="text-color-4" href="{{ url_locale('/password/reset') }}">
				{{ trans('message.password_forgot_your') }}
			</a>
		</div>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-block">
			{{ trans('message.sign_in') }}
		</button>
	</div>

	@if (!isset($with_register))
		<div class="login-form-not-registered d-flex justify-content-center">
			{{ trans('message.not_registered') }}
			<a class="ml-1 text-accent" href="{{ url_locale('/register') }}">{{ trans('message.new_user') }}
			</a>
		</div>
	@endif
</form>
