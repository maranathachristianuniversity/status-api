<?php

namespace controller;

use Exception;
use model\HealthModel;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * Class health
 * @package controller
 * #Template html false
 */
class health extends Service
{
    use UserBearerData;

    /**
     * @return mixed
     * @throws Exception
     */
    public function create()
    {
        $param = Request::JsonBody();
        if ($param['appidentifier'] === '') {
            throw new Exception("App Identifier required");
        }
        if ($param['displayname'] === '') {
            throw new Exception("Display Name required");
        }
        if ($param['healthstatus'] === '') {
            throw new Exception("Health Status required");
        }
        if ($param['description'] === '') {
            throw new Exception("Description required");
        }

        $health = new \plugins\model\health();
        $health->appidentifier = $param['appidentifier'];
        $health->displayname = $param['displayname'];
        $health->healthstatus = $param['healthstatus'];
        $health->description = $param['description'];
        if (isset($param['remark'])) {
            $health->remark = $param['remark'];
        }
        $health->created = $this->GetServerDateTime();
        $health->cuid = $this->user['id'];
        $health->dflag = 0;
        $health->save();

        $data['health'] = array(
            "id" => $health->id,
            "appidentifier" => $health->appidentifier,
            "displayname" => $health->displayname,
            "healthstatus" => $health->healthstatus,
            "description" => $health->description,
            "remark" => $health->remark
        );

        return $data;
    }

    /**
     * @param string $id1
     * @return mixed
     * @throws Exception
     */
    public function update($id1 = '')
    {
        if ($id1 === '') {
            throw new Exception("ID Data required");
        }

        $param = Request::JsonBody();
        if ($param['appidentifier'] === '') {
            throw new Exception("App Identifier required");
        }
        if ($param['displayname'] === '') {
            throw new Exception("Display Name required");
        }
        if ($param['healthstatus'] === '') {
            throw new Exception("Health Status required");
        }
        if ($param['description'] === '') {
            throw new Exception("Description required");
        }

        $health = new \plugins\model\health($id1);
        $health->appidentifier = $param['appidentifier'];
        $health->displayname = $param['displayname'];
        $health->healthstatus = $param['healthstatus'];
        $health->description = $param['description'];
        if (isset($param['remark'])) {
            $health->remark = $param['remark'];
        }
        $health->modified = $this->GetServerDateTime();
        $health->muid = $this->user['id'];
        $health->modify();

        $data['health'] = array(
            "id" => $health->id,
            "appidentifier" => $health->appidentifier,
            "displayname" => $health->displayname,
            "healthstatus" => $health->healthstatus,
            "description" => $health->description,
            "remark" => $health->remark
        );

        return $data;
    }

    /**
     * @param string $id1
     * @return mixed
     * @throws Exception
     */
    public function delete($id1 = '')
    {
        if ($id1 === '') {
            throw new Exception("ID Data required");
        }

        $health = new \plugins\model\health($id1);
        $health->modified = $this->GetServerDateTime();
        $health->muid = $this->user['id'];
        $health->dflag = 1;
        $health->modify();

        $data['deleted'] = true;

        return $data;
    }

}