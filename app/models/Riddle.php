<?php

class Riddle extends Eloquent {
	
	protected $table = 'riddles';
	public $timestamps = false;

	public function marker()
	{
		return $this->belongsTo('Marker');
	}
}