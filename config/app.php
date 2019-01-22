<?php return [
    'cache' => array(
        'identifier' => 'pukocache',
        'kind' => 'MEMCACHED',
        'expired' => 100,
        'host' => 'localhost',
        'port' => 11211,
    ),
    'const' => array(
        'OWNER' => 'puko'
    ),
    'logs' => array(
        'active' => true,
        'driver' => 'slack',
        'url' => 'https://hooks.slack.com/services/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',
        'username' => 'pagestatus',
        'emoji' => ':boom:',
        'level' => 'critical'
    )
];