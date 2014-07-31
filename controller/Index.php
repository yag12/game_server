<?php
/**
* @Desc
*
*/
class IndexController extends \Library\Controller
{
	public function index()
	{
		$db = $this->getModel('index');
		$no = $db->getTest();
		$this->setResponse('test.test', array('test1'=>'test'));
		return array('test'=>$no);
	}
}
