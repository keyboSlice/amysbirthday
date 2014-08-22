<?php

class HomeController extends BaseController {

	protected $layout = 'layouts.master';

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function showHome()
	{
		$user = User::find(1);
		$riddles = Riddle::where('ask_order', '<', $user->riddle_id)->get();
		$currentRiddle = Riddle::where('ask_order', '=', ($user->riddle_id))->firstOrFail();

		try 
		{
			$marker = Riddle::findOrFail($user->current_marker)->marker;
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e)
		{
			$marker = false;
		}

		$this->layout->content = View::make('partials.main')->with('user', $user)->with('riddles', $riddles)->withCurrent($currentRiddle)->withMarker($marker);
	}

	public function showLogin()
	{
		$this->layout->content = View::make('partials.login');
	}

	public function postLogin()
	{
		$password = Input::get('login');

		if(Auth::attempt(array('username' => 'amy', 'password' => $password)))
		{
			return Redirect::intended('/');
		}
		else
		{
			$this->layout->content = View::make('partials.login')->with('login', 'failed');
		}
	}

	public function postCode()
	{
		$code = Input::get('code');
		
		try 
		{
			$riddle = Riddle::where('code', '=', $code)->firstOrFail();
			$success = true;
			$user = User::find(1);
			$user->riddle_id = $riddle->ask_order;
			$user->current_marker = 0;
			$user->save();
		}
		catch (Illuminate\Database\Eloquent\ModelNotFoundException $e)
		{
			$riddle  = false;
			$success = false;
		}
		return Response::json(array('success' => $success, 'riddle' => $riddle));
	}

	public function postRiddle()
	{
		$answer = Input::get('answer');
		$id = Input::get('riddle_id');

		$riddle = Riddle::find($id);

		$response = array('success' => false);

		if(trim($answer) == $riddle->answer)
		{
			$response['marker'] = $riddle->marker;
			$response['success'] = true;
			$user = User::find(1);
			$user->current_marker = $riddle->id;
			$user->save();
		}

		return Response::json($response);
	}

}
