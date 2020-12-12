@extends('website.app')
@section('content')

    <div id="map"></div>

    <section class="my-2">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <address>
                        <h3 class="text-primary">{{ config('maguttiCms.website.option.app.name') }}</h3>

                        <div class="text-muted">
                            {{ config('maguttiCms.website.option.app.address') }}<br>

                            {{ config('maguttiCms.website.option.app.locality') }}<br>

                            {{ icon('phone', 'fa-rotate-90 fa-fw') }}
                            Tel {{ config('maguttiCms.website.option.app.phone') }}<br>

                            {{ icon('fax', 'fa-fw') }} Fax {{ config('maguttiCms.website.option.app.fax') }}<br>

                            {{ icon('envelope', 'fa-fw') }}
                            <a href="mailto:{{ config('maguttiCms.website.option.app.email') }}">
                                {{ config('maguttiCms.website.option.app.email') }}
                            </a>
                        </div>
                    </address>
                </div>

                <div class="col-12 col-sm-6 col-md-8">
                    @include('website.form.contact')
                </div>
            </div>
        </div>
    </section>

@endsection
@section('footerjs')
    @parent
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{data_get($site_settings,'GMAPS_KEY')}}"></script>
    <script type="text/javascript">
        var marker_config =
		@if(count($locations))  @json($locations)
		@else($locations)
		[
			[
				'{!! config('maguttiCms.website.option.app.name')!!}',	//title
				{{data_get($site_settings,'LAT')}},	// lat
				{{data_get($site_settings,'LNG')}},	// lng
				'{{asset(config('maguttiCms.admin.path.assets').'website/images/map_marker.png')}}',	// icon image
				"<div class='mapPop'><b>{!! config('maguttiCms.website.option.app.name')!!}</b><br>{!! config('maguttiCms.website.option.app.address')!!}<br>{!! config('maguttiCms.website.option.app.locality')!!}<br></div>", //popup window content
			]
		];
		@endif

        var gmap_config = {
                mapElement: 'map',
                zoomLevel: 12,
                mapStyles: [],
                marker_config: marker_config
            };
        jQuery(document).ready(function () {
            gMap.init();
        });
    </script>
@endsection
