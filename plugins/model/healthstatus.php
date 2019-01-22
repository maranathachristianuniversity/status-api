<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table healthstatus
 * #PrimaryKey id
 */
class healthstatus extends Model
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
     * #Column idhealth int(11)
     */
    var $idhealth = 0;

    /**
     * #Column iteration int(11)
     */
    var $iteration = 0;

    /**
     * #Column problem varchar(250)
     */
    var $problem = '';

    /**
     * #Column isresolved tinyint(1)
     */
    var $isresolved = 0;

    /**
     * #Column remark text
     */
    var $remark = '';


    public static function Create($data)
    {
        return DBI::Prepare('healthstatus')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('healthstatus')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare('SELECT * FROM healthstatus')->GetData();
    }

}