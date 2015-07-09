<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'JfaRest\Controller\JunkFoodRest' => 'JfaRest\Controller\JunkFoodRestController',
            'JfaRest\Controller\IngredientsRest' => 'JfaRest\Controller\IngredientsRestController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'junkfood-rest' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/junkfood[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'JfaRest\Controller\JunkFoodRest',
                    ),
                ),
            ),
            'user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user/:name[/:password]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'name'     => '[a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Jfa\Controller\User',
                        'action'     => 'get',
                    ),
                ),
            ),
            'ingredients-rest' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/ingredient[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'name'     => '[a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'JfaRest\Controller\IngredientsRest',
                    ),
                ),
            )
        ),
    ),

    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);