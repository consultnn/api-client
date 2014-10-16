<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 16.10.14
 * Time: 19:01
 */

namespace consultnn\api\mappers;

/**
 *
 * Class SubLocality
 * @package consultnn\api\mappers
 */
class SubLocality extends AbstractMapper
{
    public $id;
    public $name;
    public $geometry;
    public $short_name;
    public $type;
    public $locality_id;

    public function setSub_locality_id($value)
    {
        $this->id = $value;
    }
}