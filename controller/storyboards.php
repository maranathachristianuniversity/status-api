<?php

namespace controller;

use Exception;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * Class storyboards
 * @package controller
 * #Template html false
 */
class storyboards extends Service
{
    use UserBearerData;

    /**
     * @return mixed
     * @throws Exception
     */
    public function create()
    {
        $pagecode = Request::Post('pagecode', '');
        if ($pagecode === '') {
            throw new Exception("Page Code required");
        }
        $jsondata = Request::Post('jsondata', '');
        if ($jsondata === '') {
            throw new Exception("JSON Data required");
        }

        $storyboards = new \plugins\model\storyboards();
        $storyboards->pagecode = $pagecode;
        $storyboards->jsondata = json_encode($jsondata);
        $storyboards->created = $this->GetServerDateTime();
        $storyboards->cuid = $this->user['id'];
        $storyboards->dflag = 0;
        $storyboards->save();

        $data['storyboards'] = array(
            "id" => $storyboards->id,
            "pagecode" => $storyboards->pagecode,
            "jsondata" => $storyboards->jsondata,
            "remark" => $storyboards->remark
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

        $pagecode = Request::Post('pagecode', '');
        if ($pagecode === '') {
            throw new Exception("Page Code required");
        }
        $jsondata = Request::Post('jsondata', '');
        if ($jsondata === '') {
            throw new Exception("JSON Data required");
        }

        $storyboards = new \plugins\model\storyboards($id1);
        $storyboards->pagecode = $pagecode;
        $storyboards->jsondata = json_encode($jsondata);
        $storyboards->modified = $this->GetServerDateTime();
        $storyboards->muid = $this->user['id'];
        $storyboards->modify();

        $data['storyboards'] = array(
            "id" => $storyboards->id,
            "pagecode" => $storyboards->pagecode,
            "jsondata" => $storyboards->jsondata,
            "remark" => $storyboards->remark
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

        $storyboards = new \plugins\model\storyboards($id1);
        $storyboards->modified = $this->GetServerDateTime();
        $storyboards->muid = $this->user['id'];
        $storyboards->dflag = 1;
        $storyboards->modify();

        $data['deleted'] = true;

        return $data;
    }

}
