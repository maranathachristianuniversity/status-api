<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table storyboards
 * #PrimaryKey id
 */
class storyboards extends Model
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
     * #Column pagecode varchar(250)
     */
    var $pagecode = '';

    /**
     * #Column jsondata text
     */
    var $jsondata = '';

    /**
     * #Column remark text
     */
    var $remark = '';


    public static function Create($data)
    {
        return DBI::Prepare('storyboards')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('storyboards')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare('SELECT * FROM storyboards')->GetData();
    }

}