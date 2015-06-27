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

        return $this;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        $current = $this->_iteratorCurrent;

        return $this->$current;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->_iteratorCurrent = array_shift($this->_iteratorPositions);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->_iteratorCurrent;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return !empty($this->_iteratorPositions);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
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
