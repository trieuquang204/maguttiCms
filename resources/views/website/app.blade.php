@inject('pages','App\Article')
<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Magutti" />
    <meta name="google-site-verification" content="{{data_get($site_settings,'GA_SITE_VERIFICATION')}}" />
    <meta name="theme-color" content="{{data_get($site_settings,'THEME_COLOR')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Meta SEO --}}
    {!! SEO::generate() !!}

    <link href="{{ asset(config('maguttiCms.admin.path.assets').'website/images/icon.png') }}" type="image/PNG" rel="icon">
    <link href="{{ asset(config('maguttiCms.admin.path.assets').mix('website/css/vendor.css')) }}" rel="stylesheet">
    <link href="{{ asset(config('maguttiCms.admin.path.assets').mix('website/css/app.css')) }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @include('website.partials.widgets_mobile_app')

    {{-- Google analytics tracking code --}}
    @include('website.partials.widgets_ga')

    {{-- Google recaptcha code --}}
    @include('website.partials.widgets_captcha')

    {{-- Iubenda banner code --}}
    {{-- @include('website.partials.iubenda_banner') --}}
</head>
<body>
<div id="app">
    {{-- Navbar --}}
    @include('website.partials.navbar')
    {{-- Page content --}}
    @yield('content')
    {{-- Footer --}}
    <x-website.partials.footer/>
</div>
    {{-- default js to show in all pages --}}
    <script type="text/javascript">
        var urlAjaxHandler  = "{{ url_locale('/') }}";
        var _LANG           = "{{ get_locale() }}";
        var _WEBSITE_NAME	= "{!! config('maguttiCms.website.option.app.name')!!}";
        var imageScroll     = "{!! asset(config('maguttiCms.admin.path.assets').'website/images/up.png') !!}";

        @if (store_enabled())
        window.StoreConfig = {
            decimals: {{config('maguttiCms.store.formatting.decimals')}},
            decimal_separator: '{{config('maguttiCms.store.formatting.decimal_separator')}}',
            thousands_separator: '{{config('maguttiCms.store.formatting.thousands_separator')}}',
            prepend_currency: {{config('maguttiCms.store.formatting.prepend_currency')}},
            append_currency: {{config('maguttiCms.store.formatting.append_currency')}},
            currency_symbol: '{{config('maguttiCms.store.currency_symbol')}}'
        };
        @endif
    </script>
    @include('website.partials.js_localization')

    <script type="text/javascript" src="{{ asset(config('maguttiCms.admin.path.assets').mix('/website/js/vendor.js')) }}"></script>
    <script type="text/javascript" src="{{ asset(config('maguttiCms.admin.path.assets').mix('/website/js/app.js')) }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            App.init();
        });
    </script>

    {{-- Store JS --}}
    @if (store_enabled())
    <script type="text/javascript" src="{{ asset(config('maguttiCms.admin.path.assets').mix('/website/js/cart.js')) }}"></script>
    @endif

    {{-- Iubenda code --}}
    @include('website.partials.iubenda_policies')

    {{-- Cookie widget --}}
    @include('website.partials.widgets_cookie')
    @stack('scripts')
    @yield('footerjs')
</body>
</html>
