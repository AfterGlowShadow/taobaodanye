<?php
// +----------------------------------------------------------------------
// | 通用控制器
// +----------------------------------------------------------------------
// | Author: 米古月
// +----------------------------------------------------------------------


namespace app\sys\com\base\common\v1\controller\api;

use think\Controller;
use think\facade\Log;
use think\facade\Request;
use think\Model;

class Common extends Controller {
	use \app\sys\com\base\common\v1\traits\Base;
	
    public $param;
    public $header;
	
	public function initialize() {
        parent::initialize();

		$param = Request::param();
		Log::write("---Common.php initialize param=" . json_encode($param));
		$this->param = $param;
		
		$this->header = Request::header();
    }
	
	public function object_array($array)
	{
		if (is_object($array)) {
			$array = (array)$array;
		}
		if (is_array($array)) {
			foreach ($array as $key=>$value) {
				$array[$key] = $this->object_array($value);
			}
		}
		return $array;
	}
	
	/**
	 * 查找获取参数
	 *
	 * @param string $param_name 参数名
	 * @param bool   $require    是否必须
	 * @param string $default    默认值（不是必须时有效）
	 * @param bool   $exit       是否直接退出
	 * @return array|string
	 */
	public function getFindParam($param_name, $require = true, $default = '', $exit = true) {
		if (!isset($this->param[$param_name])) {
			if ($require) {
				if ($exit) {
					exit(json_encode_u(result_array_err_c_static(10001))); // 缺少参数
				} else {
					return return_status_err_c(10001); // 缺少参数
				}
			} else {
				return $default;
			}
		}
		
		return $this->param[$param_name];
	}
	
	public function p($param_name) {
		return $this->getFindParam($param_name);
	}
	
	public function pI($param_name, $default = '') {
		return $this->getFindParam($param_name, false, $default, false);
	}
}
 