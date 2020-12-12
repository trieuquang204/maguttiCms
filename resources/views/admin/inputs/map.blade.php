<div class="row mb5">
	<div class="col-7">
		<input class="form-control" id="address" type="text">
		<input name="lat" type="hidden">
		<input name="lng" type="hidden">
	</div>
	<div class="col-5">
		<button class="btn btn-primary btn-block" id="address-search">
			<i class="fa fa-search"></i>Cerca
		</button>
	</div>
</div>
<div id="event-search-map" style="height: 300px;"></div>

@section('footerjs')
	@parent
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{Setting::getOption('GMAPS_KEY')}}"></script>
	<script>
		var geocoder;
		var map;
		var marker;
		function initialize() {
			geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(45.6951822,9.6714131);
			var mapOptions = {
				zoom: 8,
				center: latlng
			}
			map = new google.maps.Map(document.getElementById('event-search-map'), mapOptions);
			marker = new google.maps.Marker({draggable:true});
			marker.addListener('dragend', function(e) {
				updateFields(marker.position);
			});
		}

		function codeAddress() {
			var address = $('#address').val();
			geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == 'OK') {
					map.setCenter(results[0].geometry.location);
					marker.setMap(map);
					marker.setPosition(results[0].geometry.location);
					updateFields(results[0].geometry.location);
				} else {
					alert('Impossibile trovare la posizione specificata.');
				}
			});
		}

		function updateFields(latlng) {
			$('input[name="lat"').val(latlng.lat);
			$('input[name="lng"').val(latlng.lng);
		}

		$(function() {
			initialize();
		})

		$('#address-search').on('click', function(e) {
			e.preventDefault();
			codeAddress();
		});
	</script>
@endsection
