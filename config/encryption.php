<?php return [
    'method'     => 'AES-256-CBC',
    'key'        => $_SERVER['SECRET_KEY'],
    'identifier' => 'microservices',
    'cookies'    => 'kitamaranatha',
    'session'    => 'kitamaranatha',
    'expiredText'=> 'Login untuk melanjutkan',
    'errorText'  => 'Anda tidak memiliki hak akses',
];