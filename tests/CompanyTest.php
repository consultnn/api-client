<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 31.07.14
 * Time: 20:43
 */

namespace consultnn\api\tests;


use consultnn\api\Company;
use consultnn\api\Rubric;

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
        $companies = $this->company->search();

        $this->assertTrue(is_array($companies));
        foreach ($companies as $company) {
            $this->assertTrue($company instanceof \consultnn\api\mappers\Company);
        }
    }

    /**
     * @depends testByRubrics
     */
    public function testById()
    {
        $NeededCompany = current($this->company->search());
        $company = $this->company->getById($NeededCompany->id);

        $this->assertTrue($company instanceof \consultnn\api\mappers\Company);
        $this->assertEquals($company, $NeededCompany);
    }


    /**
     * @expectedException \consultnn\api\exceptions\ConnectionException
     * @expectedExceptionCode 404
     */
    public function testFakeId()
    {
        $this->company->getById('aaaaaaaaaaaaaaaaaaaaaaaa');
    }

    /**
     * @depends testById
     */
    public function testExpand()
    {
        $NeededCompany = current($this->company->search());
        $emptyCompany = $this->company->getById($NeededCompany->id);
        $fullCompany = $this->company->getById($NeededCompany->id, ['phones', 'internet', 'schedule', 'sphere', 'type']);
        $this->assertNotEquals($emptyCompany, $fullCompany);
    }

}
