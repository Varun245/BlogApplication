<?php

return array(
    'controllers' => array(
        'factories' => array(
            'Blog\Controller\Blog' => 'Blog\Factories\ControllerFactory',
        ),
    ),

    'router' => array(
        'routes' => array(
            'blog' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Blog',
                        'action'     => 'index',
                    ),
                ),

                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Blog',
                                'action' => 'display',
                            )
                        )
                    )
                )
            ),
        ),
    ),

    'service_manager' => [
        'factories' => array(
            'Blog\Services\BlogService' => 'Blog\Factories\BlogServiceFactory',
            'Blog\Repositories\BlogRepository' => 'Blog\Factories\BlogRepositoryFactory'
        ),
    ],

    'view_manager' => array(
        'template_path_stack' => array(
            'blog' => __DIR__ . '/../view',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Blog/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Blog\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);
