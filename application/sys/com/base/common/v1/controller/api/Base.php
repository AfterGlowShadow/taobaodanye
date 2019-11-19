<?php
// +----------------------------------------------------------------------
// | Description: 基础
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\api;

use think\exception\PDOException;
use think\Model;


class Base extends Common
{
	/** @var Model */
	private $_model_trans;

	protected $_c;
	protected $_m;
	protected $_a;
	
	protected $_addon_param;

    public function initialize()
    {
        parent::initialize();
        /*获取头部信息*/

	    // $_request = $this->request;
	    // $this->_c = $_request->controller();
	    // $this->_m = $_request->module();
	    // $this->_a = $_request->action();
	
	    $this->_addon_param = sessionOrGLOBALS('addonParam');
	
	    isset($this->_addon_param['component']) && $this->_m = $this->_addon_param['component'];
	    isset($this->_addon_param['col']) && $this->_c = $this->_addon_param['col'];
	    isset($this->_addon_param['act']) && $this->_a = $this->_addon_param['act'];
    }

	/**
	 * @param $callback
	 * @return mixed|null
	 * @throws PDOException
	 */
	public function transaction($callback) {
		$this->startTrans();

		try {
			$result = null;
			if (is_callable($callback)) {
				$result = call_user_func_array($callback, [$this]);
			}

			$this->commit_return($result);
			return $result;
		} catch (\Exception $e) {
			$this->rollback();
			return return_status_err($e->getMessage(), 10009);
			//throw $e;
		} catch (\Throwable $e) {
			$this->rollback();
			return return_status_err($e->getMessage(), 10009);
			//throw $e;
		}
	}

    public function startTrans() {
	    $this->_model_trans = new \app\sys\com\base\common\v1\logic\Common();
	    $this->_model_trans->startTrans();
    }

	/**
	 * @throws PDOException
	 */
	public function commit() {
		try {
			$this->_model_trans->commit();
		} catch (PDOException $e) {
			$this->rollback();
		}
	}

	/**
	 * @throws PDOException
	 */
	public function rollback() {
		$this->_model_trans->rollback();
	}

	/**
	 * @param $re
	 * @throws PDOException
	 */
	public function commit_return($re) {
		if (is_return_ok($re)) {
			$this->commit();
		} else {
			$this->rollback();
		}
	}
}
