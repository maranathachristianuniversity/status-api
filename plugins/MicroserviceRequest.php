<?php

namespace plugins;

use pukoframework\Request;

/**
 * Class MicroserviceRequest
 * @package plugins
 *
 * Example:
 * $data = MicroserviceRequest::To('itcare')->Url('user/1')->Method->('POST')->Receive(array(), MicroserviceRequest::JSON);
 */
class MicroserviceRequest
{

    /**
     * @var MicroserviceRequest
     */
    private static $MRequest;

    protected $service;

    protected $url;

    protected $method;

    const DEF = 'default';
    const JSON = 'json';
    const UNDEFINED = '';

    protected function __construct($service)
    {
        $this->service = $service;
        if (self::$MRequest instanceof MicroserviceRequest) {
            return;
        }
        self::$MRequest = new MicroserviceRequest($service);
    }

    public static function To($service)
    {
        return new MicroserviceRequest($service);
    }

    public function Url($url)
    {
        $this->url = $url;
        return self::$MRequest;
    }

    public function Method($method)
    {
        $this->method = $method;
        return self::$MRequest;
    }

    public function Receive($param = array(), $type = MicroserviceRequest::UNDEFINED)
    {
        $curl = curl_init();

        $authorization = "Authorization: " . Request::getAuthorizationHeader();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($curl, CURLOPT_URL, sprintf('http://%s?url=%s', $this->service, $this->url));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($curl, CURLOPT_USERAGENT, 'MicroserviceRequest');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($type === MicroserviceRequest::JSON) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($param));
        }
        if ($type === MicroserviceRequest::DEF) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($param));
        }

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

}