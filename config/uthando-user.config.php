<?php

return [
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                'UthandoNewsletter\Controller\Preferences' => ['action' => ['index',]],
                                'UthandoNewsletter\Controller\Subscriber' => ['action' => ['add-subscriber']],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                'UthandoNewsletter\Controller\Subscriber' => ['action' => ['update-subscription']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                'UthandoNewsletter\Controller\Message' => ['action' => 'all'],
                                'UthandoNewsletter\Controller\Newsletter' => ['action' => 'all'],
                                'UthandoNewsletter\Controller\Settings' => ['action' => 'all'],
                                'UthandoNewsletter\Controller\SubscriberAdmin' => ['action' => 'all'],
                                'UthandoNewsletter\Controller\Template' => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'UthandoNewsletter\Controller\Message',
                'UthandoNewsletter\Controller\Newsletter',
                'UthandoNewsletter\Controller\Preferences',
                'UthandoNewsletter\Controller\Settings',
                'UthandoNewsletter\Controller\Subscriber',
                'UthandoNewsletter\Controller\SubscriberAdmin',
                'UthandoNewsletter\Controller\Template',
            ],
        ],
    ],
];
