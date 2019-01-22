<?php

namespace controller;

use DateTime;
use model\HealthModel;
use model\HealthStatusModel;
use model\IncidentsModel;
use model\StoryBoardsModel;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * Class reader
 * @package controller
 * #Template html false
 */
class reader extends Service
{

    /**
     * @param string $id1
     * @return array|mixed
     * @throws \pukoframework\peh\PukoException
     * @throws \Exception
     */
    public function readHealth($id1 = '')
    {
        $data = array();

        if ($id1 === 'table') {
            $filter = array();
            $healthstatus = Request::Post('healthstatus', "");
            if ($healthstatus !== '') {
                $filter['healthstatus'] = $healthstatus;
            }
            return HealthModel::GetDataTable($filter);
        } else if ($id1 === 'search') {
            $keyword = array();
            $param = Request::JsonBody();
            if (isset($param['appidentifier'])) {
                $keyword['appidentifier'] = $param['appidentifier'];
            }
            if (isset($param['displayname'])) {
                $keyword['displayname'] = $param['displayname'];
            }
            if (isset($param['healthstatus'])) {
                $keyword['healthstatus'] = $param['healthstatus'];
            }
            try {
                $data['health'] = HealthModel::SearchData($keyword);
            } catch (\Exception $e) {
            }
        } else if ($id1 === 'select') {
            $data['health'] = HealthModel::GetData();
        } else {
            $health = new \plugins\model\health($id1);
            $data['health'] = array(
                "id" => $health->id,
                "appidentifier" => $health->appidentifier,
                "displayname" => $health->displayname,
                "healthstatus" => $health->healthstatus,
                "description" => $health->description,
                "remark" => $health->remark
            );
        }

        return $data;
    }

    /**
     * @param string $id1
     * @return array|mixed
     * @throws \pukoframework\cache\CacheException
     * @throws \pukoframework\peh\PukoException
     * @throws \Exception
     */
    public function readHealthStatus($id1 = '')
    {
        $data = array();

        if ($id1 === 'table') {
            $filter = array();
            $idhealth = Request::Post('healthstatus', "");
            if ($idhealth !== '') {
                $filter['s.idhealth'] = $idhealth;
            }
            $isresolved = Request::Post('isresolved', "");
            if ($isresolved !== '') {
                $filter['s.isresolved'] = $isresolved;
            }
            return HealthStatusModel::GetDataTable($filter);
        } else if ($id1 === 'search') {
            $keyword = array();
            $param = Request::JsonBody();
            if (isset($param['idhealth'])) {
                $keyword['s.idhealth'] = $param['idhealth'];
            }
            if (isset($param['isresolved'])) {
                $keyword['s.isresolved'] = $param['isresolved'];
            }
            $data['healthstatus'] = HealthStatusModel::SearchData($keyword);
        } else if ($id1 === 'select') {
            $data['healthstatus'] = HealthStatusModel::GetData();
        } else {
            $healthstatus = new \plugins\model\healthstatus($id1);
            $data['healthstatus'] = array(
                "idhealthstatus" => $healthstatus->id,
                "health" => HealthModel::GetById($healthstatus->idhealth),
                "iteration" => $healthstatus->iteration,
                "problem" => $healthstatus->problem,
                "isresolved" => $healthstatus->isresolved
            );
        }

        return $data;
    }

    /**
     * @param string $id1
     * @return array|mixed
     * @throws \pukoframework\peh\PukoException
     * @throws \Exception
     */
    public function readIncidents($id1 = '')
    {
        $data = array();

        if ($id1 === 'table') {
            return IncidentsModel::GetDataTable();
        } else if ($id1 === 'search') {
            $keyword = array();
            $param = Request::JsonBody();
            if (isset($param['idhealthstatus'])) {
                $keyword['i.idhealthstatus'] = $param['idhealthstatus'];
            }
            if (isset($param['isresolved'])) {
                $keyword['s.isresolved'] = $param['isresolved'];
            }
            $data['incidents'] = IncidentsModel::SearchData($keyword);
        } else if ($id1 === 'select') {
            $data['incidents'] = IncidentsModel::GetData();
        } else {
            $incidents = new \plugins\model\incidents($id1);

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

        return $data;
    }

    /**
     * @param string $id1
     * @return array|mixed
     * @throws \pukoframework\cache\CacheException
     * @throws \pukoframework\peh\PukoException
     * @throws \Exception
     */
    public function readStoryboards($id1 = '')
    {
        $data = array();

        if ($id1 === 'table') {
            return StoryBoardsModel::GetDataTable();
        } else if ($id1 === 'search') {
            $keyword = array();
            $param = Request::JsonBody();
            if (isset($param['pagecode'])) {
                $keyword['pagecode'] = $param['pagecode'];
            }
            $data['storyboards'] = StoryBoardsModel::SearchData($keyword);
        } else if ($id1 === 'select') {
            $data['storyboards'] = StoryBoardsModel::GetData();
        } else {
            $storyboards = new \plugins\model\storyboards($id1);
            $data['storyboards'] = array(
                "id" => $storyboards->id,
                "pagecode" => $storyboards->pagecode,
                "jsondata" => $storyboards->jsondata,
                "remark" => $storyboards->remark
            );
        }

        return $data;
    }

}