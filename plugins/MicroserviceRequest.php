<?php

namespace plugins;

use pukoframework\Request;

/**
 * Class MicroserviceRequest
 * @package plugins
 *
 * Example:
 * $data = MicroserviceRequest::To('itcare')->Url('user/1')->Method('POST')->Receive(array(), MicroserviceRequest::JSON);
 */
class MicroserviceRequest
{

    protected $service;

    protected $url;

    protected $method;

    const DEF = 'default';
    const JSON = 'json';
    const UNDEFINED = '';

    protected function __construct($service)
    {
        $this->service = $service;
    }

    public static function To($service)
    {
        return new MicroserviceRequest($service);
    }

    public function Url($url)
    {
        $this->url = $url;
        return $this;
    }

    public function Method($method)
    {
        $this->method = $method;
        return $this;
    }

    public function Receive($param = array(), $type = MicroserviceRequest::UNDEFINED)
    {
        $curl = curl_init();

        $authorization = "Authorization: " . Request::getAuthorizationHeader();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array($authorization));
        curl_setopt($curl, CURLOPT_URL, sprintf('http://%s/%s', $this->service, $this->url));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($curl, CURLOPT_USERAGENT, 'MicroserviceRequest');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($type === MicroserviceRequest::JSON) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($param));
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        }
        if ($type === MicroserviceRequest::DEF) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        }

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

}