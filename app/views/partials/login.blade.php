@extends('layouts.master')
@section('mapoverlay')
	
	<div id="overlay-owl" class="owl-carousel">
		<div class="item">
			<p>Welcome stranger</p>
		</div>
		<div class="item">
			<p>Onto your journey</p>
		</div>
		<div class="item">
			<p>If this games for you, then Happy Birthday!</p>
		</div>
		<div class="item">
			<p>But first my dear, you must show you're worthy</p>
		</div>
		<div class="item">
			<p>So riddle me this, and prove that it's you..</p>
		</div>
		<div class="item">
			<p>When we first met, I was with two</p>
		</div>
		<div class="item">
			<p>Their names I want.. the first will do</p>
		</div>
		<div class="item">
			<p>Answer alphetically to answer true</p>
		</div>
	</div>

	{{ Form::open(array('url' => '/login', 'method' => 'post', 'id' => 'login-form')) }}
		{{ Form::token() }}
		{{ Form::text('login', null, array('placeholder' => 'Answer Here..', 'class' => 'lobs'))}}
		{{ Form::submit('Solved it!', array('class' => 'lobs form-control')) }}
	{{ Form::close() }}

	@if(isset($login) && $login == 'failed')
		<div id="loginerrors"></div>
	@endif;
	
@stop

@section('scripts')
	{{ HTML::script('js/login.js') }}
	{{ HTML::script('js/site.js') }}
@stop