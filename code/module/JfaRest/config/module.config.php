<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'JfaRest\Controller\JunkFoodRest' => 'JfaRest\Controller\JunkFoodRestController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'junkfood-rest' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/junkfood-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'JfaRest\Controller\JunkFoodRest',
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