<?php
namespace CentralApps\Core;

class KeyedCollection extends Collection {
	
	public function add($object, $key)
	{
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
	
}
