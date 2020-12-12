@if (!Auth::guard()->check())
	<li class="nav-item">
		<a class="nav-link" href="{{url_locale('users/login')}}">
			{{trans('auth.login')}}
		</a>
	</li>
@else
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">{{Auth::guard()->user()->name}}</a>
		<div class="dropdown-menu">
			<a class="dropdown-item" href="{{url_locale('users/dashboard')}}">
				{{icon('list')}} {{trans('auth.dashboard')}}
			</a>

			<a class="dropdown-item" href="{{url_locale('users/profile')}}">
				{{icon('user')}} {{trans('auth.profile')}}
			</a>

			<a class="dropdown-item" href="{{url_locale('users/logout')}}">
				{{icon('sign-out')}} {{trans('auth.logout')}}
			</a>
		</div>
	</li>
@endif
