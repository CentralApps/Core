<?php
namespace CentralApps\Core;

abstract class KeyedCollection extends Collection {
	
	protected $objects;
	
	public function add($object, $key=null)
	{
		if(is_null($key)) {
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
		// default, needs overriding when implemented...otherwise its just a restricted collection
		return count($this->objects);	
	}
	
}
