<?php
/**
 * Created by PhpStorm.
 * User: Vinza
 * Date: 10-Dec-18
 * Time: 7:57 AM
 */

namespace model;

use DateTime;
use plugins\model\incidents;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;

/**
 * Class IncidentsModel
 * @package model
 */
class IncidentsModel extends incidents implements ModelContracts
{

    /**
     * @return array
     * @throws \Exception
     */
    public static function GetData()
    {
        $sql = "SELECT i.id, i.idhealthstatus, i.postdate, i.message, i.remark, i.tag, s.problem, s.isresolved,
                h.appidentifier, h.displayname
                FROM incidents i
                LEFT JOIN healthstatus s
                ON i.idhealthstatus = s.id
                LEFT JOIN health h
                ON s.idhealth = h.id
                WHERE i.dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    /**
     * @param $id
     * @return array|mixed|null
     * @throws \Exception
     */
    public static function GetById($id)
    {
        $sql = "SELECT i.id, i.idhealthstatus, i.postdate, i.message, i.remark, i.tag, s.problem, s.isresolved,
                h.appidentifier, h.displayname
                FROM incidents i
                LEFT JOIN healthstatus s
                ON i.idhealthstatus = s.id
                LEFT JOIN health h
                ON s.idhealth = h.id
                WHERE i.dflag = 0
                AND i.id = @1
                ORDER BY i.postdate DESC";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public static function IsExists($id)
    {
        $sql = "SELECT i.id, i.idhealthstatus, i.postdate, i.message, i.remark, i.tag, s.problem, s.isresolved,
                h.appidentifier, h.displayname
                FROM incidents i
                LEFT JOIN healthstatus s
                ON i.idhealthstatus = s.id
                LEFT JOIN health h
                ON s.idhealth = h.id
                WHERE i.dflag = 0
                AND i.id = @1
                ORDER BY i.postdate DESC";
        $data = DBI::Prepare($sql)->GetData($id);

        if (sizeof($data) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param $column
     * @param $value
     * @return bool
     * @throws \Exception
     */
    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT i.id, i.idhealthstatus, i.postdate, i.message, i.remark, i.tag, s.problem, s.isresolved,
                                h.appidentifier, h.displayname
                                FROM incidents i
                                LEFT JOIN healthstatus s
                                ON i.idhealthstatus = s.id
                                LEFT JOIN health h
                                ON s.idhealth = h.id
                                WHERE i.dflag = 0
                                AND %s = @1
                                ORDER BY i.postdate DESC", $column);
        $data = DBI::Prepare($sql)->GetData($value);

        if (sizeof($data) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) FROM incidents WHERE dflag = 0";
        $data = DBI::Prepare($sql)->FirstRow();

        return (int)$data['data'];
    }

    /**
     * @param array $condition
     * @return int|mixed
     * @throws \Exception
     */
    public static function GetDataSizeWhere($condition = array())
    {
        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND %s='%s'", $column, $values);
        }
        $sql = sprintf("SELECT COUNT(id) FROM incidents WHERE dflag=0 %s", $strings);
        $data = DBI::Prepare($sql)->FirstRow();

        return (int)$data['data'];
    }

    /**
     * This method return the creator of the data
     * @param $id
     * @return string
     */
    public static function GetCreator($id)
    {
        return 0;
    }

    /**
     * @param $id
     * @return DateTime|mixed
     * @throws \Exception
     */
    public static function GetCreated($id)
    {
        return new DateTime();
    }

    /**
     * @return mixed|null
     * @throws \Exception
     */
    public static function GetLastData()
    {
        $sql = "SELECT i.id, i.idhealthstatus, i.postdate, i.message, i.remark, i.tag, s.problem, s.isresolved,
                h.appidentifier, h.displayname
                FROM incidents i
                LEFT JOIN healthstatus s
                ON i.idhealthstatus = s.id
                LEFT JOIN health h
                ON s.idhealth = h.id
                WHERE i.dflag = 0
                ORDER BY i.id DESC";
        return DBI::Prepare($sql)->FirstRow();
    }

    /**
     * @param array $keyword
     * @return array|mixed
     * @throws \Exception
     */
    public static function SearchData($keyword = array())
    {
        $strings = "";
        foreach ($keyword as $column => $values) {
            $strings .= sprintf("AND %s='%s'", $column, $values);
        }
        $sql = sprintf("SELECT i.id, i.idhealthstatus, i.postdate, i.message, i.remark, i.tag, s.problem, s.isresolved,
                                h.appidentifier, h.displayname
                                FROM incidents i
                                LEFT JOIN healthstatus s
                                ON i.idhealthstatus = s.id
                                LEFT JOIN health h
                                ON s.idhealth = h.id
                                WHERE i.dflag = 0 %s
                                ORDER BY i.postdate DESC", $strings);
        return DBI::Prepare($sql)->GetData();
    }

    /**
     * @param array $condition
     * @return array|mixed
     * @throws \pukoframework\peh\PukoException
     */
    public static function GetDataTable($condition = array())
    {
        $table = new DataTables(DataTables::POST);
        $table->SetColumnSpec(array(
            "idhealthstatus",
            "postdate",
            "message",
            "tag",
            "remark",
            "problem",
            "isresolved",
            "appidentifier",
            "displayname",
            "id"
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf("AND %s='%s'", $column, $values);
        }
        $sql = sprintf("SELECT i.id, i.idhealthstatus, i.postdate, i.message, i.remark, i.tag, s.problem, s.isresolved,
                                h.appidentifier, h.displayname
                                FROM incidents i
                                LEFT JOIN healthstatus s
                                ON i.idhealthstatus = s.id
                                LEFT JOIN health h
                                ON s.idhealth = h.id
                                WHERE i.dflag = 0 %s
                                ORDER BY i.postdate DESC", $strings);
        $table->SetQuery($sql);

        return $table->GetDataTables(function ($result) {
            foreach ($result as $key => $val) {
                $postdate = DateTime::createFromFormat('Y-m-d H:i:s', $val['postdate']);
                $val['postdate'] = $postdate->format('d/m/Y H:i');

                $result[$key] = $val;
            }
            return $result;
        });
    }
}
