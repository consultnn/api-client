<?php

namespace consultnn\api\mappers;

/**
 * Class Rubric
 * @package consultnn\api\mappers
 * @property int $id
 * @property string $name
 * @property int level
 * @property int $parentId
 */
class Rubric extends AbstractMapper
{
    public $id;
    public $name;
    public $oldId;
    public $level;

    public function setRubricId($value)
    {
        $this->id = $value;
    }
}
