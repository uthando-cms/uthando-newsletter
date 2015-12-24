<?php

return [
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
