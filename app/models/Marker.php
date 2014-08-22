<?php

class Marker extends Eloquent 
{
	protected $table   = 'markers';
	public $timestamps = false;

	public function riddle()
	{
		return $this->hasOne('Riddle');
	}
}