<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 14.04.15
 * Time: 18:43
 */

namespace consultnn\api\mappers\geo;


use consultnn\api\mappers\Geo;

class Building extends Geo
{
    public $id;
    public $coordinates;

    public $name;
    public $short_name;

    public $district;
    public $locality;
    public $subLocality;
    public $village;
    public $street;
    public $house;
    public $altStreet;
    public $altHouse;

    public function setVillageName($value)
    {
        $this->village = $value;
    }

    public function setSubLocalityName($value)
    {
        $this->subLocality = $value;
    }

    public function setLocalityName($value)
    {
        $this->locality = $value;
    }

    public function setDistrictName($value)
    {
        $this->district = $value;
    }


    public function setAltStreetName($name)
    {
        $this->altStreet = $name;
    }

    public function setAddress($value)
    {
        $this->name = $value;
    }

    public function setHouse($value)
    {
        $this->short_name = $this->house = $value;
    }
}