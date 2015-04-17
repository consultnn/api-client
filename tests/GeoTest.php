<?php

namespace consultnn\api\tests;


use consultnn\api\Geo;

class GeoTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Rubric
     */
    private $_rubric;

    public function setUp()
    {
        parent::setUp();
        $this->_rubric = new Geo();
    }


    public function testGet()
    {
        $building = $this->_rubric->get(1);
        $this->assertTrue(
            $building instanceof \consultnn\api\mappers\geo\Building,
            'Each value must be instance of Building'
        );
    }
}
