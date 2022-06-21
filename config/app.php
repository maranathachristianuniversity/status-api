<?php return [
    'const' => array(
        'OWNER' => ''
    ),
    'cache' => [
        'kind'    => 'MEMCACHED',
        'host'    => 'localhost',
        'port'    => 11211
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
