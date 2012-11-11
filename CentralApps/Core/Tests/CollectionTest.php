<?php
namespace CentralApps\Core\Tests;

use CentralApps\Core\Collection;

/**
 * @small
 */
class CollectionTest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		$stub = $this->getMockForAbstractClass('\CentralApps\Core\AbstractCollection');
		$this->_object = $stub;
	}
    
    /**
     * @covers CentralApps\Core\Collection::add
	 * @covers CentralApps\Core\Collection::count
     */
    public function testAdd()
    {
    	$testObject = new \stdClass();
		$testObject->something = 'Hello';
		$testObject2 = new \stdClass();
		$testObject2->something = 'Goodbye';
    	$this->_object->add( $testObject );
		$this->_object->add( $testObject2 );
		$this->assertEquals( 2, $this->_object->count(), 'Two objects added to the collection however count did not equal two' );
  	}
	
	/**
     * @covers CentralApps\Core\Collection::pop
	 * @covers CentralApps\Core\Collection::add
     */
	public function testPop()
	{
		$testObject = new \stdClass();
		$testObject->something = 'Hello';
		$testObject2 = new \stdClass();
		$testObject2->something = 'Goodbye';
    	$this->_object->add( $testObject );
		$this->_object->add( $testObject2 );
		
		$object = $this->_object->pop();
		$this->assertEquals( 'Goodbye', $object->something, 'Popped object not as expected' );
	}
	
	/**
	 * @covers CentralApps\Core\Collection::getIterator
	 * @covers CentralApps\Core\Collection::add
	 */
	public function testGetIterator()
	{
		$testObject = new \stdClass();
		$testObject->something = 'Hello';
		$testObject2 = new \stdClass();
		$testObject2->something = 'Goodbye';
    	$this->_object->add( $testObject );
		$this->_object->add( $testObject2 );
		
		$count = 0;
		foreach( $this->_object as $model )
		{
			$count++;
			$this->assertTrue( get_class( $model ) == 'stdClass', 'Iterator did not return a stdClass which was passed' );
			$this->assertTrue( $model->something != '', 'Iterate did not return an object with some data set within it');
		}
		
		$this->assertTrue( $count == $this->_object->count(), 'Iterator count did not match collection count' );
	}
  	
}