<?php

return [
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                'UthandoNewsletter\Controller\Subscriber' => ['action' => ['add-subscriber']],
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
];
