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
		autocomplete = new google.maps.places.Autocomplete(document.getElementById('s_address'), {types: ['geocode']});
		autocomplete2 = new google.maps.places.Autocomplete(document.getElementById('d_address'), {types: ['geocode']});
		/*autocomplete.setComponentRestrictions({country: ["ng"] });*/ 

		autocomplete.addListener('place_changed', fillInAddress);
		autocomplete2.addListener('place_changed', fillInAddress2);
	}

	function fillInAddress() {
		var place = autocomplete.getPlace();
		if(!place.geometry){     
			window.alert("No details available for input: '" + place.name + "'");
			return;
		}
		var lat = place.geometry.location.lat();
		var lng = place.geometry.location.lng();
		document.getElementById('s_latitude').value = lat;
		document.getElementById('s_longitude').value = lng;
	}
	function fillInAddress2() {
		var place2 = autocomplete2.getPlace();
		if(!place2.geometry){     
			window.alert("No details available for input: '" + place2.name + "'");
			return;
		}
		var lat = place2.geometry.location.lat();
		var lng = place2.geometry.location.lng();
		document.getElementById('d_latitude').value = lat;
		document.getElementById('d_longitude').value = lng;
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