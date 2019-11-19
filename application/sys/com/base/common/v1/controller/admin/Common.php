<?php
// +----------------------------------------------------------------------
// | Description: 通用
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\admin;

use think\Controller;
use think\db\exception\PDOException;
use think\facade\Log;
use think\facade\Route;
use Think\Model;
use think\facade\Request;

class Common extends Controller {
	use \app\sys\com\base\common\v1\traits\Base;
	
    public $param;
	public $header;
	/** @var $_model_trans Model */
	private $_model_trans;

	protected $_m;
	protected $_c;
	protected $_a;
	
	// protected $_config;
	protected $_addon_param;

	public function initialize() {
		parent::initialize();
		
		$param = Request::param();
		Log::write("---Common.php initialize param=" . json_encode($param));
		$this->param = $param;
		
		$this->header = Request::header();
		
		// $_request = $this->request;
		// $this->_m = $_request->module();
		// $this->_c = $_request->controller();
		// $this->_a = $_request->action();
		
		$this->_addon_param = sessionOrGLOBALS('addonParam');
		
		isset($this->_addon_param['component']) && $this->_m = $this->_addon_param['component'];
		isset($this->_addon_param['col']) && $this->_c = $this->_addon_param['col'];
		isset($this->_addon_param['act']) && $this->_a = $this->_addon_param['act'];
		
		// 获取配置
		// $systemConfigModel = new SystemConfig();
		// $this->_config = [];
		//
		// $re = $systemConfigModel->getDataCache();
		// if (isOk($re)) {
		// 	$this->_config = gData($re);
		// }
		//
		// $GLOBALS['system_config'] = $this->_config;
	}
	
	// public function getConfig() {
	// 	return $this->_config;
	// }

	/**
	 * @param $callback
	 * @return mixed|null
	 * @throws \Throwable
	 */
	public function transaction($callback) {
		$this->startTrans();

		try {
			$result = null;
			if (is_callable($callback)) {
				$result = call_user_func_array($callback, [$this]);
			}

			$this->commit_return($result);
			//return resultArray(['data' => $result]);
			return $result;
		} catch (\Exception $e) {
			$this->rollback();
			//return resultArray(['error' => $e->getMessage()]);
			//throw $e;
			return return_status_err($e->getCode() . $e->getMessage());
		} catch (\Throwable $e) {
			$this->rollback();
			//return resultArray(['error' => $e->getMessage()]);
			//throw $e;
			return return_status_err($e->getCode() . $e->getMessage());
		}
	}

	public function startTrans() {
		$this->_model_trans = new \app\sys\com\base\common\v1\logic\Common();
		$this->_model_trans->startTrans();
	}
	
	
	/**
	 * @throws \think\exception\PDOException
	 */
	public function commit() {
		try {
			$this->_model_trans->commit();
		} catch (PDOException $e) {
			$this->rollback();
		}
	}

	/**
	 * @throws \think\exception\PDOException
	 */
	public function rollback() {
		$this->_model_trans->rollback();
	}

	/**
	 * @param $re
	 * @throws \think\exception\PDOException
	 */
	public function commit_return($re) {
		if (is_return_ok($re)) {
			$this->commit();
		} else {
			$this->rollback();
		}
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
 