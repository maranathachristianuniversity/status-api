<?php

use PHPUnit\Framework\TestCase;
use pukoframework\config\Factory;
use pukoframework\Framework;

class healthModelTest extends TestCase
{

    protected $framework;

    protected function setUp()
    {
        $factory = array(
            'base' => $_SERVER['HTTP_HOST'],
            'root' => $_ENV['BASEDIR'],
            'start' => microtime(true)
        );
        $fo = new Factory($factory);
        $this->framework = new Framework($fo);
    }

    public function testGetData()
    {

    }

    public function testGetById()
    {

    }

    public function testIsExists()
    {

    }

    public function testIsExistsWhere()
    {

    }

    public function testGetDataSize()
    {

    }

    public function testGetDataSizeWhere()
    {

    }

    public function testGetCreator()
    {

    }

    public function testGetCreated()
    {

    }

    public function testGetLastData()
    {

    }

    public function testSearchData()
    {

    }

    public function testDataTable()
    {

    }
}