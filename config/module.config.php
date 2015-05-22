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
    'controllers' => [
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
                    'newsletter' => [
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
                        'child_routes' => [
                            'edit' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'         => '/[:action[/id/[:id]]]',
                                    'constraints'   => [
                                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'		=> '\d+'
                                    ],
                                    'defaults'      => [
                                        'action'        => 'edit',
                                        'force-ssl'     => 'ssl'
                                    ],
                                ],
                            ],
                            'page' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'         => '/page/[:page]',
                                    'constraints'   => [
                                        'page'			=> '\d+'
                                    ],
                                    'defaults'      => [
                                        'action'        => 'list',
                                        'page'          => 1,
                                        'force-ssl'     => 'ssl'
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'admin' => [
            'newsletter' => [
                'label' => 'Newsletter',
                'route' => 'admin/newsletter',
                'resource' => 'menu:admin',
                'pages' => [
                    'list' => [
                        'label'     => 'List All Subscribers',
                        'action'    => 'index',
                        'route'     => 'admin/newsletter',
                        'resource'  => 'menu:admin'
                    ],
                    'add' => [
                        'label'     => 'Add New Subscriber',
                        'action'    => 'add',
                        'route'     => 'admin/newsletter/edit',
                        'resource'  => 'menu:admin'
                    ],
                ],
            ],
        ],
    ],
];