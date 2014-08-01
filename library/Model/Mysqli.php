<?php
/**
* @Desc mysqli
*
*/
namespace Library\Model;

class Mysqli implements \Library\Model\InterfaceModel
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
	public function connection()
	{

	}

	/**
	* @Desc db select
	*
	*/
	public function find()
	{

	}

	/**
	* @Desc db insert or update
	*
	*/
	public function save()
	{

	}

	/**
	* @Desc db delete
	*
	*/
	public function remove()
	{

	}
}
