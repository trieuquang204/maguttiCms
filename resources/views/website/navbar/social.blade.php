@foreach ($socials as $_social)
	<li class="nav-item nav-social">
		<a class="nav-link" href="{{$_social->link}}" title="{{$_social->title}}">
			{{icon($_social->icon, 'fab')}}
		</a>
	</li>
@endforeach
