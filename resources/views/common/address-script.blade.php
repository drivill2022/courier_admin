@push('script')
<script type="text/javascript">
	var placeSearch, autocomplete;
	var componentForm = {
		street_number: 'short_name', 
		route: 'long_name', 
		locality: 'long_name', 
		administrative_area_level_1: 'short_name', 
		country: 'long_name',
		postal_code: 'short_name'
	};
	function initAutocomplete() {
		autocomplete = new google.maps.places.Autocomplete(
			document.getElementById('address'), {types: ['geocode']});
		/*autocomplete.setComponentRestrictions({country: ["ng"] });*/ 
		autocomplete.addListener('place_changed', fillInAddress);
	}

	function fillInAddress() {
		var place = autocomplete.getPlace();
		if(!place.geometry){     
			window.alert("No details available for input: '" + place.name + "'");
			return;
		}
		var lat = place.geometry.location.lat();
		var lng = place.geometry.location.lng();
		document.getElementById('latitude').value = lat;
		document.getElementById('longitude').value = lng;
	}

	function geolocate() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var geolocation = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};
				var circle = new google.maps.Circle(
					{center: geolocation, radius: position.coords.accuracy});
				autocomplete.setBounds(circle.getBounds());
			});
		}
	}

</script>
<script src="https://maps.google.com/maps/api/js?key={{Setting::get('map_key')}}&libraries=places&callback=initAutocomplete" async defer></script>
@endpush