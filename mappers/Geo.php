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
            case \consultnn\api\Geo::TYPE_HOUSE:
                return 'geo\Building';
            case \consultnn\api\Geo::TYPE_SUB_LOCALITY:
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