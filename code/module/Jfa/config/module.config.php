<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Jfa\Controller\JunkFood' => 'Jfa\Controller\JunkFoodController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'junkfood' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/junkfood[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Jfa\Controller\JunkFood',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'jfa' => __DIR__ . '/../view',
        ),
    ),
);