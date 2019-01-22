<?php
/**
 * Created by PhpStorm.
 * User: Vinza
 * Date: 07-Dec-18
 * Time: 3:48 PM
 */

namespace model;

use DateTime;
use plugins\model\healthstatus;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;

/**
 * Class HealthStatusModel
 * @package model
 */
class HealthStatusModel extends healthstatus implements ModelContracts
{

    /**
     * @return array
     * @throws \Exception
     */
    public static function GetData()
    {
        $sql = "SELECT s.id, s.idhealth, s.iteration, s.problem, s.isresolved, h.appidentifier
                FROM healthstatus s
                LEFT JOIN health h
                ON s.idhealth = h.id
                WHERE s.dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    /**
     * @param $id
     * @return array|mixed|null
     * @throws \Exception
     */
    public static function GetById($id)
    {
        $sql = "SELECT s.id, s.idhealth, s.iteration, s.problem, s.isresolved, h.appidentifier
                FROM healthstatus s
                LEFT JOIN health h
                ON s.idhealth = h.id
                WHERE s.dflag = 0
                AND s.id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public static function IsExists($id)
    {
        $sql = "SELECT s.id, s.idhealth, s.iteration, s.problem, s.isresolved, h.appidentifier
                FROM healthstatus s
                LEFT JOIN health h
                ON s.idhealth = h.id
                WHERE s.dflag = 0
                AND s.id = @1";
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
        $sql = sprintf("SELECT s.id, s.idhealth, s.iteration, s.problem, s.isresolved, h.appidentifier
                                FROM healthstatus s
                                LEFT JOIN health h
                                ON s.idhealth = h.id
                                WHERE s.dflag = 0
                                AND %s = @1", $column);
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
        $sql = "SELECT COUNT(id) FROM healthstatus WHERE dflag = 0";
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
        $sql = sprintf("SELECT COUNT(id) FROM healthstatus WHERE dflag=0 %s", $strings);
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
        $sql = "SELECT s.id, s.idhealth, s.iteration, s.problem, s.isresolved, h.appidentifier
                FROM healthstatus s
                LEFT JOIN health h
                ON s.idhealth = h.id
                WHERE s.dflag = 0
                ORDER BY s.id DESC";
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
        $sql = sprintf("SELECT s.id, s.idhealth, s.iteration, s.problem, s.isresolved, h.appidentifier
                                FROM healthstatus s
                                LEFT JOIN health h
                                ON s.idhealth = h.id
                                WHERE s.dflag = 0 %s", $strings);
        return DBI::Prepare($sql)->GetData();
    }

    /**
     * @param array $condition
     * @return array|mixed
     * @throws \pukoframework\cache\CacheException
     * @throws \pukoframework\peh\PukoException
     */
    public static function GetDataTable($condition = array())
    {
        $table = new DataTables(DataTables::POST);
        $table->SetColumnSpec(array(
            "idhealth",
            "iteration",
            "problem",
            "isresolved",
            "remark",
            "appidentifier",
            "id"
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf("AND %s='%s'", $column, $values);
        }
        $sql = sprintf("SELECT s.id, s.idhealth, s.iteration, s.problem, s.isresolved, h.appidentifier
                                FROM healthstatus s
                                LEFT JOIN health h
                                ON s.idhealth = h.id
                                WHERE s.dflag = 0 %s", $strings);
        $table->SetQuery($sql);

        return $table->GetDataTables(function ($result) {
            foreach ($result as $key => $val) {
                $result[$key] = $val;
            }
            return $result;
        });
    }
}