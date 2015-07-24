<?php

namespace consultnn\api\mappers\geo;


use consultnn\api\mappers\Geo;

class Building extends Geo
{
    public $id;
    public $lon;
    public $lat;

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
    public $streetName;

    public function setStreetname($value)
    {
        $this->streetName = $value;
    }

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
        $address = $value;
        if (empty($this->streetName) && !empty($this->village)) {
            $address = $this->village.', '.$value;
        }

        $this->name = $address;
    }

    public function setHouse($value)
    {
        $this->short_name = $this->house = $value;
    }
}