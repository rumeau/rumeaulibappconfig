<?php
return [
    'rumeaulib_appconfig' => [
        'config_entity_class' => 'RumeauLibAppConfig\Entity\AppConfig',
        'object_manager' => 'doctrine.entitymanager.orm_default',

        'cache' => [
            'adapter'   => [
                'name' => 'memory',
            ],
            'plugins'   => [
                'serializer',
            ]
        ],

        'cache_key' => 'rumeaulib_appconfig',

        'forms' => [],
    ],

    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'config' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/config',
                            'defaults' => [
                                '__NAMESPACE__' => 'RumeauLibAppConfig\Controller',
                                'controller' => 'config',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'invokables' => [
            'RumeauLibAppConfig\Controller\Config' => 'RumeauLibAppConfig\Controller\ConfigController',
        ],
    ],

    'service_manager' => [
        'factories' => [
            'RumeauLibAppConfig\AppConfig' => 'RumeauLibAppConfig\Service\AppConfigFactory',
        ],
        'invokables' => [
            'RumeauLibAppConfig\Event\AppConfigEvent' => 'RumeauLibAppConfig\Event\AppConfigEvent',
        ],
    ],

    'form_elements' => [
        'invokables' => [
            'RumeauLibAppConfig\ConfigForm' => 'RumeauLibAppConfig\Form\ConfigForm',
            'RumeauLibAppConfig\ConfigElements' => 'RumeauLibAppConfig\Form\Config\Elements',
        ],
    ],

    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `rumeaulibappconfig_driver`
            'rumeaulibappconfig_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/RumeauLibAppConfig/Entity',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `rumeaulibappconfig_driver` for any entity under namespace `RumeauLibAppConfig\Entity`
                    'RumeauLibAppConfig\Entity' => 'rumeaulibappconfig_driver',
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'zfcuser' => __DIR__ . '/../view',
        ],
    ],
];