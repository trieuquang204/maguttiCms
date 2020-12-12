<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Magutti"/>
    <meta name="google-site-verification" content="{{data_get($site_settings,'GA_SITE_VERIFICATION')}}"/>
    <meta name="theme-color" content="{{data_get($site_settings,'THEME_COLOR')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Meta SEO --}}
    {!! SEO::generate() !!}
    <style type="text/css">
        body, html {
            padding: 0px;
            margin: 0px;
            background-image: url(" {!! asset(config('maguttiCms.admin.path.assets').'/website/images/coming_soon.jpg') !!}");
            background-size: cover;
            background-position: center;
            background-color: white;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
    </style>

</head>
<body>

<div class="container ">
    <div class="row text-center">
        <div class="col-xs-12">
            <img class="center-block"
                 src="{!! asset(config('maguttiCms.admin.path.assets').'website/images/logo.png') !!}"
                 alt="{{ config('maguttiCms.website.option.app.name') }}">
        </div>
    </div>
</div>
</body>
</html>