<?php
return array(
    
    'view_manager' => array(
        'template_path_stack' => array(
            'crunchyprofile' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'crunchyprofile' => 'CrunchyProfile\Controller\ProfileController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcuser' => array(
                'child_routes' => array(
                    'profile' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/profile',
                            'defaults' => array(
                                'controller' => 'crunchyprofile',
                                'action'     => 'edit',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
