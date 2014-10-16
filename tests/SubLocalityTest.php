<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 16.10.14
 * Time: 19:06
 */

namespace consultnn\api\tests;


use consultnn\api\SubLocality;

class SubLocalityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SubLocality
     */
    public $sub_locality;

    public function setUp()
    {
        parent::setUp();
        $this->sub_locality = new SubLocality();
    }

    public function testAll()
    {
        $subLocalities = $this->sub_locality->all();
        $this->assertTrue(is_array($subLocalities), 'SubLocality is array');
        $this->assertNotEmpty($subLocalities, 'SubLocality not empty');

        foreach ($subLocalities as $subLocality) {
            $this->assertTrue(
                $subLocality instanceof \consultnn\api\mappers\SubLocality,
                'Each value must be instance of SubLocality'
            );
            $this->assertTrue(
                is_int($subLocality->id),
                'set id from sub_locality_id'
            );
        }
    }
} 