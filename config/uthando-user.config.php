<?php

use UthandoNewsletter\Controller\MessageController;
use UthandoNewsletter\Controller\NewsletterController;
use UthandoNewsletter\Controller\PreferencesController;
use UthandoNewsletter\Controller\SettingsController;
use UthandoNewsletter\Controller\SubscriberAdminController;
use UthandoNewsletter\Controller\SubscriberController;
use UthandoNewsletter\Controller\TemplateController;

return [
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                PreferencesController::class => ['action' => ['index',]],
                                SubscriberController::class => ['action' => ['add-subscriber']],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                SubscriberController::class => ['action' => ['update-subscription']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                MessageController::class => ['action' => 'all'],
                                NewsletterController::class => ['action' => 'all'],
                                SettingsController::class => ['action' => 'all'],
                                SubscriberAdminController::class => ['action' => 'all'],
                                TemplateController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                MessageController::class,
                NewsletterController::class,
                PreferencesController::class,
                SettingsController::class,
                SubscriberController::class,
                SubscriberAdminController::class,
                TemplateController::class,
            ],
        ],
    ],
];
