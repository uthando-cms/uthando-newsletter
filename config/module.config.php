<?php

return [
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'admin' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                'UthandoNewsletter\Controller\Subscriber' => ['action' => 'all']],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'UthandoNewsletter\Controller\Subscriber',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'UthandoNewsletter\Controller\Subscriber' => 'UthandoNewsletter\Controller\Subscriber',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'UthandoNewsletterSubscriber' => 'UthandoNewsletter\Form\Subscriber',
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'UthandoNewsletterSubscriber' => 'UthandoNewsletter\Hydrator\Subscriber',
        ],
    ],
    'input_filters' => [
        'invokables' => [
            'UthandoNewsletterSubscriber' => 'UthandoNewsletter\InputFilter\Subscriber',
        ],
    ],
    'uthando_mappers' => [
        'invokables' => [
            'UthandoNewsletterSubscriber' => 'UthandoNewsletter\Mapper\Subscriber',
        ],
    ],
    'uthando_models' => [
        'invokables' => [
            'UthandoNewsletterSubscriber' => 'UthandoNewsletter\Model\Subscriber',
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            'UthandoNewsletterSubscriber' => 'UthandoNewsletter\Service\Subscriber',
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
                            'subscriber' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/subscriber',
                                    'defaults' => [
                                        'controller' => 'Subscriber',
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
        ],
    ],
    'navigation' => [
        'admin' => [
            'newsletter' => [
                'label' => 'Newsletter',
                'route' => 'admin/newsletter/subscriber',
                'resource' => 'menu:admin',
                'pages' => [
                    'list' => [
                        'label'     => 'List All Subscribers',
                        'action'    => 'index',
                        'route'     => 'admin/newsletter/subscriber',
                        'resource'  => 'menu:admin'
                    ],
                    'add' => [
                        'label'     => 'Add New Subscriber',
                        'action'    => 'add',
                        'route'     => 'admin/newsletter/subscriber/edit',
                        'resource'  => 'menu:admin'
                    ],
                ],
            ],
        ],
    ],
];