<?php

namespace consultnn\api\mappers\geo;

use consultnn\api\mappers\Geo;

/**
 *
 * Class SubLocality
 * @package consultnn\api\mappers
 */
class SubLocality extends Geo
{
    public $id;
    public $name;
    public $geometry;
    public $shortName;

    public function setSubLocalityId($value)
    {
        $this->id = $value;
    }
}