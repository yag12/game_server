<?php
/**
* @Desc redis
*
*/
namespace Library\Cache;

class Redis implements \Library\Cache\InterfaceCache
{
	/**
	* @Desc construct
	*
	*/
	public function __construct(){ }

	/**
	* @Desc redis connect
	*
	*/
	public function connection(){ }

	/**
	* @Desc redis get
	*
	*/
	public function get(){ }

	/**
	* @Desc redis set
	*
	*/
	public function set(){ }
}
