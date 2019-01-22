<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table health
 * #PrimaryKey id
 */
class health extends Model
{

    
    /**
     * #Column id int(11) unsigned
     */
    var $id = 0;

    /**
     * #Column created datetime
     */
    var $created = null;

    /**
     * #Column modified timestamp
     */
    var $modified = null;

    /**
     * #Column cuid int(11)
     */
    var $cuid = 0;

    /**
     * #Column muid int(11)
     */
    var $muid = 0;

    /**
     * #Column dflag tinyint(1)
     */
    var $dflag = 0;

    /**
     * #Column appidentifier varchar(50)
     */
    var $appidentifier = '';

    /**
     * #Column displayname varchar(250)
     */
    var $displayname = '';

    /**
     * #Column healthstatus varchar(50)
     */
    var $healthstatus = '';

    /**
     * #Column description text
     */
    var $description = '';

    /**
     * #Column remark text
     */
    var $remark = '';


    public static function Create($data)
    {
        return DBI::Prepare('health')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('health')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare('SELECT * FROM health')->GetData();
    }

}