<?php

use PHPUnit\Framework\TestCase;

class incidentsControllerTest extends TestCase
{

    use \pukoconsole\util\TestingToolkit;

    protected $bearer;

    protected function setUp()
    {
        $this->bearer = "";
    }

    public function testCreate()
    {
        //example creating test schema
        /*
        $response = $this->SendRequest(
            $this->bearer,
            "http://localhost:5000/access/create",
            "POST",
            "JSON",
            array(
                'iduser' => 1,
                'idauthorization' => 1,
                'validuntil' => '10/10/2022',

            ));
        $this->assertNotNull($response);
        $this->WriteDocs(array(
            'name' => "access",
            'url' => "access/create",
            'method' => "POST",
            'dataType' => 'json',
            'data' => array(
                'iduser' => 1,
                'idauthorization' => 1,
                'validuntil' => '10/10/2022',
            )
        ), $response);
        */
    }

    public function testUpdate()
    {
    }

    public function testDelete()
    {
    }

    public function testRead()
    {
    }

}