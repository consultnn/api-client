<?php

namespace consultnn\api\mappers ;

use consultnn\api\exceptions\Exception;

class MapperFactory
{
    /**
     * Custom class mappings
     * Ex.: 'Address' => '\MyCustomAddress',
     * @var array
     */
    private $maps = array();

    public function __construct(array $classMap = array())
    {
        $this->setClassMap($classMap);
    }

    public function setClassMap(array $classMap = array())
    {
        $this->maps = $classMap;
    }

    /**
     * @param $data
     * @param string $className
     * @return $this
     * @throws \consultnn\api\exceptions\Exception
     */
    public function map($data, $className = __CLASS__)
    {
        $className = $this->getClassName($className, $data);
        $object = new $className($this);
        if (!$object instanceof MapperInterface) {
            throw new Exception("$className must implement MapperInterface");
        }
        /* @var MapperInterface $object */
        return $object->populate($data);
    }

    /**
     * @param $name string|callable $name
     * @param null $data
     * @return string
     * @throws \consultnn\api\exceptions\Exception
     */
    public function getClassName($name, $data = null)
    {
        if (is_callable($name)) {
            return $this->getClassName(call_user_func($name, $data));
        } else {
            $className = isset($this->maps[$name]) ? $this->maps[$name] : '\\' . __NAMESPACE__ . '\\' . $name;
        }

        if (class_exists($className)) {
            return $className;
        }

        throw new Exception(
            "Undefined " . (is_callable($name) ? 'callable(' . print_r($name, true) .')' : "class " . $name)
        );
    }
}
