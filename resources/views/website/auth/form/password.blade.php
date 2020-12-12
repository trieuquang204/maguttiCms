@if ($errors->any())
	<div class='text-center alert alert-color-4'>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">{{icon('times')}}</button>
		{{icon('exclamation-circle', 'fa-3x')}}
		@foreach ( $errors->all() as $error)
			<p>{{ $error }}</p>
		@endforeach
	</div>
@endif
@if (session('status'))
	<div class="text-center alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">{{icon('times')}}</button>
		{{icon('exclamation-circle', 'fa-3x')}}
		<p>{!! session('status') !!}</p>
	</div>
@endif
<form method="POST" action="{{ url_locale('/password/email') }} ">
	{{ csrf_field() }}
	<div class="form-group">
		<input type="email" class="form-control" name="email" placeholder="{{ trans('website.email') }}" required>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-block">
			{{ trans('message.password_sent_reset_link') }}
		</button>
	</div>
</form>