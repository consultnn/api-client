<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 31.07.14
 * Time: 20:43
 */

namespace consultnn\api\tests;


use consultnn\api\Company;

class CompanyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Company
     */
    public $company;

    public function setUp()
    {
        parent::setUp();
        $this->company = new Company();
    }

    public function testByRubrics()
    {
        $rubrics = [348, 355];
        $companies = $this->company->byRubricIds($rubrics);
        $this->assertTrue(is_array($companies));

        foreach ($companies as $company) {
            $this->assertTrue($company instanceof \consultnn\api\mappers\Company);
            $this->assertNotEmpty(array_intersect($rubrics, $company->rubrics));
        }
    }
}
