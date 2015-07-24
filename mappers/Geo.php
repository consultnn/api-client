<?php

namespace consultnn\api\mappers;

use consultnn\api\exceptions\Exception;

class Geo extends AbstractMapper
{
    public $type;

    public static function geoMapResolver($data)
    {
        if (!isset($data['source'])) {
            throw new Exception("Can't resolve mapper because of property 'source' not found in data");
        }

        switch ($data['source']) {
            case 'house':
                return 'geo\Building';
            case 'sub_locality';
                return 'geo\SubLocality';
            default:
                return 'Geo';
        }
    }

    public function setSource($value)
    {
        $this->type = $value;
    }

}