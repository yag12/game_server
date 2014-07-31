<?php
/**
* @Desc dispatcher
*
*/

namespace Library;

class Dispatcher
{
	protected $result;

	/**
	* @Desc construct
	* @Param array $params
	* @Return void
	*/
	public function __construct($params = array())
	{
		$method = !empty($params['method']) ? $params['method'] : null;
		$params = !empty($params['params']) ? $params['params'] : null;
		$this->init($method, $params);
	}

	/**
	* @Desc startup
	* @Param array $params
	* @Return mixed
	*/
	static public function startup($params = array())
	{
		$dispatcher = new Dispatcher($params);

		if(empty($params)) print(json_encode($dispatcher->result));
		return $dispatcher->result;
	}

	/**
	* @Desc init
	* @Param string $method
	* @Param array $params
	* @Return boolean
	*/
	private function init($method = null, $params = array())
	{
		try
		{
			if(empty($method)) $method = !empty($_POST['method']) ? $_POST['method'] : null;
			if(empty($params)) $params = !empty($_POST['params']) ? $_POST['params'] : null;
			if(empty(strpos($method, '.')))
			{
				throw new \Exception("not found method.");
				return false;
			}

			if(defined('ROOT') === false) define('ROOT', dirname(dirname(__FILE__)));
			list($controllerName, $actionName) = explode('.', $method);
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
					$this->result = $obj->startup($controllerName, $actionName, $params);
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
