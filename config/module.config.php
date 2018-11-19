<?php

use UthandoNewsletter\Controller\MessageController;
use UthandoNewsletter\Controller\NewsletterController;
use UthandoNewsletter\Controller\PreferencesController;
use UthandoNewsletter\Controller\SubscriberAdminController;
use UthandoNewsletter\Controller\SubscriberController;
use UthandoNewsletter\Controller\TemplateController;
use UthandoNewsletter\Service\MessageService;
use UthandoNewsletter\Service\NewsletterService;
use UthandoNewsletter\Service\SubscriberService;
use UthandoNewsletter\Service\SubscriptionService;
use UthandoNewsletter\Service\TemplateService;
use UthandoNewsletter\View\Renderer\NewsletterRenderer;
use UthandoNewsletter\View\Service\NewsletterRendererFactory;
use UthandoNewsletter\View\Service\NewsletterStrategyFactory;
use UthandoNewsletter\View\Strategy\NewsletterStrategy;

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
            MessageController::class            => MessageController::class,
            NewsletterController::class         => NewsletterController::class,
            PreferencesController::class        => PreferencesController::class,
            SubscriberAdminController::class    => SubscriberAdminController::class,
            SubscriberController::class         => SubscriberController::class,
            TemplateController::class           => TemplateController::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            NewsletterRenderer::class => NewsletterRendererFactory::class,
            NewsletterStrategy::class => NewsletterStrategyFactory::class,
        ]
    ],
    'uthando_services' => [
        'invokables' => [
            MessageService::class       => MessageService::class,
            NewsletterService::class    => NewsletterService::class,
            SubscriberService::class    => SubscriberService::class,
            SubscriptionService::class  => SubscriptionService::class,
            TemplateService::class      => TemplateService::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            NewsletterStrategy::class,
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
                        'controller' => PreferencesController::class,
                        'action' => 'index',
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
                            ],
                        ],
                    ],
                    'update' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/update',
                            'defaults' => [
                                'controller' => SubscriberController::class,
                                'action' => 'update-subscription',
                            ],
                            'constraints'   => [
                                'email'    => '[a-zA-Z][a-zA-Z0-9]*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];