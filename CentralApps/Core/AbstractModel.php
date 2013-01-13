<?php
namespace CentralApps\Core;

abstract class AbstractModel
{
    public function __set($name, $value)
    {
        $name = str_replace('_', ' ', $name);
        $setter = 'set' . str_replace(' ','', ucwords($name));
        $this->$setter($value);
    }

    public function __call($name, $arguments)
    {
        if (strpos($name, 'set') === 0 && strlen($name) > 3 ) {
            $property = lcfirst(substr($name,2));
            $this->$property = $arguments[0];
        } elseif (strpos($name, 'get') === 0 && strlen($name) > 3 ) {
            $property = lcfirst(substr($name,2));

            return $this->$property;
        }
    }

}
