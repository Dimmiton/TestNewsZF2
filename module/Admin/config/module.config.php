<?php


return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
        ),
    ),
	
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
	
	'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'segment',
                'options' => array(
                     'route'    => '/admin[/:action][/:news_id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'news_id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'AdminController\Admin',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	
);