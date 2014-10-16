<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 01.08.14
 * Time: 9:48
 */

namespace consultnn\api\mappers;


class Address extends AbstractMapper
{
    public $id;
    public $lon;
    public $lat;
    public $name;
    public $sub_locality_id;
}
