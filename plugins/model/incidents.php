<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table incidents
 * #PrimaryKey id
 */
class incidents extends Model
{

    
    /**
     * #Column id int(11)
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
     * #Column idhealthstatus int(11)
     */
    var $idhealthstatus = 0;

    /**
     * #Column postdate datetime
     */
    var $postdate = null;

    /**
     * #Column message text
     */
    var $message = '';

    /**
     * #Column tag varchar(15)
     */
    var $tag = '';

    /**
     * #Column remark text
     */
    var $remark = '';


    public static function Create($data)
    {
        return DBI::Prepare('incidents')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('incidents')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare('SELECT * FROM incidents')->GetData();
    }

}