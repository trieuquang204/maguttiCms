<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
		{{substr(LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['native'], 0, 3)}}
		{{icon('chevron-down')}}
	</a>
	<div class="dropdown-menu dropdown-menu-right">
		@foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
			@if (LaravelLocalization::getCurrentLocale() != $localeCode)
				@if ($locale_article && !$locale_article->ignore_slug_translation)
					<a class="dropdown-item" href="{{LaravelLocalization::getLocalizedURL($localeCode, $locale_article->getPermalink($localeCode))}}">
						{{$properties['native']}}
					</a>
				@else
					<a class="dropdown-item" href="{{LaravelLocalization::getLocalizedURL($localeCode)}}">
						{{$properties['native']}}
					</a>
				@endif
			@endif
		@endforeach
	</div>
</li>
