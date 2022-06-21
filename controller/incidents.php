<?php

namespace controller;

use DateTime;
use Exception;
use model\HealthStatusModel;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * Class incidents
 * @package controller
 * #Template html false
 */
class incidents extends Service
{

    use UserBearerData;

    /**
     * @return mixed
     * @throws Exception
     */
    public function create()
    {
        $param = Request::JsonBody();
        if ($param['idhealthstatus'] === '') {
            throw new Exception("Health Status ID required");
        }
        if ($param['postdate'] === '') {
            throw new Exception("Post Date required");
        }
        if ($param['message'] === '') {
            throw new Exception("Message required");
        }
        if ($param['tag'] === '') {
            throw new Exception("Tag required");
        }

        $postdate = DateTime::createFromFormat('d/m/Y H:i', $param['postdate']);
        if (!$postdate instanceof DateTime) {
            throw new Exception("Post date format must be dd/mm/yyyy HH:MM");
        }

        $incidents = new \plugins\model\incidents();
        $incidents->idhealthstatus = $param['idhealthstatus'];
        $incidents->postdate = $postdate->format('Y-m-d H:i');
        $incidents->message = $param['message'];
        $incidents->tag = $param['tag'];
        if (isset($param['remark'])) {
            $incidents->remark = $param['remark'];
        }
        $incidents->created = $this->GetServerDateTime();
        $incidents->cuid = $this->user['id'];
        $incidents->dflag = 0;
        $incidents->save();

        $postdate = DateTime::createFromFormat('Y-m-d H:i:s', $incidents->postdate)->format('d/m/Y H:i');
        $data['incidents'] = array(
            "id" => $incidents->id,
            "healthstatus" => HealthStatusModel::GetById($incidents->idhealthstatus),
            "postdate" => $postdate,
            "message" => $incidents->message,
            "tag" => $incidents->tag,
            "remark" => $incidents->remark
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
        if ($param['idhealthstatus'] === '') {
            throw new Exception("Health Status ID required");
        }
        if ($param['postdate'] === '') {
            throw new Exception("Post Date required");
        }
        if ($param['message'] === '') {
            throw new Exception("Message required");
        }
        if ($param['tag'] === '') {
            throw new Exception("Tag required");
        }

        $postdate = DateTime::createFromFormat('d/m/Y H:i', $param['postdate']);
        if (!$postdate instanceof DateTime) {
            throw new Exception("Post date format must be dd/mm/yyyy HH:MM");
        }

        $incidents = new \plugins\model\incidents($id1);
        $incidents->idhealthstatus = $param['idhealthstatus'];
        $incidents->postdate = $postdate->format('Y-m-d H:i');
        $incidents->message = $param['message'];
        $incidents->tag = $param['tag'];
        if (isset($param['remark'])) {
            $incidents->remark = $param['remark'];
        }
        $incidents->modified = $this->GetServerDateTime();
        $incidents->muid = $this->user['id'];
        $incidents->modify();

        $postdate = DateTime::createFromFormat('Y-m-d H:i:s', $incidents->postdate)->format('d/m/Y H:i');
        $data['incidents'] = array(
            "id" => $incidents->id,
            "healthstatus" => HealthStatusModel::GetById($incidents->idhealthstatus),
            "postdate" => $postdate,
            "message" => $incidents->message,
            "tag" => $incidents->tag,
            "remark" => $incidents->remark
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

        $incidents = new \plugins\model\incidents($id1);
        $incidents->modified = $this->GetServerDateTime();
        $incidents->muid = $this->user['id'];
        $incidents->dflag = 1;
        $incidents->modify();

        $data['deleted'] = true;

        return $data;
    }

}
