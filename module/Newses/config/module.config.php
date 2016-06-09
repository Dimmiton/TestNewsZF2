<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Newses\Controller\Newses' => 'Newses\Controller\NewsesController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'newses' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/newses[/:action][/:id][/:id1]',
                    'constraints' => array(
					    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
						'id1'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Newses\Controller\Newses',
                        'action'     => 'index', 
                    ),
                ),
            ),			
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'newses' => __DIR__ . '/../view',
        ),
    ),	
);