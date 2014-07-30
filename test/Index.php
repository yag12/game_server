<?php
define('ROOT', dirname(dirname(__FILE__)));
require_once ROOT . '/library/Dispatcher.php';

class IndexTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		
	}

	public function testController()
	{
		$this->assertEquals(1, 1);
	}
}
