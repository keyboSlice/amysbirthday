<?php

class UserTableSeeder extends Seeder
{
	public function run()
	{
		$user = [
			'username'  => 'amy',
			'password'  => Hash::make('dalenick'),
			'riddle_id' => 0
		];
		
		User::create($user);
	}
}