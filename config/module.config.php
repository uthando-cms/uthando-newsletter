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
    'controllers' => [
        'invokables' => [
            'UthandoNewsletter\Controller\Message'      => 'UthandoNewsletter\Mvc\Controller\Message',
            'UthandoNewsletter\Controller\Newsletter'   => 'UthandoNewsletter\Mvc\Controller\Newsletter',
            'UthandoNewsletter\Controller\Subscriber'   => 'UthandoNewsletter\Mvc\Controller\Subscriber',
            'UthandoNewsletter\Controller\Template'     => 'UthandoNewsletter\Mvc\Controller\Template',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'UthandoNewsletterMessage'          => 'UthandoNewsletter\Form\Message',
            'UthandoNewsletter'                 => 'UthandoNewsletter\Form\Newsletter',
            'UthandoNewsletterSubscriber'       => 'UthandoNewsletter\Form\Subscriber',
            'UthandoNewsletterTemplate'         => 'UthandoNewsletter\Form\Template',

            'UthandoNewsletterList'             => 'UthandoNewsletter\Form\Element\NewsletterList',
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
                'type' => 'Literal',
                'options' => [
                    'route' => '/newsletter',
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoNewsletter\Controller',
                        'controller' => 'Preferences',
                        'action' => 'index',
                        'force-ssl' => true,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'subscribe' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/subscribe',
                            'defaults' => [
                                'controller' => 'Subscriber',
                                'action' => 'add-subscriber',
                                'force-ssl' => true,
                            ],
                        ],
                    ],
                    'update' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/update',
                            'defaults' => [
                                'controller' => 'Subscriber',
                                'action' => 'update-subscription',
                                'force-ssl' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];