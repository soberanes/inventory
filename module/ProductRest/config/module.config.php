<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'ProductRest\Controller\ProductRest' => 'ProductRest\Controller\ProductRestController',
		),
	),
	 'router' => array(
		'routes' => array(
			'product-rest' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/product-rest[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'ProductRest\Controller\ProductRest',
					),
				),
			),
		),
	),
	'view_manager' => array(
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),
);