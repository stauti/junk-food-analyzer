<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Jfa\Controller\JunkFood' => 'Jfa\Controller\JunkFoodController',
            'Jfa\Controller\User' => 'Jfa\Controller\UserController',
            'Jfa\Controller\Ingredient' => 'Jfa\Controller\IngredientController',
            'Jfa\Controller\Auth' => 'Jfa\Controller\AuthController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'junkfood' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/backend/junkfood[/:action][/:id]',
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
            'users' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/backend/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Jfa\Controller\User',
                        'action'     => 'index',
                    ),
                ),
            ),
            'ingredient' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/backend/ingredient[/:action][/:id]',
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
            'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Jfa\Controller',
                        'controller'    => 'Auth',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
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