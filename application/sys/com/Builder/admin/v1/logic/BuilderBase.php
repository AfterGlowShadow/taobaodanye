<?php

namespace app\sys\com\builder\admin\v1\logic;

class BuilderBase {
	/**
	 * 模板中会用到的变量
	 * @var array $_template_var
	 */
	private $_template_var = [
		/**
		 * key 变量
		 * value 默认值
		 */
		'FileDescription' => "",
		
		'Namespace' => "",
		'ClassName' => "",
		
		'FieldPrefix' => "",
		'PK' => "",
		'TableName' => "",
		'CreateTime' => false,
		'UpdateTime' => false,
		'AutoWriteTimestamp' => false,
		
	];
	
	/**
	 * 即将替换模板中的变量值
	 * @var array $_template_value
	 */
	private $_template_value = [];
	
	public function init() {
		$this->_template_value = $this->_template_var;
	}
	
	
}