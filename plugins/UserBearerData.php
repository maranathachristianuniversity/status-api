<?php

namespace plugins;

use plugins\auth\MicroserviceAuthenticator;
use pukoframework\auth\Bearer;

/**
 * Trait UserData
 * @package plugins
 */
trait UserBearerData
{

    /**
     * @var array
     */
    public $user;

    /**
     * UserBearerData constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->user = Bearer::Get(MicroserviceAuthenticator::Instance())->GetLoginData()['user'];
    }


}