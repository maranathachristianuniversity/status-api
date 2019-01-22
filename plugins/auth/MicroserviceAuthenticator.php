<?php

namespace plugins\auth;

use pukoframework\auth\Auth;
use pukoframework\auth\PukoAuth;

class MicroserviceAuthenticator implements Auth
{

    /**
     * @var MicroserviceAuthenticator
     */
    static $authenticator;

    public static function Instance()
    {
        if (!self::$authenticator instanceof MicroserviceAuthenticator) {
            self::$authenticator = new MicroserviceAuthenticator();
        }
        return self::$authenticator;
    }

    /**
     * @param $username
     * @param $password
     * @return PukoAuth|bool
     * This method should return instance of PukoAuth if login success.
     * Reurn fase if login failed.
     */
    public function Login($username, $password)
    {
        return new PukoAuth($username, $password);
    }

    public function Logout()
    {

    }

    /**
     * @param $id
     * @param $permission
     * @return mixed
     * @throws \Exception
     * @throws \pukoframework\cache\CacheException
     * @throws \pukoframework\peh\PukoException
     */
    public function GetLoginData($id, $permission)
    {
        $curl = curl_init();

        $authorization = "Authorization: " . $this->getAuthorizationHeader();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($curl, CURLOPT_URL, 'http://itcare/user/' . $id);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Gateway');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        $user = json_decode($response, true);
        $data['user'] = $user['user'];
        $data['permissions'] = $permission;
        return $data;
    }

    /**
     * Get hearder Authorization
     */
    private function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map(
                'ucwords',
                array_keys($requestHeaders)),
                array_values($requestHeaders)
            );
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

}