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
		$response = \Library\Dispatcher::startup(array(
			'method' => 'Index.index',
			'params' => array(),
		));

		$this->assertEquals(10, $response[1]['data']['test']);
	}
}
