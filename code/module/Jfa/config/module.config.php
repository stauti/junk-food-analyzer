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
                    'route'    => '/backend[/:action][/:id]',
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
            'user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Jfa\Controller\User',
                        'action'     => 'login',
                    ),
                ),
            ),
            'ingredient' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/ingredient[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Jfa\Controller\Ingredient',
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