<?php

namespace consultnn\api\tests;

use consultnn\api\Company;

class ExtraFieldsExistsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Company
     */
    public $company;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->company = new Company();
    }

    /**
     * Data provider
     * @return array
     */
    public function provider()
    {
        self::setUp();

        $provider = [];
        foreach ($this->getTestedCompanies() as $type => $companyMapper) {

            $attributes = $this->mapAttributesByType($type);

            $provider[] = [$companyMapper, $attributes];
        }

        return $provider;
    }

    /**
     * @dataProvider provider
     * @param Company $mapper
     * @param string[] $attributes
     */
    public function testIndex($mapper, $attributes)
    {
        $this->assertTrue($this->hasAttributes($mapper, $attributes));
    }

    function getTestedCompanies() {
        $restaurant = $this->company->search(null, null, ['rubric_ids' => '55804ecd8f447001008b472f'], ['by-type']);
        $shoppingCenter = $this->company->search(null, null, ['rubric_ids' => '55804ecc8f447001008b4606'], ['by-type']);
        $medicalCenter = $this->company->search(null, null, ['rubric_ids' => '55804ece8f447001008b49ca'], ['by-type']);

        return [
            5 => current($restaurant),
            1 => current($shoppingCenter),
            6 => current($medicalCenter),
        ];
    }

    function mapAttributesByType($type){
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
    }

    function hasAttributes($obj, $attributes){
        foreach ($attributes as $attribute) {
            if (!empty($obj->{$attribute})) {
                return false;
            }
        }

        return true;
    }
}