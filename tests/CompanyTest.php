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

    /**
     * @var Rubric
     */
    public $rubric;

    public function setUp()
    {
        parent::setUp();
        $this->company = new Company();
        $this->rubric = new Rubric();
    }

    public function testByRubrics()
    {
        $rubrics = array_map( function($rubric) { return $rubric->id;}, $this->rubric->all());
        $companies = $this->company->byRubricIds($rubrics, ['not_filial' => 1]);

        $this->assertTrue(is_array($companies));
        foreach ($companies as $company) {
            $this->assertTrue($company instanceof \consultnn\api\mappers\Company);
            $this->assertNotEmpty(array_intersect($rubrics, $company->rubrics));
            if (isset($company->branch->headOfficeId)) {
                $this->assertEquals($company->id, $company->branch->headOfficeId);
            }
        }
    }

    public function testBranches()
    {
        $company = $this->company->byRubricIds([], ['is_head_office' => true], 1, 1)[0];
        $this->assertTrue($company instanceof \consultnn\api\mappers\Company);

        $branches = $this->company->getBranches($company->id);
        $this->assertTrue(is_array($branches));
        foreach ($branches as $branch) {
            $this->assertTrue($branch instanceof \consultnn\api\mappers\Company);
            $this->assertEquals($company->id, $branch->branch->headOfficeId);
        }
    }

}
