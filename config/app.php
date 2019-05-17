<?php return [
    'const' => [
        'OWNER' => 'Puko Framework',
    ],
    'cache' => [
        'kind' => 'MEMCACHED',
        'expired' => 100,
        'host' => 'localhost',
        'port' => 11211,
    ],
    'logs' => [
        'slack' => [
            'url' => 'https://hooks.slack.com/services/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',
            'secure' => '',
            'username' => 'pagestatus',
            'active' => false
        ],
        'hook' => [
            'url' => 'http://10.15.104.99:9102/notify/pagestatus',
            'secure' => '',
            'username' => 'pagestatus',
            'active' => false
        ]
    ]
];