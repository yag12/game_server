<?php
/**
* @Desc interfase model
*
*/
namespace Library\Model;

interface InterfaceModel
{
	public function connection();
	public function find();
	public function save();
	public function remove();
}
