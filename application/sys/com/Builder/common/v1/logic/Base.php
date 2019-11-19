<?php


namespace app\sys\com\builder\common\v1\logic;

use app\sys\com\base\common\v1\logic\Common;
use app\sys\com\base\common\v1\traits\VarBase;

class Base extends Common {
	//use \app\sys\com\base\common\v1\traits\Base;
	use VarBase;
	
	public static $_MODULE = [
		'common' => 'common',
		'mp' => 'mp',
		'miniapp' => 'miniapp',
		
		'c' => 'common',
		'ma' => 'miniapp',
	];
	
	public static $_APPTYPE = [
		'mp' => 'mp',
		'miniapp' => 'miniapp',
		
		'c' => 'common',
		'ma' => 'miniapp',
	];
	
	protected $_self_name = 'builder';
	protected $_component = '';
	protected $_ver = 'v1';
	
	// protected $_config_info = [
	// 	'component_name' => '',
	// 	'error_config_file' => 'error_code',
	// ];
	
	protected $_var_value = [
		'controller' => [
			'FileDescription' => '',
			'Namespace' => '',
			'ModelNamespace' => '',
			'module' => '',
			'ClassName' => '',
			'ModelName' => '',
			'AddFunc' => '',
			'EditFunc' => '',
			'ListParamVars' => '',
			'ListParamWheres' => '',
			'ListOrder' => '',
		],
		'model' => [
			'FileDescription' => '',
			'Namespace' => '',
			'ClassName' => '',
			'FieldPrefix' => '',
			'PK' => '',
			'TableName' => '',
			'CreateTime' => '',
			'UpdateTime' => '',
			'AutoWriteTimestamp' => '',
		],
		'validate' => [
			'Namespace' => '',
			'ClassName' => '',
			'ruleList' => '',
			'messageList' => '',
			'sceneAddList' => '',
			'sceneEditList' => '',
		],
	];
	
	public function initialize() {
		parent::initialize();
		
		$this->_component = $this->_self_name;
		
		$this->_config_info['component_name'] = $this->_self_name;
	}
	
	public function var2value($text, $var) {
		$this->var_clear();
		$this->_var = $var;
		return $this->exchange_all($text);
	}
	
	
}
