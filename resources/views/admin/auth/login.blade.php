@extends('admin.service')
@section('content')
	<main id="login-main">
		<div id="login-block">
			<div class="card">
				<img src="{!! asset(config('maguttiCms.admin.path.assets').'cms/images/logo.png')!!}" alt="CMS Login">

				<hr>
				<form method="post">
					<h3>Accedi</h3>
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							@foreach ($errors->all() as $error)
								<p>{{ $error }}</p>
							@endforeach
						</div>
					@endif
					{!! csrf_field() !!}
					<div class="form-group">
						<input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="E-Mail Address">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Password">
					</div>
					<div class="form-group row">
						<div class="col-6">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="remember" class="custom-control-input" id="remember">
								<label class="custom-control-label text-left" for="remember">@lang('message.remember_me')</label>
							</div>
						</div>
						<div class="col-6">
							<button type="submit" class="btn btn-primary btn-block">Login</button>
						</div>
					</div>
					<a href="{{ URL::to('/admin/password/reset/') }}">
						@lang('message.password_forgot')
					</a>
				</form>
			</div>
		</div>
		@include('admin.footer')
	</main>
@endsection
