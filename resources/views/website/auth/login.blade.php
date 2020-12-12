@extends('website.app')
@section('content')
	<x-website.partials.page-header  :title="$article->menu_title"/>
	<section>
        <div class="container">
			<div class="row">
				<div class="col-12 col-lg-5 mx-auto login-box">
					<h2 class="login-box-title text-primary text-center">{{ $article->title }}</h2>
					<div class="login-box-content">
						@include('website.auth.form.login')
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
