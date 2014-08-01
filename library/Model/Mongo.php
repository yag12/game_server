<?php
/**
* @Desc mongodb
*
*/
namespace Library\Model;

class Mongo implements \Library\Model\InterfaceModel
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
		$server = 'mongodb://' . $this->db['host'] . (!empty($this->db['port']) ? ':' . $this->db['port'] : '');
		$options = array('connect' => true);
		$mongo = null;

		if(class_exists("MongoClient"))
		{
			$mongo = new \MongoClient($server, $options);
		}
		elseif(class_exists("Mongo"))
		{
			$mongo = new \Mongo($server, $options);
		}

		if(!empty($mongo))
		{
			$this->db['db'] = $mongo->selectDB($this->db['name']);
		}
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
