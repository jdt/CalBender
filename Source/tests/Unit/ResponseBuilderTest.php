<?php
namespace Tests\Unit\Controller;

use AppBundle\Controller\ResponseBuilder;

class ResponseBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $builder;

    public function setUp()
    {
        $this->builder = new ResponseBuilder();
    }

    public function testAsJsonShouldReturnJsonRequest()
    {
    	$data = array("test1" => "value1", "test2" => "value2");
    	$result = $this->builder->asJson($data);

    	$this->assertTrue($result->headers->contains("Content-Type", "application/json"));
    	$this->assertEquals('{"test1":"value1","test2":"value2"}', $result->getContent());
    }
}
