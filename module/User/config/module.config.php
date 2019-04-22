<?php

return array(
    'controllers' => array(
        'factories' => array(
            'User\Controller\User' => 'User\Factories\UserControllerFactory',
        ),
    ),


    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        'controller' => 'User\Controller\User',
                        'action'     => 'login',
                    ),
                ),
              
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\User',
                                'action' => 'index',
                            )
                        )
                    )
                )




            ),
   
        ),
    ),

    'service_manager' => [
        'factories' => array(
            'Zend\Authentication\AuthenticationService' => 'User\Factories\AuthorisationServiceFactory',
        ),
        'invokables'=>array(
            'User\Services\MailService' => 'User\Services\MailService',
        ),
    ],

    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/User/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'User\Entity' => __NAMESPACE__ . '_driver'
                )
            )
         ),

            'authentication'=>[
                'orm_default' => [
                    'object_manager' => 'Doctrine\ORM\EntityManager',
                    'identity_class' => 'User\Entity\User',
                    'identity_property' => 'email',
                    'credential_property' => 'password',
                    'credential_callable' => function (User\Entity\User $user, $passwordGiven) {
                        return password_verify($passwordGiven,$user->getPassword());
                    },
                ],
            ],

    
    )
);
