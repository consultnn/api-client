<?php

namespace consultnn\api\mappers;

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
    public $short_name;
    public $type;
    public $locality_id;

    public function setSubLocalityId($value)
    {
        $this->id = $value;
    }
}