<?php
/**
* @Desc controller
*/
namespace Library;

abstract class Controller
{
	protected $controllerName = 'Index';
	protected $actionName = 'index';
	protected $params = array();
	protected $config;
	protected $response = array();

	/**
	* @Desc controller startup
	* @Param string $controllerName
	* @Param string $actionName
	* @Param array $params
	* @Return mixed
	*/
	final public function startup($controllerName = 'Index', $actionName = 'index', $params = array())
	{
		$this->controllerName = $controllerName;
		$this->actionName = $actionName;
		$this->params = $params;

		if(is_callable(array($this, $actionName), false) === true)
		{
			$this->getConfig();

			$this->init();

			$result = call_user_func(array($this, $actionName));

			if(!empty($result))
			{
				$method = $controllerName . '.' . $actionName;
				$this->setResponse($method, $result);
				return $this->output();
			}
		}else{
			throw new \Exception("action was not found : " . $controllerName . "::" . $actionName);
		}

		return true;
	}

	/**
	* @Desc set response
	* @Param string $method
	* @Param array $response
	* @Return void
	*/
	final protected function setResponse($method = null, $response = array())
	{
		$this->response[$method] = $response;
	}

	/**
	* @Desc output json data
	* @Param boolean $response
	* @Return mixed
	*/
	final protected function output()
	{
		$response = array();
		if(!empty($this->response))
		{
			foreach($this->response as $method=>$value)
			{
				$response[] = array(
					'method' => $method,
					'data' => $value,
				);
			}
		}

		return $response;
	}

	/**
	* @Desc import
	* @Param string $name
	* @Param string $type
	* @Return boolean
	*/
	private function import($name = 'default', $type = 'library')
	{
		$name = ucfirst($name);
		$loadFile = ROOT . '/' . $type . '/' . $name . '.php';

		if(is_file($loadFile) === false) return false;

		require_once $loadFile;

		return true;
	}

	/**
	* @Desc get model
	* @Param string $name
	* @Return Model
	*/
	final protected function getModel($name = null)
	{
		$model = null;
		if($this->import('Model', 'library'))
		{
			if($this->import($name, 'model'))
			{
				$modelName = ucfirst($name) . 'Model';
				$model = new $modelName($this->config->db);
			}
		}

		return $model;
	}

	/**
	* @Desc get library
	* @Param string $name
	* @Return Library
	*/
	final protected function getLibrary($name = null)
	{
		$library = null;
		if($this->import($name, 'library'))
		{
			$libraryName = ucfirst($name);
			$library = new $libraryName;
		}

		return $library;
	}

	/**
	* @Desc get plugin
	* @Param string $name
	* @Return Pligin
	*/
	final protected function getPlugin($name = null)
	{
		$plugin = null;
		if($this->import($name, 'plugin'))
		{
			$pulginName = ucfirst($name);
			$pulgin = new $pulginName;
		}

		return $plugin;
	}

	/**
	* @Desc get config
	* @Param void
	* @Return boolean
	*/
	private function getConfig()
	{
		if($this->import('Config', 'config'))
		{
			$this->config = new \Config\Info;
			
			if(!empty($this->config->db)) $this->database();
		}

		return true;
	}

	/**
	* @Desc database connect
	* @Param void
	* @Return void
	*/
	private function database()
	{
		if($this->import('Model/InterfaceModel', 'library'))
		{
			foreach($this->config->db as &$db)
			{
				switch($db['type'])
				{
					case 'mongo':
						if($this->import('Model/Mongo', 'library')) new \Library\Model\Mongo($db);
						break;
					case 'mysqli':
						break;
				}
			}
		}
	}

	/**
	* @Desc initiated
	* @Param void
	* @Return void
	*/
	public function init(){ }
}
