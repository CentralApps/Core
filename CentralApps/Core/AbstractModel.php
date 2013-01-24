<?php
namespace CentralApps\Core;

abstract class AbstractModel implements ModelInterface, MagicModelInterface
{
    protected $container;
    protected $dao;
    // SHOULD DO: consider changing this to a constant, and accessing within the constructor via constant(get_class($this)."::CONST_NAME")
    protected $daoContainerKey;
    protected $valid = false;
    protected $existsInDatabase = false;
    
    // if the getters and setters are not implemented, the default magic methods will use this array as a bucket
    protected $properties = array();
    
    public function __construct($container, $unique_reference=null)
    {
        if(!is_array($container) && ! $container instanceof \ArrayAccess) {
            throw new \InvalidArgumentException("Container should be an array or an object which implements ArrayAccess");
        }
        
        $this->dao = $container['data_access_objects'][$this->daoContainerKey];
        if($this->dao instanceof DAOInterface) {
            if(!is_null($unique_reference)) {
                try {
                    $this->dao->createFromUniqueReference($unique_reference, $this);
                    $this->properties = $this->dao->getProperties();
                    $this->setValid(true);
                    $this->setExistsInDatabase(true);
                } catch (\Exception $e) {
                    $this->existsInDatabase = false;
                    $this->false = false;
                }
            }
        } else {
            throw new \RuntimeException("Container injected DAO does not implement DAOInterface");
        }
    }
    
    public function setUniqueReferenceFieldValue($value)
    {
        $this->properties[$this->dao->getUniqueReferenceField()] = $value;
    }
    
    public function setValid($valid)
    {
        $this->valid = $valid;
    }
    
    public function setExistsInDatabase($exists_in_db)
    {
        $this->existsInDatabase = $exists_in_db;
    }
    
    public function existsInDatabase()
    {
        return $this->existsInDatabase;
    }
    
    public function isValid()
    {
        return $this->isValid;
    }
    
    public function getProperties()
    {
        return $this->properties;
    }
    
    public function save()
    {
        try {
            $this->dao->save($this);
            return true;
        } catch(\Exception $e) {
            return false;
        }
        
    }
    
    public function delete()
    {
        try {
            $this->dao->delete($this);
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }
    
    public function __set($name, $value)
    {
        $this->properties[$property] = $value;
        /**
         * Used if we want to set actual properties, not magic db ones
         * $name = str_replace('_', ' ', $name);
         * $setter = 'set' . str_replace(' ', '', ucwords($name));
         * return $this->$setter($value);
        */
        
    }
    
    public function __get($name)
    {
        return $this->properties[$property];
        /**
         * Getter for if we want to get actual properties and not magic db ones
         * $name = str_replace('_', ' ', $name);
            $name = ucwords($name);
            $name = str_replace(' ', '', $name);
            $getter = 'get' . $name;
            return $this->$getter();
         */
        
    }

    public function __call($name, $arguments)
    {
        if (strpos($name, 'set') === 0 && strlen($name) > 3 ) {
            /*
                This comment block is used if we want to set properties directly
                $property = lcfirst(substr($name, 2));
                $this->$property = $arguments[0];
             */
             $this->properties[$property] = $arguments[0];
        } elseif (strpos($name, 'get') === 0 && strlen($name) > 3 ) {
            /*
             * This comment block is used if we want to set properties directly
             * $property = lcfirst(substr($name, 2));
             * return $this->$property;
             */
            return isset($this->properties[$property]) ? $this->properties[$property] : null;
        }
    }
    
    public function hydrate($array)
    {
        foreach( $array as $key => $value ) {
            $this->properties[$key] = $value;
        }
        return $model;
    }
    
    public function __clone()
    {
        $pkf = $this->dao->getUniqueReferenceField();
        $this->$pkf = null;
        $this->valid = false;
        $this->existsInDatabase = false;
    }

}
