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
    public $oldId;
    public $name;
    public $type;
    public $chain;
    public $rubrics;
    public $phones;
    public $address;
    public $internet;
    public $schedule;
    public $sphere;

    private $_extra;

    public function __get($name)
    {
        return isset($this->_extra[$name]) ? $this->_extra[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->_extra[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function populate(array $data)
    {
        foreach ($data as $key => $value) {
            $propertyName = self::keyToMethodName($key);
            $methodName = 'set' . ucfirst($propertyName);
            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            } elseif (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            } else {
                $this->_extra[$key] = $value;
            }
        }
        return $this;
    }
}
