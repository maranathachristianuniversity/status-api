<?php
/*
 *---------------------------------------------------------------
 * PUKO FRAMEWORK
 *---------------------------------------------------------------
 *
 */

use pukoframework\Framework;
use pukoframework\config\Factory;

require 'vendor/autoload.php';

date_default_timezone_set("Asia/Jakarta");

/*
 *---------------------------------------------------------------
 * APP BASE URL
 *---------------------------------------------------------------
 *
 */
$protocol = 'http';
if (isset($_SERVER['HTTPS'])) {
    $protocol = 'https';
} else if (isset($_SERVER['HTTP_X_SCHEME'])) {
    $protocol = strtolower($_SERVER['HTTP_X_SCHEME']);
} else if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $protocol = strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']);
} else if (isset($_SERVER['SERVER_PORT'])) {
    $serverPort = (int)$_SERVER['SERVER_PORT'];
    if ($serverPort == 80) {
        $protocol = 'http';
    } else if ($serverPort == 443) {
        $protocol = 'https';
    }
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, Authorization, X-Permissions");

$factory = [
    'cli_param'   => null,
    'environment' => $_SERVER['ENVIRONMENT'], //possible value: PROD, DEV, MAINTENANCE
    'base'        => ($protocol.'://'.$_SERVER['HTTP_HOST'].'/'),
    'root'        => __DIR__,
    'start'       => microtime(true),
];
$fo = new Factory($factory);

//Initialize framework object
$framework = new Framework($fo);
$framework->Start();
