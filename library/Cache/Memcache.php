<?php
/**
* @Desc memcache
*
*/
namespace Library\Cache;

class Memcache implements \Library\Cache\InterfaceCache
{
	protected $memcache;

	/**
	* @Desc construct
	* @Param array $config
	* @Return void
	*/
	public function __construct($config = array()))
	{ 
		if(empty($config['servers'])) $config['servers'] = array('127.0.0.1', 11211, 100);
		$this->connection($config);
	}

	/**
	* @Desc memcached connect
	* @Param array $config
	* @Return void
	*/
	public function connection($config = array()))
	{ 
		$servers = !empty($config['servers']) ? $config['servers'] : array();
		$prefix_key = !empty($config['prefix_key']) ? $config['prefix_key'] : null;
	
		$this->memcache = new Memcached;
		$this->memcache->addServers($servers);
		$this->memcache->setOptions(array(
			Memcached::OPT_DISTRIBUTION => Memcached::DISTRIBUTION_CONSISTENT,
			Memcached::OPT_LIBKETAMA_COMPATIBLE => true,
			Memcached::OPT_NO_BLOCK => true,
			Memcached::OPT_TCP_NODELAY => true,
			Memcached::OPT_RETRY_TIMEOUT => 3,
			Memcached::OPT_CONNECT_TIMEOUT => -1,
			Memcached::OPT_POLL_TIMEOUT => -1,
		));

		if(!empty($prefix_key))
		{
			// 접두사 - 서버 구분시
			$this->memcache->setOption(Memcached::OPT_PREFIX_KEY, $prefix_key);
		}
	}

	/**
	* @Desc memcached get
	* - get : Memcache::get($key[, $callback]);
	* @param string $key 키
	* @param callback $callback 콜백함수
	* Read-through caching callback : function callback($memc, $key, &$value){ return true; }
	* 데이터가 없을 경우 콜백함수 호출
	*
	* - multi get : Memcache::get(array($key1, $key2)[, $callback]);
	* @param array $keys 배열(키)
	* @param callback $callback 콜백함수
	* Read-through caching callback : function callback($memc, $key, &$value){ return true; }
	* 데이터가 있는 경우 콜백함수 호출
	*
	* @return mixed
	*/
	public function get()
	{
		$datas = null;
		$callback = null;
		$args_length = func_num_args();
		if ($args_length > 0)
		{
			$args = func_get_args();

			if(!empty($args[1]))
			{
				$callback = $args[1];
			}

			if(is_array($args[0]))
			{
				$records = null;
				$this->memcache->getDelayed($args[0], false);
				foreach($args[0] as $key) $records[$key] = null;
				while(($result = $this->memcache->fetch()) != FALSE)
				{
					$key = $result['key'];
					$value = $result['value'];
					$records[$key] = $value;
				}

				foreach($records as $key=>$value)
				{
					if($value === null)
					{
						$value = $this->memcache->get($key, $callback);
					}

					$datas[] = $value;
				}
			}
			elseif(is_string($args[0]))
			{
				$datas = $this->memcache->get($args[0], $callback);
			}
		}

		if($this->memcache->getResultCode() === Memcached::RES_SUCCESS)
		{
			return $datas;
		}

		return false;
	}

	/**
	* @Desc memcached set
	* - set : Memcache::set($key, $value[, $expiration]);
	* @param string $key 키
	* @param mixed $value 값
	* @param int $expiration 유효시간
	*
	* - multi set : Memcache::set(array($key1=>$value1, $key2=>$value2)[, $expiration])
	* @param array $arrays 배열(키=>값)
	* @param int $expiration 유효시간
	*
	* @return boolean
	*/
	public function set()
	{
		$expiration = null;
		$args_length = func_num_args();
		if ($args_length > 0)
		{
			$args = func_get_args();

			if(is_array($args[0]))
			{
				if(!empty($args[1]) && is_numeric($args[1]))
				{
					$expiration = $args[1];
				}

				$this->memcache->setMulti($args[0], $expiration);
			}
			elseif(is_string($args[0]))
			{
				if(!empty($args[2]) && is_numeric($args[2]))
				{
					$expiration = $args[2];
				}

				if(!empty($args[1]))
				{
					$this->memcache->set($args[0], $args[1], $expiration);
				}
			}
		}

		if($this->memcache->getResultCode() === Memcached::RES_SUCCESS)
		{
			return true;
		}	

		return false;
	}
}
