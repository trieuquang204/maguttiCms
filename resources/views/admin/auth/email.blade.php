@extends('admin.service')
<!-- Main Content -->
@section('content')
	<main id="login-main">
		<div id="login-block">
			<div class="card">
				<img src="{!! asset('/cms/images/logo.png')!!}" alt="CMS Login">
				<hr>
				@if (session('status'))
					<div class="alert alert-info">
						{{ session('status') }}
					</div>
				@endif
				@if ($errors->has('email'))
					<div class="alert alert-info">
						{{ $errors->first('email') }}
					</div>
				@endif
				<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/password/email') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<div class="col-12">
							<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="E-Mail Address" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-12">
							<button type="submit" class="btn btn-block btn-primary">
								{{ trans('message.password_sent_reset_link') }}
							</button>
						</div>
					</div>
					<a href="{{ URL::to('/admin/login/') }}">Login</a>
				</form>
			</div>
		</div>
		@include('admin.footer')
	</main>
@endsection
