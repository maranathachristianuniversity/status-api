<?php

namespace controller;

use Exception;
use model\HealthModel;
use model\HealthStatusModel;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * Class notify
 * @package controller
 * #Template html false
 */
class notify extends Service
{
    /**
     * @param string $id1
     * @return mixed
     * @throws Exception
     */
    public function notifyerror($id1 = '')
    {
        if ($id1 === '') {
            throw new Exception("ID Data required");
        }

        $health = HealthModel::SearchData(array(
            'appidentifier' => $id1
        ));

        $idhealth = $health['0']['id'];

        $isExist = HealthStatusModel::SearchData(array(
            "s.idhealth" => $idhealth,
            "s.isresolved" => 0
        ));

        $param = Request::JsonBody();

        if (sizeof($isExist) > 0) {
            if ($param['attachments'] === '' || $param['attachments'] === null) {
                throw new Exception("Attachments kosong");
            }

            $healthstatus = new \plugins\model\healthstatus($isExist[0]['id']);
            $healthstatus->problem = json_encode($param['attachments']);
            $healthstatus = new \plugins\model\healthstatus($isExist[0]['id']);
            $healthstatus->iteration = $healthstatus->iteration + 1;
            $healthstatus->modified = $this->GetServerDateTime();
            $healthstatus->modify();

            $health = new \plugins\model\health($healthstatus->idhealth);
            if ($healthstatus->iteration > 10) {
                $health->healthstatus = 'warning';
            }
            if ($healthstatus->iteration > 100) {
                $health->healthstatus = 'error';
            }
            $health->modify();

            $data['healthstatus'] = array(
                "id" => $healthstatus->id,
                "idhealth" => $healthstatus->idhealth,
                "iteration" => $healthstatus->iteration,
                "problem" => $healthstatus->problem,
                "isresolved" => $healthstatus->isresolved
            );
        } else {
            if ($param['attachments'] === '' || $param['attachments'] === null) {
                throw new Exception("Attachments kosong");
            }

            $healthstatus = new \plugins\model\healthstatus();
            $healthstatus->idhealth = $idhealth;
            $healthstatus->problem = json_encode($param['attachments']);
            $healthstatus->iteration = 1;
            $healthstatus->created = $this->GetServerDateTime();
            $healthstatus->save();

            $data['healthstatus'] = array(
                "id" => $healthstatus->id,
                "idhealth" => $healthstatus->idhealth,
                "iteration" => $healthstatus->iteration,
                "problem" => $healthstatus->problem,
                "isresolved" => $healthstatus->isresolved
            );
        }

        return $data;
    }

}