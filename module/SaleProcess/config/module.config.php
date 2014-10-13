<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'SaleProcess\Controller\SaleProcess' => 'SaleProcess\Controller\SaleProcessController',
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
						'controller' => 'SaleProcess\Controller\SaleProcess',
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