$(document).ready(function() {
		var map, navi = {}, loc, mymarker, destination, destinationInfo, directionsDisplay, directionsService;

	var initMap = function() {

		directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.maps.DirectionsRenderer();
		
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 8,
			center: loc
		});

		mymarker = new google.maps.Marker({
			map: map,
			title: 'You are here!'
		});

		directionsDisplay.setMap(map);

		navigator.geolocation.getCurrentPosition(updateMap);
	}

	var updateMap = function(position)
	{
		navi.lat  = position.coords.latitude;
		navi.long = position.coords.longitude;
		mymarker.setPosition({lat: navi.lat, lng: navi.long});
		map.setCenter({lat: navi.lat, lng: navi.long});
	}

	var overlayOwl = $('#overlay-owl').owlCarousel({
		autoPlay: true,
		navigation: false,
		slideSpeed: 300,
		paginationSpeed: 400,
		singleItem: true,
		transitionStyle: "goDown"
	});

});


