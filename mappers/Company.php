<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 31.07.14
 * Time: 20:56
 */

namespace consultnn\api\mappers;


use ReflectionClass;
use ReflectionProperty;

class Company extends AbstractMapper implements \Iterator
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
    private $_iteratorPositions;
    private $_iteratorCurrent;

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        return isset($this->_extra[$name]) ? $this->_extra[$name] : null;
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

        asort($this->_extra);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->{$this->_iteratorCurrent};
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->_iteratorCurrent = array_shift($this->_iteratorPositions);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        $key = $this->_iteratorCurrent;

        $this->_iteratorCurrent = null;

        return $key;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return !empty($this->_iteratorPositions) || !empty($this->_iteratorCurrent);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->_iteratorPositions = [];

        $reflect = new ReflectionClass($this);
        $props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($props as $prop) {
            $this->_iteratorPositions[] = $prop->getName();
        }

        if (!empty($this->_extra)) {
            $this->_iteratorPositions = array_unique(array_merge($this->_iteratorPositions, array_keys($this->_extra)));
        }

        $this->_iteratorCurrent = array_shift($this->_iteratorPositions);
    }
}
