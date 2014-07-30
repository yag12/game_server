<?php
/**
* @Desc dispatcher
*
*/

namespace Library;

class Dispatcher
{
	public function __construct()
	{

	}

	/**
	* @Desc startup
	* @Param void
	* @Return void
	*/
	static public function startup()
	{
		new Dispatcher;
	}
}
