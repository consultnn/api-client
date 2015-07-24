<?php

namespace consultnn\api\mappers\geo;


use consultnn\api\mappers\Geo;

class Building extends Geo
{
    public $id;
    public $lon;
    public $lat;

    public $name;
    public $shortName;

    public $district;
    public $locality;
    public $subLocality;
    public $village;
    public $street;
    public $house;
    public $altStreet;
    public $altHouse;

    public function setAddress($value)
    {
        $address = $value;
        if (empty($this->street)) {
            $address = $this->village.', '.$value;
        }
        $this->name = $address;
    }

    public function setHouse($value)
    {
        $this->shortName = $this->house = $value;
    }
}