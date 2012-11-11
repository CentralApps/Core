<?php
namespace CentralApps\Core\Tests;

use CentralApps\Core\Collection;

/**
 * @small
 */
class AbstractKeyedCollectionTest extends \PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		$stub = $this->getMockForAbstractClass('\CentralApps\Core\AbstractKeyedCollection');
		$this->_object = $stub;
	}
    
    /**
     * @covers CentralApps\Core\AbstractKeyedCollection::add
	 * @covers CentralApps\Core\AbstractKeyedCollection::getKey
     */
    public function testAdd()
    {
		$class = new \ReflectionClass("\CentralApps\Core\AbstractKeyedCollection");
		$property = $class->getProperty('objects');
		$property->setAccessible(true);
		$value = $property->getValue($this->_object);
		$this->assertEquals(0, count($value), "The collection was not empty by default");
		$this->_object->add("test");
		$value = $property->getValue($this->_object);
		$this->assertEquals(1,count($value), "After adding to the collection, the count was not 1");
		$this->_object->add('test2', 'some-key');
		$value = $property->getValue($this->_object);
		$this->assertEquals(2,count($value), "After adding a second item with a specific key, the count was not 2");
		$this->assertEquals('test2', $value['some-key'], "After adding a second item with a specific key, it was not found in the collection with that key");
  	}
	
	/**
     * @covers CentralApps\Core\AbstractKeyedCollection::getKey
     */
	public function testGetKey()
	{
		$class = new \ReflectionClass("\CentralApps\Core\AbstractKeyedCollection");
		
		$property = $class->getProperty('objects');
		$property->setAccessible(true);
		$property->setValue($this->_object, array("a", "b"));
		
		$method = $class->getProperty('getKey');
		$method->setAccessible(true);
		$to_add = "";
		$value = $method->invoke($this->_object, $to_add);
		$this->assertEquals(2, $value, "Get key did not return the expected key value");
	}
	
	/**
     * @covers CentralApps\Core\AbstractKeyedCollection::count
     */
	public function testCount()
	{
		$this->assertEquals(0,count($this->_object), "Empty collection not empty by default");
		$class = new \ReflectionClass("\CentralApps\Core\AbstractKeyedCollection");
		$property = $class->getProperty('objects');
		$property->setAccessible(true);
		$property->setValue($this->_object, array(""));
		$this->assertEquals(1, count($this->_object), "Adding to the collection didn't increase the count");
	}
	
	/**
     * @covers CentralApps\Core\AbstractKeyedCollection::pop
     */
	public function testPop()
	{
		// can't pop a keyed exception
		$this->setExpectedException('\Exception');
		
		$class = new \ReflectionClass("\CentralApps\Core\AbstractKeyedCollection");
		$property = $class->getProperty('objects');
		$property->setAccessible(true);
		$property->setValue($this->_object, array("a", "b"));
		$popped = $this->_object->pop();
	}
	
	/**
	 * @covers CentralApps\Core\AbstractKeyedCollection::getIterator
	 */
	public function testGetIterator()
	{
		$class = new \ReflectionClass("\CentralApps\Core\AbstractCollection");
		$property = $class->getProperty('objects');
		$property->setAccessible(true);
		$property->setValue($this->_object, array("a" => "avalue", "b" => "bvalue"));
		$foundA = false;
		$foundB = false;
		foreach($this->_object as $key => $item) {
			if( $item == 'avalue' && $key == 'a' ) {
				$foundA = true;
			} elseif( $item == 'bvalue' && $key == 'b' ) {
				$foundB = true;
			}
		}
		
		$this->assertTrue(($foundA && $foundB), "Didn't iterate and find A and B with their correct keys");
	}
  	
}