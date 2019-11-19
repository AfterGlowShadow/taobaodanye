<?php
// +----------------------------------------------------------------------
// | Description: 通用
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\api;

use app\sys\com\base\common\v1\logic\ModelCommon;

class ControllerCommon extends ResCommon {
	protected $_buf = [];
	
    public function initialize()
    {
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
		if (!is_return_ok($re)) {
			return return_json($re);
		}

		$reData = get_return_data($re);
		return return_json_ok_data($reData);
	}

	/**
	 * 获取单项
	 * id
	 * @return \think\response\Json
	 * @throws \think\Exception\DbException
	 */
	public function getItemById()
	{
		/** @var $m ModelCommon */
		$m = $this->_model;
		$param = $this->param;

		$re = $m->getItemById($param['id']);
		if (!is_return_ok($re)) {
			return return_json($re);
		}

		$reData = get_return_data($re);

		return return_json_ok_data($reData);
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
		if (!is_return_ok($re)) {
			return return_json($re);
		}

		$reData = get_return_data($re);

		return return_json_ok_data($reData);
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
		if (!is_return_ok($re)) {
			return return_json($re);
		}
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
		if ($re === false) {
			return return_json($re);
		}

		return return_json($re);
	}

	/**
	 * 删除
	 *
	 * id  ID
	 * @return mixed|string
	 * @throws \think\Exception\DbException
	 */
	public function delete() {
		/** @var $m ModelCommon */
		$m = $this->_model;
		$param = $this->param;

		$id = $param['id'];

		// 更改属性
		$re = $m->delById($id);
		if ($re === false) {
			return return_json($re);
		}

		return return_json($re);
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
		} catch(\Exception $e) {
			return [];
		}
	}
}
