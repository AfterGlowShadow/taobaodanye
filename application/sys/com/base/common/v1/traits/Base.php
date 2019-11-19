<?php


namespace app\sys\com\base\common\v1\traits;


trait Base{
	protected $_pcmv = [
		'package' => '',
		'component' => '',
		'module' => '',
		'ver' => 'v1',
		'appType' => '',
	];
	
	// 专门给EE用的
	protected $_config_info = [
		'component_name' => 'Base',
		'error_config_file' => 'error_code',
	];
	
	protected $_config = [];
	
	// public function initialize() {
	// 	parent::initialize();
	//
	// }
	
	public function t() {
		$a = static::class;
		return $a;
	}
	
	// //__set()方法用来设置私有属性
	// public function __set($name, $value) {
	// 	$this->$name = $value;
	// }
	//
	// //__get()方法用来获取私有属性
	// public function __get($name) {
	// 	return !is_null($this->$name) ? $this->$name : '';
	// }
	
	public function read_config_com($componentName = '', $configFile = '') {
		$c = readConfig_C($componentName, $configFile);
		($c !== true) && $this->_config = $c;
		return $this;
	}
	
	public function config_com($componentName = '', $configFile = '') {
		return $this->read_config_com($componentName, $configFile);
	}
	
	public function read_config_mp($componentName = '', $configFile = '') {
		$c = readConfig_MP($componentName, $configFile);
		($c !== true) && $this->_config = $c;
		return $this;
	}
	
	public function config_mp($componentName = '', $configFile = '') {
		return $this->read_config_mp($componentName, $configFile);
	}
	
	public function read_config_ma($componentName = '', $configFile = '') {
		$c = readConfig_MA($componentName, $configFile);
		($c !== true) && $this->_config = $c;
		return $this;
	}
	
	public function config_ma($componentName = '', $configFile = '') {
		return $this->read_config_ma($componentName, $configFile);
	}
}