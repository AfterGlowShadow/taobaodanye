<?php


namespace app\sys\com\base\common\v1\traits;


trait VarBase{
	protected $_var_local = [
		'package' => '',
		'component' => '',
		'module' => '',
		'ver' => 'v1',
		'appTag' => 'com',
	];
	
	public $_var = [];
	
	public function var_init($package, $component, $module, $ver = 'v1', $appTag = 'com') {
		$this->_var_local['package'] = $package;
		$this->_var_local['component'] = $component;
		$this->_var_local['module'] = $module;
		$this->_var_local['ver'] = $ver;
		$this->_var_local['appTag'] = $appTag;
		
		$this->_var = $this->_var_local;
	}
	
	public function var_clear() {
		foreach ($this->_var as $k => $v) {
			if (!in_array($k, ['package', 'component', 'module', 'ver', 'appTag'])) {
				unset($this->_var[$k]);
			}
		}
	}
	
	/**
	 * 更换变量值
	 *  将{{$var}}更换成对应的值
	 * @param $text
	 * @param $search
	 * @param $value
	 * @return mixed
	 */
	public function exchange_var($text, $search, $value) {
		return str_replace('{{$' . $search . '}}', $value, $text);
	}
	
	public function exchange_all($text) {
		foreach ($this->_var as $k => $v) {
			if ($k == 'ver' && $v == 'v1') {
				$v = '';
			}
			$text = $this->exchange_var($text, $k, $v);
		}
		
		return $text;
	}
}