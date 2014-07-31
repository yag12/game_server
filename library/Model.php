<?php
/**
* @Desc model
*
*/
namespace Library;

abstract class Model
{
	protected $db = null;
	protected $type = 'default';
	protected $name = null;

	/**
	* @Desc : Construct
	* @Param : Database $db
	* @Return : void
	*/
	public function __construct(&$db = null)
	{
		if(!empty($db[$this->type])) $this->db = &$db[$this->type];
		$this->name = substr(__CLASS__, 0, -5);
	}

	/**
	* @Desc : db table select
	* @Param : array $data
	* @Return : array or null
	*/
	final protected function find($data = array())
	{
		extract($data, EXTR_PREFIX_SAME, 'find');
		$result = array();

		return $result;
	}

	/**
	* @Desc : db table insert or update
	* @Param : array $data
	* @Return : int
	*/
	final protected function save($data = array())
	{
		extract($data, EXTR_PREFIX_SAME, 'save');

		return 1;
	}

	/**
	* @Desc : db table delete
	* @Param : array $data
	* @Return : boolean
	*/
	final protected function rm($data = array())
	{
		extract($data, EXTR_PREFIX_SAME, 'rm');

		return true;
	}
}
