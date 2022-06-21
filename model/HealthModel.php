<?php
/**
 * Created by PhpStorm.
 * User: Vinza
 * Date: 07-Dec-18
 * Time: 3:48 PM
 */

namespace model;

use Exception;
use DateTime;
use plugins\model\health;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;

/**
 * Class HealthModel
 * @package model
 */
class HealthModel extends health implements ModelContracts
{

    /**
     * @return array
     * @throws Exception
     */
    public static function GetData()
    {
        $sql = "SELECT id, appidentifier, displayname, healthstatus, description, remark
                FROM health
                WHERE dflag = 0
                ORDER BY id ASC";
        return DBI::Prepare($sql)->GetData();
    }

    /**
     * @param $id
     * @return array
     * @throws Exception
     */
    public static function GetById($id)
    {
        $sql = "SELECT id, appidentifier, displayname, healthstatus, description, remark
                FROM health
                WHERE dflag = 0
                AND id = @1
                ORDER BY id ASC";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public static function IsExists($id)
    {
        $sql = "SELECT id, appidentifier, displayname, healthstatus, description, remark
                FROM health
                WHERE dflag = 0
                AND id = @1
                ORDER BY id ASC";
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
     * @throws Exception
     */
    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id, appidentifier, displayname, healthstatus, description, remark
                                FROM health
                                WHERE dflag = 0
                                AND %s = @1
                                ORDER BY id ASC", $column);
        $data = DBI::Prepare($sql)->GetData($value);

        if (sizeof($data) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @return int
     * @throws Exception
     */
    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) FROM health WHERE dflag = 0";
        $data = DBI::Prepare($sql)->FirstRow();

        return (int)$data['data'];
    }

    /**
     * @param array $condition
     * @return int
     * @throws Exception
     */
    public static function GetDataSizeWhere($condition = array())
    {
        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND %s='%s'", $column, $values);
        }
        $sql = sprintf("SELECT COUNT(id) FROM health WHERE dflag=0 %s", $strings);
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
     * @throws Exception
     */
    public static function GetCreated($id)
    {
        return new DateTime();
    }

    /**
     * @return mixed|null
     * @throws Exception
     */
    public static function GetLastData()
    {
        $sql = "SELECT id, appidentifier, displayname, healthstatus, description, remark
                FROM health
                WHERE dflag = 0
                ORDER BY id DESC";
        return DBI::Prepare($sql)->FirstRow();
    }

    /**
     * @param array $keyword
     * @return array
     * @throws Exception
     */
    public static function SearchData($keyword = array())
    {
        $strings = "";
        foreach ($keyword as $column => $values) {
            $strings .= sprintf("AND %s='%s'", $column, $values);
        }
        $sql = sprintf("SELECT id, appidentifier, displayname, healthstatus, description, remark
                                FROM health
                                WHERE dflag = 0 %s
                                ORDER BY id ASC", $strings);
        return DBI::Prepare($sql)->GetData();
    }

    /**
     * @param array $condition
     * @return array|mixed
     * @throws Exception
     */
    public static function GetDataTable($condition = array())
    {
        $table = new DataTables(DataTables::POST);
        $table->SetColumnSpec(array(
            "appidentifier",
            "displayname",
            "healthstatus",
            "description",
            "remark",
            "id"
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf("AND %s='%s'", $column, $values);
        }
        $sql = sprintf("SELECT id, appidentifier, displayname, healthstatus, description, remark
                                FROM health
                                WHERE dflag = 0 %s
                                ORDER BY id ASC", $strings);
        $table->SetQuery($sql);

        return $table->GetDataTables(function ($result) {
            foreach ($result as $key => $val) {
                $result[$key] = $val;
            }
            return $result;
        });
    }
}
