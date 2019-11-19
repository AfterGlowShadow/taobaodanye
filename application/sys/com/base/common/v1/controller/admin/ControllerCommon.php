<?php
// +----------------------------------------------------------------------
// | Description: 通用增删改查
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\admin;

use app\sys\com\base\common\v1\logic\ModelCommon;
use Think\Exception;
use think\exception\PDOException;

class ControllerCommon extends ResCommon {
	protected $_buf = []; // 缓存交换区 用于临时数据会话
	
    public function initialize() {
        parent::initialize();


    }
    
	/**
	 * 获取列表
	 *
	 * @return \think\response\Json
	 */
	public function getList() {
		/** @var $m ModelCommon */
		$m = $this->_model;
		$param = $this->param;

		$page_num = isset($param['page_num']) ? $param['page_num'] : 1;
		$page_limit = isset($param['page_limit']) ? $param['page_limit'] : PHP_INT_MAX;

		$_where = [];
		$_order = [];

		$re = $m->getList($_where, $_order, $page_num, $page_limit);
		return return_json($re);
	}
	
	/**
	 * 获取单项
	 * id
	 * @return \think\response\Json
	 */
	public function getItemById() {
		/** @var $m ModelCommon */
		$m = $this->_model;
		$param = $this->param;

		$re = $m->getItemById($param['id']);
		return return_json($re);
	}

	/**
	 * 获取单项
	 * id
	 * @return \think\response\Json
	 * @throws \think\Exception\DbException
	 */
	public function getItem() {
		/** @var $m ModelCommon */
		$m = $this->_model;
		$param = $this->param;

		$_where = [];

		$re = $m->getDataItem($_where);
		return return_json($re);
	}

	/**
	 * 添加
	 *
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m ModelCommon */
		$m = $this->_model;
		$param = $this->param;

		// 添加属性
		$_data = $param;

		$re = $m->add($_data);
		return return_json($re);
	}

	/**
	 * 更改
	 *
	 * id  ID
	 * @return mixed|string
	 * @throws \think\Exception\DbException
	 */
	public function edit() {
		/** @var $m ModelCommon */
		$m = $this->_model;
		$param = $this->param;

		$id = $param['id'];

		// 更改属性
		$_data = $param;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}

		return rjOk();
	}
	
	/**
	 * 删除
	 *
	 * id  ID
	 * @return mixed|string
	 * @throws \think\Exception\DbException
	 * @throws \Throwable
	 */
	public function delete() {
		/** @var $m ModelCommon */
		$m = $this->_model;
		$param = $this->param;

		$id = (int)$param['id'];
		$delson = isset($param['delson']) ? $param['delson'] : 0;
		$softDel = isset($param['softDel']) ? $param['softDel'] : true;
		
		$re = $this->transaction(function () use ($param, $m, $id, $delson, $softDel) {
			$re = $m->delById($id, $delson, $softDel);
			if (!is_return_ok($re)) {
				return $re;
			}
			
			return rsOk();
		});
		
		return return_json($re);
	}
	
	/**
	 * 批量删除
	 * @return array|mixed|\Services_JSON_Error|string|\think\response\Json
	 * @throws \Throwable
	 */
	public function delete_more() {
		/** @var $m ModelCommon */
		$m = $this->_model;
		$param = $this->param;
		
		try {
			$ids = json_decode($param['ids']);// 更改属性
			$delson = isset($param['delson']) ? $param['delson'] : 0;
			
			$where = [];
			$where[] = [$m->getPk(), 'IN', $ids];
			
			$re = $this->transaction(function () use ($param, $m, $where, $delson) {
				$re = $m->delByWhere($where, $delson);
				if (!is_return_ok($re)) {
					return $re;
				}
				
				return rsOk();
			});
			
			return return_json($re);
		} catch (\Exception $e) {
			return rjErr($e->getMessage());
		}
	}
	
	/**
	 * 查找参数id
	 * @param int    $errCode
	 * @param string $paramName
	 * @return array|int
	 */
	public function findParamId($errCode = 10010, $paramName = 'id') {
		/** @var $m ModelCommon */
		$m = $this->_model;
		$id = $this->p($paramName);
		
		$re = $m->getItemById($id);
		if (!is_return_ok($re)) {
			exit(json_encode_u($re)); // error
		}
		
		$reData = get_return_data($re);
		if (empty($reData)) {
			exit(json_encode_u(return_status_err_c($errCode))); // 找不到
		}
		
		$result = [
			'id' => $id,
			'data' => $reData,
		];
		
		return $result;
	}
	
	public function fp($errCode = 10010) {
		return $this->findParamId($errCode);
	}
	
	public function param_pk($param) {
		if (empty($param)) {
			return [];
		}
		
		$fp = $this->_model->getFieldPrefix();
		$param_pf = [];
		foreach ($param as $k => $v) {
			$param_pf[$fp . $k] = $v;
		}
		
		return $param_pf;
	}
	
	public function validate_param($param, $scene = '', $die = true) {
		$validate = $this->_validate;
		if (!$validate->scene($scene)->check($param)) {
			if ($die) {
				header('Content-Type:application/json; charset=utf-8');
				exit(json_encode_u(rsErr($validate->getError(), 10011)));
			}
			
			return rsErr($validate->getError(), 10011);
		}
		
		return rsOk();
	}
	
	public function validate_add_param($param) {
		if (!$this->_model->getEnabledValidateAdd()) {
			return rsOk();
		}
		
		return $this->validate_param($param, 'add');
	}
	
	public function validate_edit_param($param) {
		if (!$this->_model->getEnabledValidateEdit()) {
			return rsOk();
		}
		
		return $this->validate_param($param, 'edit');
	}
	
	/**
	 * 排序构建
	 * @param array $order_source
	 * @return array
	 */
	public function makeSortField($order_source = []) {
		/** @var $m ModelCommon */
		$m = $this->_model;
		
		return $m->makeSortField($order_source);
	}
	
	/**
	 * 排序构建
	 * @param string $order_source_text
	 * @return array
	 */
	public function makeSortField_JsonText($order_source_text = '') {
		$order_source = [];
		if (empty($order_source_text)) {
			return [];
		}
		
		// if (is_array($order_source_text)) {
		// 	return $this->makeSortField($order_source_text);
		// }
		
		try {
			$order_source = json_decode($order_source_text, true);
			if (empty($order_source)) {
				return [];
			}
			return $this->makeSortField($order_source);
		} catch(Exception $e) {
			return [];
		}
	}
	
}
