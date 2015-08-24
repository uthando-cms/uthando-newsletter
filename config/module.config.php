<?php

return [
    'asset_manager' => [
        'resolver_configs' => [
            'collections' => [
                'css/uthando-admin.css' => [
                    'css/newsletter-admin.css'
                ],
            ],
            'paths' => [
                'UthandoNewsletter' => __DIR__ . '/../public',
            ],
        ],
    ],
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'admin' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                'UthandoNewsletter\Controller\Message' => ['action' => 'all'],
                                'UthandoNewsletter\Controller\Newsletter' => ['action' => 'all'],
                                'UthandoNewsletter\Controller\Subscriber' => ['action' => 'all'],
                                'UthandoNewsletter\Controller\Template' => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'UthandoNewsletter\Controller\Message',
                'UthandoNewsletter\Controller\Newsletter',
                'UthandoNewsletter\Controller\Subscriber',
                'UthandoNewsletter\Controller\Template',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'UthandoNewsletter\Controller\Message'      => 'UthandoNewsletter\Controller\Message',
            'UthandoNewsletter\Controller\Newsletter'   => 'UthandoNewsletter\Controller\Newsletter',
            'UthandoNewsletter\Controller\Subscriber'   => 'UthandoNewsletter\Controller\Subscriber',
            'UthandoNewsletter\Controller\Template'     => 'UthandoNewsletter\Controller\Template',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'UthandoNewsletterMessage'          => 'UthandoNewsletter\Form\Message',
            'UthandoNewsletter'                 => 'UthandoNewsletter\Form\Newsletter',
            'UthandoNewsletterSubscriber'       => 'UthandoNewsletter\Form\Subscriber',
            'UthandoNewsletterTemplate'         => 'UthandoNewsletter\Form\Template',

            'UthandoNewsletterSubscriptionList' => 'UthandoNewsletter\Form\Element\SubscriptionList',
            'UthandoNewsletterTemplateList'     => 'UthandoNewsletter\Form\Element\TemplateList',
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'UthandoNewsletterMessage'      => 'UthandoNewsletter\Hydrator\Message',
            'UthandoNewsletter'             => 'UthandoNewsletter\Hydrator\Newsletter',
            'UthandoNewsletterSubscriber'   => 'UthandoNewsletter\Hydrator\Subscriber',
            'UthandoNewsletterSubscription' => 'UthandoNewsletter\Hydrator\Subscription',
            'UthandoNewsletterTemplate'     => 'UthandoNewsletter\Hydrator\Template',
        ],
    ],
    'input_filters' => [
        'invokables' => [
            'UthandoNewsletterMessage'      => 'UthandoNewsletter\InputFilter\Message',
            'UthandoNewsletter'             => 'UthandoNewsletter\InputFilter\Newsletter',
            'UthandoNewsletterSubscriber'   => 'UthandoNewsletter\InputFilter\Subscriber',
            'UthandoNewsletterTemplate'     => 'UthandoNewsletter\InputFilter\Template',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'ViewNewsletterRenderer' => 'UthandoNewsletter\Mvc\Service\ViewNewsletterRendererFactory',
            'ViewNewsletterStrategy' => 'UthandoNewsletter\Mvc\Service\ViewNewsletterStrategyFactory',
        ]
    ],
    'uthando_mappers' => [
        'invokables' => [
            'UthandoNewsletterMessage'      => 'UthandoNewsletter\Mapper\Message',
            'UthandoNewsletter'             => 'UthandoNewsletter\Mapper\Newsletter',
            'UthandoNewsletterSubscriber'   => 'UthandoNewsletter\Mapper\Subscriber',
            'UthandoNewsletterSubscription' => 'UthandoNewsletter\Mapper\Subscription',
            'UthandoNewsletterTemplate'     => 'UthandoNewsletter\Mapper\Template',
        ],
    ],
    'uthando_models' => [
        'invokables' => [
            'UthandoNewsletterMessage'      => 'UthandoNewsletter\Model\Message',
            'UthandoNewsletter'             => 'UthandoNewsletter\Model\Newsletter',
            'UthandoNewsletterSubscriber'   => 'UthandoNewsletter\Model\Subscriber',
            'UthandoNewsletterSubscription' => 'UthandoNewsletter\Model\Subscription',
            'UthandoNewsletterTemplate'     => 'UthandoNewsletter\Model\Template',
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            'UthandoNewsletterMessage'      => 'UthandoNewsletter\Service\Message',
            'UthandoNewsletter'             => 'UthandoNewsletter\Service\Newsletter',
            'UthandoNewsletterSubscriber'   => 'UthandoNewsletter\Service\Subscriber',
            'UthandoNewsletterSubscription' => 'UthandoNewsletter\Service\Subscription',
            'UthandoNewsletterTemplate'     => 'UthandoNewsletter\Service\Template',
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewNewsletterStrategy',
        ],
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
    'router' => [
        'routes' => [
            'newsletter' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/newsletter',
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoNewsletter\Controller',
                        'controller' => 'Preferences',
                        'action' => 'index',
                        'force-ssl' => true,
                    ],
                ],
            ],
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
                            'message' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/message',
                                    'defaults' => [
                                        'controller' => 'Message',
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
                            'template' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/template',
                                    'defaults' => [
                                        'controller' => 'Template',
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
                'route' => 'admin/newsletter',
                'resource' => 'menu:admin',
                'pages' => [
                    'list' => [
                        'label'     => 'List All Newsletters',
                        'action'    => 'index',
                        'route'     => 'admin/newsletter',
                        'resource'  => 'menu:admin'
                    ],
                    'add' => [
                        'label'     => 'Add New Newsletter',
                        'action'    => 'add',
                        'route'     => 'admin/newsletter/edit',
                        'resource'  => 'menu:admin'
                    ],
                    'messages' => [
                        'label' => 'Messages',
                        'route' => 'admin/newsletter/message',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label'     => 'List All Messages',
                                'action'    => 'index',
                                'route'     => 'admin/newsletter/message',
                                'resource'  => 'menu:admin'
                            ],
                            'add' => [
                                'label'     => 'Add New Message',
                                'action'    => 'add',
                                'route'     => 'admin/newsletter/message/edit',
                                'resource'  => 'menu:admin'
                            ],
                        ],
                    ],
                    'subscribers' => [
                        'label' => 'Subscribers',
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
                    'templates' => [
                        'label' => 'Templates',
                        'route' => 'admin/newsletter/template',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label'     => 'List All Templates',
                                'action'    => 'index',
                                'route'     => 'admin/newsletter/template',
                                'resource'  => 'menu:admin'
                            ],
                            'add' => [
                                'label'     => 'Add New Template',
                                'action'    => 'add',
                                'route'     => 'admin/newsletter/template/edit',
                                'resource'  => 'menu:admin'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];