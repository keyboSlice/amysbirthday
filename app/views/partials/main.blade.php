@section('mapoverlay')
	
	<div id="overlay-owl">
		<div class="item">
			<p>Welcome Amy</p>
		</div>

		<div class="item">
			<p>Now the games can begin.</p>
		</div>

		<div class="item">
			<p>But you'll have to act fast</p>
		</div>

		<div class="item">
			<p>If you want to win..</p>
		</div>
	</div>

	<div class="overlay-buttons">
		<button class="overlay-button teal btn btn-lg" id="hide-overlay">Hide Overlay</button>
	</div>

	<button class="overlay-button fff btn btn-lg" style="border:none;position:absolute; bottom: 10%; left: 32%;text-align:center;" id="start-here">Start Here<br><i class="fa fa-arrow-circle-down" style="margin-top:15px;"></i></button>
@stop

@section('main')
	<section id="main">
		<div class="container">
			<img src="{{ URL::asset('img/gifts.png') }}" style="width:50%;margin-left:25%;">
			<h1>Welcome to the game</h1>
			<p style="margin:20px 0;">Today my dear, we are going to have some fun. You will be faced with a series of riddles, mainly based around us and our time together. Solve the riddle by entering the answer in the relevant text input below. Get it right and a marker will appear on the map, go to the marker and retrieve the code to receive the next riddle. There'll be some treats for you along the way too ;)</p>
			<p>Some of the riddles have a time limit on them. If you are struggling to answer the question by the specified time - CALL ME! Otherwise the day could be ruined, anything else and you are on your own.</p>
			<p style="margin:20px 0;">Good luck, have fun :)</p>
		</div>
	</section>
@stop

@section('riddles')
	<section id="voucherform">
		<div class="container">
			{{ Form::open(['url' => '/code', 'method' => 'post']) }}
				{{ Form::token() }}
				<h1>Submit Code</h1>
				{{ Form::text('code', null, ['placeholder' => 'Enter the correct code to get the next marker', 'class' => 'lobs col-xs-8']) }}
				{{ Form::submit('Solved it!', ['class' => 'lobs col-xs-4']) }}
			{{ Form::close() }}
		</div>
	</section>

	<section id="riddles">
		<div class="container">
			<h1>Riddles</h1>
			<div class="panel-group" id="accordion">
				@if($riddles)
				@foreach($riddles as $index => $riddle)
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a href="#riddle-{{$index}}" data-parent="#accordion" data-toggle="collapse">Riddle {{($index+1)}}</a>
						</h4>
					</div>
					<div id="riddle-{{$index}}" class="panel-collapse collapse in">
						<p>{{$riddle->text}}</p>
						<button class="btn btn-primary btn-block getClue" data-clue="{{$riddle->clue}}">I need a clue!</button>
					</div>
				</div>
				@endforeach
				@endif
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a href="#riddle-{{$current->ask_order}}" data-parent="#accordion" data-toggle="collapse">Riddle {{($current->ask_order + 1)}}</a>
						</h4>
					</div>
					<div id="riddle-{{$current->ask_order}}" class="panel-collapse collapse in">
						<button class="btn btn-primary btn-block getClue" data-clue="{{$current->clue}}">I need a clue!</button>
						<p>{{$current->text}}</p>
						{{Form::open(['url' => '/riddle', 'method' => 'post', 'class' => 'submitRiddle'])}}
							{{Form::token()}}
							{{Form::hidden('riddle_id', $current->id ) }}
							{{Form::text('answer', null, ['placeholder' => 'Answer Here', 'class' => 'lobs'])}}
							<button type="submit" class="btn btn-block btn-success submitRiddleBtn">Submit Answer</button>
						{{Form::close()}}
					</div>
				</div>
			</div>
		</div>
	</section>
@stop

@section('scripts')
<script>
'use strict';

$(document).ready(function() 
{
	var map, navi = {}, loc, mymarker, destination, destinationInfo, directionsDisplay, directionsService;

	var addAccordion = function(riddle)
	{
		return '<div class="panel panel-default">' +
			'<div class="panel-heading">'+
				'<h4 class="panel-title">'+
					'<a href="#riddle-'+(riddle.id-1)+'" data-parent="#accordion" data-toggle="collapse">Riddle '+riddle.id+'</a>'+
				'</h4>'+
			'</div>'+
			'<div id="riddle-'+(riddle.id-1)+'" class="panel-collapse collapse in">'+
				'<p>'+riddle.text+'</p>'+
				'<button class="btn btn-primary btn-block getClue" data-clue="'+riddle.clue+'">I need a clue!</button>'+
				'<form class="submitRiddle">'+
					'<input type="hidden" name="_token" value="{{Form::token()}}">'+
					'<input type="hidden" name="riddle_id" value="'+riddle.id+'">'+
					'<input type="text" name="answer" placeholder="Answer Here">'+
					'<button type="submit" class="btn btn-block btn-success submitRiddleBtn">Submit Answer</button>'+
				'</form>'+
			'</div>'+
		'</div>';
	}

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

		@if($marker)
			var contentString = '<div id="content">'+
							     "<h2>{{$marker->title}}</h2>"+
							     "<p>{{$marker->text}}</p>"+
							    '</div>';

			var request = {
				origin: new google.maps.LatLng(navi.lat, navi.long),
				destination: new google.maps.LatLng({{$marker->lat}}, {{$marker->long}}),
				travelMode: google.maps.TravelMode.DRIVING
			}

			destinationInfo = new google.maps.InfoWindow({content: contentString});

			destination = new google.maps.Marker({
				map: map,
				position: {lat: {{$marker->lat}}, lng: {{$marker->long}} },
				title: "{{$marker->title}}"
			});

			google.maps.event.addListener(destination, 'click', function()
			{
				destinationInfo.open(map, destination);
			});

			directionsService.route(request, function(response, stat){
				if(stat == google.maps.DirectionsStatus.OK)
				{
					directionsDisplay.setDirections(response);
				}
			});
		@endif
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

	var map, loc,
		start = {lat: 53.4803, long: -2.2416};

	initMap();

	$('#hide-overlay').on('click', function(e) 
	{
		e.preventDefault();
		$('#map-overlay').animate({top: '-100%'});
	});

	$('#show-overlay').on('click', function(e)
	{
		e.preventDefault();
		$('#map-overlay').animate({top: 0});
	});	

	$('#start-here').on('click', function(e)
	{
		e.preventDefault();
		$('body').animate({'scrollTop': $('#map').height() });
	});

	$('.getClue').on('click', function(e)
	{
		e.preventDefault();
		bootbox.alert($(this).data('clue'));
	});

	$('#voucherform input[type="submit"]').on('click', function(e)
	{
		e.preventDefault();
		$.post('/code', {code: $('#voucherform').find('input[name="code"]').eq(0).val(), _token: $('#voucherform').find('input[name="_token"]').eq(0).val()}, function(resp) 
		{
			if(!resp.success)
			{
				bootbox.alert('Ooops, that code was incorrect - you\'re not trying to cheat are you?');
				return false;
			}

			bootbox.alert('Code correct - a riddle has been added.');
			$('#accordion').append(addAccordion(resp.riddle));
		});
	});

	$('#riddles').on('click', '.submitRiddleBtn', function(e)
	{
		e.preventDefault();
		var riddle = $(this).parents('.submitRiddle').eq(0);
		$.post('/riddle?'+riddle.serialize(), function(resp)
		{	
			if(!resp.success)
			{
				bootbox.alert('Oops. Better luck next time');
				return false;
			}

			navigator.geolocation.getCurrentPosition(updateMap);
			bootbox.alert('Well done. A marker has been added to the map');

			var contentString = '<div id="content">'+
							     '<h2>'+resp.marker.title+'</h2>'+
							     '<p>'+resp.marker.text+'</p>'+
							    '</div>';

			var request = {
				origin: new google.maps.LatLng(navi.lat, navi.long),
				destination: new google.maps.LatLng(resp.marker.lat, resp.marker.long),
				travelMode: google.maps.TravelMode.DRIVING
			}

			destinationInfo = new google.maps.InfoWindow({content: contentString});

			destination = new google.maps.Marker({
				map: map,
				position: {lat: resp.marker.lat, lng: resp.marker.long},
				title: resp.marker.title
			});

			google.maps.event.addListener(destination, 'click', function()
			{
				destinationInfo.open(map, destination);
			});

			directionsService.route(request, function(response, stat){
				if(stat == google.maps.DirectionsStatus.OK)
				{
					directionsDisplay.setDirections(response);
				}
			});

		});	
	});
});
</script>
@stop