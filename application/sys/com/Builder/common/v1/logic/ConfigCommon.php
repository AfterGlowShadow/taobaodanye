<?php


namespace app\sys\com\builder\common\v1\logic;


use app\sys\com\base\common\v1\traits\VarBase;
use app\sys\com\ErrorMgr\common\v1\facade\EE;

class ConfigCommon extends Base {
	//use \app\sys\com\base\common\v1\traits\Base;
	//use VarBase;
	
	protected $_path = [];
	protected static $_instance = null;
	
	//__set()方法用来设置私有属性
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	//__get()方法用来获取私有属性
	public function __get($name) {
		return !is_null($this->$name) ? $this->$name : '';
	}
	
	/**
	 * 防止克隆
	 *
	 */
	private function __clone(){}
	
	/**
	 * Singleton instance
	 *
	 * @return Object
	 */
	public static function getInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function initialize() {
		parent::initialize(); // TODO: Change the autogenerated stub
		
		$this->init_path();
	}
	
	public function init_path() {
		$this->read_config_com($this->_self_name, 'template_builder');
		$this->_path['base_path'] = $this->_config['base_path'];
	}
	
	public function read($package, $component, $module = 'common', $appType = 'lib', $ver = 'v1', $appTag = 'com') {
		if (empty($this->_config)) {
			return EE::load_config($this)->code(910001)->v();
		}
		
		$this->var_init($package, $component, $module, $ver, $appTag);
		
		// 遍历应用类型 公众号mp、小程序miniapp
		// item ---- mp  miniapp
		$this->var_clear();
		
		// kv ---- build_root_path
		if (isset($this->_path['base_path'][$appType])) {
			foreach ($this->_path['base_path'][$appType] as $k => &$v) {
				$v = $this->exchange_all($v);
				if (in_array($k, ['build_dir_base_path', 'build_dir_path'])) {
					$v = removeEndWithValue($v, '/');
				}
				$this->_var[$k] = $v;
			}
		}
		
		return $this;
	}
	
}