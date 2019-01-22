<?php

namespace controller;

use Exception;
use model\HealthModel;
use model\HealthStatusModel;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * Class healthstatus
 * @package controller
 * #Template html false
 */
class healthstatus extends Service
{
    use UserBearerData;

    /**
     * @return mixed
     * @throws Exception
     */
    public function create()
    {
        $idhealth = Request::Post('idhealth', "");
        $iteration = Request::Post('iteration', "");
        $problem = Request::Post('problem', "");
        $isresolved = Request::Post('isresolved', "");

        if ($idhealth === '') {
            throw new Exception("Health ID required");
        }
        if ($isresolved === '') {
            throw new Exception("Resolve status required");
        }

        $healthstatus = new \plugins\model\healthstatus();
        $healthstatus->idhealth = $idhealth;
        if ($iteration !== '') {
            $healthstatus->iteration = $iteration;
        }
        if ($problem !== '') {
            $healthstatus->problem = $problem;
        }
        $healthstatus->isresolved = $isresolved;
        $healthstatus->created = $this->GetServerDateTime();
        $healthstatus->cuid = $this->user['id'];
        $healthstatus->dflag = 0;
        $healthstatus->save();

        $data['healthstatus'] = array(
            "idhealthstatus" => $healthstatus->id,
            "health" => HealthModel::GetById($healthstatus->idhealth),
            "iteration" => $healthstatus->iteration,
            "problem" => $healthstatus->problem,
            "isresolved" => $healthstatus->isresolved
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

        $idhealth = Request::Post('idhealth', "");
        //$iteration = Request::Post('iteration', "");
        //$problem = Request::Post('problem', "");
        $isresolved = Request::Post('isresolved', "");

        if ($idhealth === '') {
            throw new Exception("Health ID required");
        }
        if ($isresolved === '') {
            throw new Exception("Resolve status required");
        }

        $healthstatus = new \plugins\model\healthstatus($id1);
        \plugins\model\healthstatus::Update(
            array('id' => $id1),
            array(
                'modified' => $this->GetServerDateTime(),
                'muid' => $this->user['id'],
                'iteration' => $healthstatus->iteration + 1,
                'isresolved' => $isresolved
            )
        );

        $healthstatus = new \plugins\model\healthstatus($id1);
        $data['healthstatus'] = array(
            "idhealthstatus" => $healthstatus->id,
            "health" => HealthModel::GetById($healthstatus->idhealth),
            "iteration" => $healthstatus->iteration,
            "problem" => $healthstatus->problem,
            "isresolved" => $healthstatus->isresolved
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

        $healthstatus = new \plugins\model\healthstatus($id1);
        $healthstatus->modified = $this->GetServerDateTime();
        $healthstatus->muid = $this->user['id'];
        $healthstatus->dflag = 1;
        $healthstatus->modify();

        $data['deleted'] = true;

        return $data;
    }

}