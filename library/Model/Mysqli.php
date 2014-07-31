<?php
/**
* @Desc mysqli
*
*/
namespace Library\Model;

class Mysqli
{
	protected $db;

	/**
	* @Desc construct
	* @Param Info.db $db
	* @Return void
	*/
	public function __construct(&$db)
	{
		$this->db = &$db;
		$this->connection();
	}

	/**
	* @Desc mongodb connect
	* @Param void
	* @Return void
	*/
	protected function connection()
	{

	}
}
