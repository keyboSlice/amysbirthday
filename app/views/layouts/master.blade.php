<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Document</title>
	{{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css') }}
	{{ HTML::style('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
	{{ HTML::style('css/animate.css') }}
	{{ HTML::style('packages/owl-carousel/owl.carousel.css') }}	
	{{ HTML::style('packages/owl-carousel/owl.transitions.css') }}
	{{ HTML::style('css/site.less', ['rel' => 'stylesheet/less', 'type' => 'text/css']) }}

	{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/less.js/1.7.3/less.min.js') }}
</head>
<body>
	
	<header class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<h1 class="pull-left">Happy Birthday!</h1>
			<button class="overlay-button btn btn-xs fff pull-right" style="margin-top:30px;" id="show-overlay"><i class="fa fa-search"></i></button>
		</div>
	</header>
	
	<div id="map-container">
		<div id="map-overlay">
			@yield('mapoverlay')
		</div>
		<div id="map"></div>
	</div>

	@yield('main')

	@yield('riddles')
	
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
	{{ HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
	{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.2.0/bootbox.min.js') }}
	{{ HTML::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyCggHY1ADRXsCJVDeAsAx1f_4easJBVfaM&sensor=true') }}
	{{ HTML::script('packages/owl-carousel/owl.carousel.min.js') }}


	@yield('scripts')
</body>
</html>