<?php return [
    'const' => array(
        'OWNER' => ''
    ),
    'cache' => [
        'identifier' => 'pukocache',
        'kind' => 'MEMCACHED',
        'expired' => 10,
        'host' => 'localhost',
        'port' => 11211,
    ],
    'logs' => [
        'slack' => [
            'url' => $_SERVER['SLACK'],
            'secure' => '',
            'username' => 'status-api',
            'active' => true
        ],
        'hook' => [
            'url' => $_SERVER['HOOK'],
            'secure' => '',
            'username' => 'status-api',
            'active' => true
        ]
    ]
];