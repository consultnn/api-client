<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 31.07.14
 * Time: 20:56
 */

namespace consultnn\api\mappers;


class Company extends AbstractMapper
{
    public $id;
    public $name;
    public $rubrics;

    public function setRubric($value)
    {
        $this->rubrics = $value;
    }

} 