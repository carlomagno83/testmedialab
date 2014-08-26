<?php

return array(

	'controllers' => array(
	 'invokables' => array(
	     'Usuario\Controller\Usuario' => 'Usuario\Controller\UsuarioController',
	 ),
	),

	'router' => array(
		'routes' => array(
		 'usuario' => array(
		     'type'    => 'segment',
		     'options' => array(
		         'route'    => '/usuario[/][:action][/:id]',
		         'constraints' => array(
		             'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
		             'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
		         ),
		         'defaults' => array(
		             'controller' => 'Usuario\Controller\Usuario',
		             'action'     => 'index',
		         ),
		     ),
		 ),
		),
	),

	'view_manager' => array(
	 'template_path_stack' => array(
	     'usuario' => __DIR__ . '/../view',
	 ),
	),

);