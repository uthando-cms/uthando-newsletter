<?php

return [
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'admin' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                'UthandoNewsletter\Controller\Newsletter' => ['action' => 'all']],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'UthandoNewsletter\Controller\Newsletter',
            ],
        ],
    ],
    'controller' => [
        'invokables' => [
            'UthandoNewsletter\Controller\Newsletter' => 'UthandoNewsletter\Controller\Newsletter',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'UthandoNewsletter' => 'UthandoNewsletter\Form\Newsletter',
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'UthandoNewsletter' => 'UthandoNewsletter\Hydrator\Newsletter',
        ],
    ],
    'input_filters' => [
        'invokables' => [
            'UthandoNewsletter' => 'UthandoNewsletter\InputFilter\Newsletter',
        ],
    ],
    'uthando_mappers' => [
        'invokables' => [
            'UthandoNewsletter' => 'UthandoNewsletter\Mapper\Newsletter',
        ],
    ],
    'uthando_models' => [
        'invokables' => [
            'UthandoNewsletter' => 'UthandoNewsletter\Model\Newsletter',
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            'UthandoNewsletter' => 'UthandoNewsletter\Service\Newsletter',
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'type' => 'Segment',
                    'options' => [
                        'route' => '/newsletter',
                        'defaults' => [
                            '__NAMESPACE__' => 'UthandoNewsletter\Controller',
                            'controller' => 'Newsletter',
                            'action' => 'index',
                            'force-ssl' => 'ssl'
                        ],
                    ],
                    'may_terminate' => true,
                ],
            ],
        ],
    ],
    'navigation' => [
        'admin' => [
            'newsletter' => [
                'label' => 'Newsletter',
                'route' => 'admin/newsletter',
                'resource' => 'menu:admin'
            ],
        ],
    ],
];