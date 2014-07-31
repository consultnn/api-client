<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 31.07.14
 * Time: 17:59
 */

namespace consultnn\api\tests;


use consultnn\api\Rubric;

class RubricTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Rubric
     */
    public $rubric;

    public function setUp()
    {
        parent::setUp();
        $this->rubric = new Rubric();
    }


    public function testAll()
    {
        $rubrics = $this->rubric->all();
        $this->assertTrue(is_array($rubrics), 'Rubrics is array');
        $this->assertNotEmpty($rubrics, 'Rubrics not empty');

        foreach ($rubrics as $rubric) {
            $this->assertTrue($rubric instanceof \consultnn\api\mappers\Rubric, 'Each value must be instance of Rubric');
        }
        var_dump($rubric);
    }

}
