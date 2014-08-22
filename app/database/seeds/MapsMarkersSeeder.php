<?php

class MapsMarkersSeeder extends Seeder {
	
	public function run()
	{
		$markers = [
			[
				'marker' => [
					'lat'   => '53.483475',
					'long'  => '-2.241518',
					'title' => 'See you there :)',
					'text'  => 'Unit L3/U3, Arndale Centre, United Kingdom, M4 3AQ'
				],
				'riddle' => [
					'marker_id' => 0,
					'text'      => 'My first is the water that flows as it goes.<br>Never still, it keeps running without any toes!<br>My second, well the ground that we stand on\'s a type<br>Land within water, but yet it stays dry!',
					'clue'      => '2 words you are after with no space between, near next is the best to find garms of your dreams.',
					'answer'    => 'riverisland',
					'ask_order' => 0,
					'code'      => 'default'
				]
			],
			[
				'marker'  => [
					'lat' => '53.481018',
					'long' => '-2.248838',
					'title' => 'Not far for this one :)',
					'text'  => '87 Bridge St, Manchester M3 2RE'
				],
				'riddle'  => [
					'marker_id' => 0,
					'text' => 'A personal riddle to mess with your noodle<br>A foods in the name, which I could eat oodles<br>A promise unkept is what its about<br>I asked for a treat you said without a doubt!<br>What food did you promise what food do I love<br>Not pies, crumbles, cakes or any of the above!',
					'clue' => 'This dessert is to die for, but I just want the type, if you are adding a filling you are not doing it right!',
					'answer' => 'strudel',
					'ask_order' => 1,
					'code' => 'iL0v3y0u'
				]
 			],
 			[
 				'marker' => [
 					'lat' => '53.480290',
 					'long' => '-2.245796',
 					'title' => 'Not far to go!',
 					'text' => '39 John Dalton St, Manchester M2 6FW'
 				],
 				'riddle' => [
 					'marker_id' => 0,
 					'text' => 'I hope your muscles are on the mend<br>Now its time to see a friend<br>To houses you both used tend<br>But now your locks she\'ll chop and blend<br>If you get this right you\'re such a trooper<br>This one is easy, it is _________!',
 					'clue' => '',
 					'answer' => 'lisacooper',
 					'ask_order' => 2,
 					'code' => 'Wh3r32g0'
 				]
 			],
 			[
 				'marker' => [
 					'text' => '303 Deansgate, Manchester M3 4LQ',
 					'title' => 'Almost baby!',
 					'lat' => '53.475110',
 					'long' => '-2.251408'
 				], 
 				'riddle' => [
 					'marker_id' => 0,
 					'text' => 'Now baby, im afraid that our game is almost through<br>I hope you can see how much I love you<br>My last riddles so easy it wont make you frown<br>Its a streetname I want, one of the main ones in town<br>You would think from the name that its a door owned by your boss<br>And when you want to go out, you visit its locks.',
 					'clue' => '',
 					'answer' => 'deansgate',
 					'ask_order' => 3,
 					'code' => '5h0wm3iN'
 				]
 			]
		];

		foreach($markers as $mark)
		{
			$marker = new Marker($mark['marker']);
			$marker->save();

			$riddle = new Riddle($mark['riddle']);
			$riddle->marker_id = $marker->id;
			$riddle->save();
		}
	}
}