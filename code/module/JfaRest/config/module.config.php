<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'JfaRest\Controller\JunkFoodRest' => 'JfaRest\Controller\JunkFoodRestController',
            'JfaRest\Controller\UserRest' => 'JfaRest\Controller\UserRestController',
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
            'user-rest' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user[/:id]',
                    'constraints' => array(
                        'name'     => '[a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'JfaRest\Controller\UserRest',
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