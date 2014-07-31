<?php
/**
* @Desc dispatcher
*
*/

namespace Library;

class Dispatcher
{
	/**
	* @Desc construct
	* @Param void
	* @Return void
	*/
	public function __construct()
	{
		$this->init();
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

	/**
	* @Desc init
	* @Param void
	* @Return boolean
	*/
	private function init()
	{
		try
		{
			if(empty($_POST['method']) ||  empty(strpos($_POST['method'], '.')))
			{
				throw new \Exception("not found method.");
				return false;
			}

			if(defined('ROOT') === false) define('ROOT', dirname(dirname(__FILE__)));
			$params = !empty($_POST['params']) ? $_POST['params'] : null;
			list($controllerName, $actionName) = explode('.', $_POST['method']);
			$controllerName = ucfirst($controllerName);
			$controllerFile = ROOT . '/controller/' . $controllerName . '.php';

			if(is_file($controllerFile))
			{
				require_once ROOT . '/library/Controller.php';
				require_once $controllerFile;

				$controller = $controllerName . 'Controller';
				if(class_exists($controller))
				{
					$obj = new $controller;
					return $obj->startup($controllerName, $actionName, $params);
				}
			}else{
				throw new \Exception("file not found : " . $controllerFile);
				return false;
			}
		}catch(Exception $e)
		{
			var_dump($e);
			return false;
		}

		return true;
	}
}
