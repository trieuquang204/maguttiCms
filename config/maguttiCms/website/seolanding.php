<?php
return [
	'product-by-city' => [
		'route' => '/{product}-provincia-di-{city}/',
		'constraints' => ['product' => '[a-z\-]+', 'city' => '[a-z\-]+'],
		'method' => 'productByCity',
		'product' => [
			'prodotto-a' => 'Prodotto A',
			'prodotto-b' => 'Prodotto B',
			'prodotto-c' => [
				'base' => 'Prodotto C',
				'singular' => 'Prodotto C',
				'plural' => 'Prodotti C'
			],
		],
		'city' => [
			'bergamo' => 'Bergamo',
			'milano' => 'Milano',
			'brescia' => 'Brescia'
		],
	]
];
