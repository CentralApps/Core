<?php
namespace CentralApps\Core;

abstract class AbstractKeyedCollection extends AbstractCollection
{
    protected $objects;

    public function add($object, $key = null)
    {
        if (is_null($key)) {
            $key = $this->getKey($object);
        }
        $this->objects[$key] = $object;
    }

    public function get($key)
    {
        return $this->objects[$key];
    }

    public function pop()
    {
        throw new \Exception("Can't pop a keyed collection");
    }

    protected function getKey($object)
    {
        //doing this to remove the phpmd complaint
        // that object is unused, its only here so
        // the class can be tested as this method
        // must be overriden by implementors otherwise
        // the class is unsable
        $temp = $object;
        // default, needs overriding when implemented.
        //..otherwise its just a restricted collection
        $temp = count($this->objects);

        return $temp;
    }
}
