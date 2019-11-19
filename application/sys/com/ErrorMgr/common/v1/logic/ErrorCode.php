<?php


namespace app\sys\com\ErrorMgr\common\v1\logic;


use app\sys\com\base\common\v1\logic\Common;
use app\sys\com\base\common\v1\traits\Base;
use think\facade\Log;

class ErrorCode {
	use Base;
	
	protected $okData = [
		'status' => 'ok',
		'code' => 0,
		'msg' => 'ok',
		'result' => []
	];
	
	protected $errData = [
		'status' => 'error',
		'code' => 0,
		'msg' => '',
	];
	
	protected $_data = [];
	
	// protected $_config = [];
	
	public function __construct() {
		$this->_data = $this->okData;
	}
	
	/**
	 * 加载对应组件的配置文件
	 * @param \app\sys\com\base\common\v1\logic\Common $object
	 * @return ErrorCode
	 */
	public function load_config($object) {
		return $this->read_config_com($object->_config_info['component_name'], $object->_config_info['error_config_file']);
	}
	
	public function load_config_mp($object) {
		return $this->read_config_mp($object->_config_info['component_name'], $object->_config_info['error_config_file']);
	}
	
	public function load_config_ma($object) {
		return $this->read_config_ma($object->_config_info['component_name'], $object->_config_info['error_config_file']);
	}
	
	public function code($code = 1000) {
		if (!empty($this->_config)) {
			$this->_data = rsErr(isset($this->_config[$code]) ? $this->_config[$code] : '未知错误', $code);
		} else {
			$this->_data = rsErrCode($code);
		}
		
		return $this;
	}
	
	public function msg($msg = '出错了 :(', $code = 1000) {
		$this->_data = rsErr($msg, $code);
		return $this;
	}
	
	public function ok() {
		$this->_data = rsOk();
		return $this;
	}
	
	public function data($data = []) {
		$this->_data = rsData($data);
		return $this;
	}
	
	public function value() {
		return $this->_data;
	}
	
	public function v() {
		return $this->value();
	}
	
	public function json() {
		return json_encode_u($this->_data);
	}
	
	public function me() {
		return $this;
	}
	
	
}