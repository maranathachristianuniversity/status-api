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
            'url' => '',
            'secure' => '',
            'username' => 'status-api',
            'active' => false
        ],
        'hook' => [
            'url' => '',
            'secure' => '',
            'username' => 'status-api',
            'active' => false
        ]
    ]
];