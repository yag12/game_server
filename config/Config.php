<?php
/**
* @Desc config
*
*/
namespace Config;

final class Info
{
	public $db = array(
		'default' => array(
			'type' => 'mongo',
			'host' => '192.168.1.217',
			'port' => 40000,
			'name' => 'm4_real_20140402',
			'user' => '',
			'passwd' => '',
		),
		'mysql' => array(
			'type' => 'mysqli',
			'host' => '127.0.0.1',
			'port' => 3306,
			'name' => 'test',
			'user' => '',
			'passwd' => '',
		)
	);
	public $cache = array();
}
