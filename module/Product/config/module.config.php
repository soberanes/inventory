<?php
return array(
    'controllers' => array(
        'invokables' => array(
        	'Product\Controller\Product' => 'Product\Controller\ProductController',
    	),
    ),
    'router' => array(
        'routes' => array(
            'product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
        	'product' => __DIR__ . '/../view',
    	),
	),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
            ),
            array(
                'label' => 'Productos',
                'route' => 'product',
                'pages' => array(
                    array(
                        'label' => 'Nuevo producto',
                        'route' => 'product',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Editar producto',
                        'route' => 'product',
                        'action' => 'edit',
                    ),
                    array(
                        'label' => 'Eliminar producto',
                        'route' => 'product',
                        'action' => 'delete',
                    ),
                ),
            ),
        ),
    ),
);