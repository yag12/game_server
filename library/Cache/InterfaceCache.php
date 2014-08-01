<?php 
/**
* @Desc interface cache
*
*/
namespace Library\Cache

interface InterfaceCache
{
	public function connection();
	public function get();
	public function set();
}
