<?php
namespace CentralApps\Core;

class BasicModelFactory {
	
	public function __construct($database_engine, $dependency_injection_container)
	{
		
	}
	
	public function createFromId($class, $id)
	{
		$class = $class . 'DAO';
		$object = new $class();
	}
	
	
}
