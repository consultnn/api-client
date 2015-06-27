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

    public function testExtraFieldsExists()
    {
        $getTestedCompanies = function(){
            $restaurant = $this->company->search(null, null, ['rubric_ids' => '55804ecd8f447001008b472f'], ['by-type']);
            $shoppingCenter = $this->company->search(null, null, ['rubric_ids' => '55804ecc8f447001008b4606'], ['by-type']);
            $medicalCenter = $this->company->search(null, null, ['rubric_ids' => '55804ece8f447001008b49ca'], ['by-type']);

            return [
                5 => current($restaurant),
                1 => current($shoppingCenter),
                6 => current($medicalCenter),
            ];
        };

        $hasAttributes = function($obj, $attributes){
            foreach ($attributes as $attribute) {
                if (!empty($obj->{$attribute})) {
                    return false;
                }
            }

            return true;
        };

        $mapAttributesByType = function($type){
            $attributes = [
                5 => [
                    'payment_method',
                    'wifi_info',
                    'playground_info',
                    'breakfast_info',
                    'delivery_info',
                    'cuisine',
                    'check',
                    'banquet_price',
                    'business_lunch_price',
                    'halls',
                    'infrastructure',
                    'service',
                    'entertainment'
                ],
                1 => [
                    'parking',
                    'parking_info',
                    'wifi_info',
                    'playground_info',
                    'infrastructure',
                ],
                6 => [
                    'payment_method',
                    'price_segment',
                    'price',
                ],
            ];

            return $attributes[$type];
        };

        foreach ($getTestedCompanies() as $type => $companyMapper) {
            $attributes = $mapAttributesByType($type);

            $this->assertTrue($hasAttributes($companyMapper, $attributes));
        }
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
