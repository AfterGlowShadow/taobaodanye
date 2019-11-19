<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\logic;

use app\sys\com\base\common\v1\traits\InstanceBase;
use com\builder\common\v1\logic\Base;
use app\sys\com\base\common\v1\traits\VarBase;
use app\sys\com\ErrorMgr\common\v1\facade\EE;
use think\Db;
use Think\Exception;

class ModelCommon extends Common {
	use InstanceBase;
	use VarBase;
	
	protected $field_status = 'status'; // 默认状态字段
	
	public function initialize() {
		parent::initialize();
		
		if (!empty($this->field_prefix)) {
			$fp = $this->field_prefix;
			!startwith($this->getPk(), $fp) && $this->pk($fp . $this->getPk());
			$this->createTime !== false && !startwith($this->createTime, $fp) && $this->pk($fp . $this->createTime);
			$this->updateTime !== false && !startwith($this->updateTime, $fp) && $this->pk($fp . $this->updateTime);
			$this->deleteTime !== false && !startwith($this->deleteTime, $fp) && $this->pk($fp . $this->deleteTime);
		}
		
		$this->_init();
	}
	
	public function _init() {
	
	}
	
	public function ee() {
		$_ee = EE::me();
		
		switch ($this->_pcmv['appType']) {
			case Base::$_APPTYPE['mp']:
				$_ee = $_ee->load_config_mp($this); // todo:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
				break;
			
			case Base::$_APPTYPE['ma']:
				$_ee = $_ee->load_config_ma($this); // todo:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
				break;
		}
		
		return $_ee;
	}
	
	public function validateId($id, $errCode = 1000) {
		$re = $this->getDataById($id);
		if ($re === false) {
			//return $this->return_error();
			return return_status_err_c($errCode);
		}

		$reData = $this->cToArray($re);

		if (empty($reData)) {
			return return_status_err_c($errCode);
		}

		return return_status_ok_data($reData);
	}
	
	/**
	 * 唯一校验
	 *
	 * @param array $param   输入参数
	 * @param array $fields  需要校验的字段数组
	 * @param bool $isAdd    是否添加 如果是更改就需要含有主键
	 * @return array|\think\response\Json
	 */
	public function unique_check($param, $fields = [], $isAdd = true) {
		$pk = 0;
		if (!$isAdd) {
			// 更改需要主键存在
			if (empty($param[$this->pk])) {
				return rsErr('主键不存在或为空', 10011);
			}
			
			$pk = $param[$this->pk];
		}
		
		foreach ($fields as $k => $v) {
			if (isset($param[$k])) {
				$_w = [];
				!$isAdd && $_w[] = [$this->pk, '<>', $pk];
				$_w[] = [$k, '=', $param[$k]];
				$_w[] = [$k, '<>', ''];
				$re = $this->getDataItem($_w);
				if (isErr($re)) {
					return $re;
				}
				
				$reData = gData($re);
				if (!empty($reData)) {
					return rsErr($v, 10011);
				}
			}
		}
		
		return rsOk();
	}

	public function getList($where = [], $order = [], $page = 1, $limit = PHP_INT_MAX, $field = '*', $link = false) {
		$_where = [];
		$_where = array_merge($_where, $where);
		$dataCount = $this->where($_where)->count($this->getPk());

		$listM = $this
			->where($_where);

		// 若有分页
		if ($page && $limit) {
			$listM = $listM->page($page, $limit);
		}

		try {
			$listM = $listM
				->field($field)
				//->where($_where)
				->order($order);
			
			$w = [];
			$w['where'] = $_where;
			$w['order'] = $order;
			$w['page'] = $page;
			$w['limit'] = $limit;
			$w['field'] = $field;
			
			$list = [];
			if (!$this->beforeGetList($listM, $w, $list)) {
				return $list; // 前面返回false时 $list作为$result = return_status_err_c(100002);
			}

			$reList = $this->cToArray($list);

			log_record("--- list=" . json_encode($list, JSON_UNESCAPED_UNICODE));
			log_record("--- list sql=" . $this->getLastSql());

			return $this->afterGetList($dataCount, $list, $reList);
		} catch (Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	public function beforeGetList(&$m, $w, &$result) {
		$result = $m->select();
		
		return true;
	}
	
	public function afterGetList(&$dataCount, &$oList, &$arrList) {
		if (!empty($arrList)) {
			foreach ($arrList as &$row) {
				if (!$this->afterGetListItem($row)) {
					break;
				}
			}
		}
		
		$data = [
			'total' => $dataCount,
			'data' => $arrList,
		];
		
		return return_status_ok_data($data);
	}
	
	public function afterGetListItem(&$item) {
		return true;
	}

	/**
	 * 获取单项
	 * @param array $where
	 * @return array
	 */
	public function getDataItem($where = [], $link = false) {
		$_where = [];
		$_where = array_merge($_where, $where);

		try {
			$m = $this
				->field('*')
				->where($_where);
			
				//->find();
			$w = [];
			$w['where'] = $_where;
			
			$item = [];
			if (!$this->beforeGetItem($m, $w, $item)) {
				return $item; // 前面返回false时 $item作为$result = return_status_err_c(100002);
			}
			
			$itemArr = $this->cToArray($item);
			if ($itemArr === false) {
				return $this->return_error();
			}
			
			//return return_status_ok_data($itemArr);
			return $this->afterGetItem($item, $itemArr);
		} catch (Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	public function beforeGetItem(&$m, $w, &$result) {
		$result = $m->find();
		
		return true;
	}
	
	public function afterGetItem(&$oItem, &$arrItem) {
		return return_status_ok_data($arrItem);
	}

	/**
	 * 获取单项
	 * @param int $id
	 * @return array
	 */
	public function getItemById($id = 0) {
		// $_where = [];
		// $_where[] = [$this->getPk(), '=', $id];
		//log_record('--- getItemById _where' . json_encode_u($_where));
		try {
			// $item = $this
			// 	->field('*')
			// 	->where($_where)
			// 	->find();
			$re = $this->getDataById($id);
			if ($re === false) {
				return $this->return_error();
			}

			$itemArr = $this->cToArray($re);
			if ($itemArr === false) {
				return $this->return_error();
			}

			return return_status_ok_data($itemArr);
		} catch (Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : '数据查询失败' . $e->getMessage();
			return $this->return_error();
		}
	}
	
	// public function beforeGetItemById(&$m, $w, &$result) {
	// 	$result = $m->find();
	//
	// 	return true;
	// }
	//
	// public function afterGetItemById(&$oItem, &$arrItem) {
	// 	return return_status_ok_data($arrItem);
	// }

	/**
	 * 获取前一个记录
	 * @param int    $id
	 * @param string $field
	 * @return array
	 */
	public function getPriorItemById($id = 0, $field = '*') {
		try {
			// 获取前一个id
			$_where = [];
			$_where[] = [$this->getPk(), '<', $id];

			$_sub_sql = $this
				->where($_where)
				->fetchSql(true)
				->max($this->getPk());

			$_where = [];
			$_where[] = [$this->getPk(), 'EXP', Db::raw(" = ( {$_sub_sql} )")];

			$item = $this
				->field($field)
				->where($_where)
				->find();

			$itemArr = $this->cToArray($item);
			if ($itemArr === false) {
				return $this->return_error();
			}

			return return_status_ok_data($itemArr);
		} catch (Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}

	/**
	 * 获取下一个记录
	 * @param int    $id
	 * @param string $field
	 * @return array
	 */
	public function getNextItemById($id = 0, $field = '*') {
		try {
			// 获取下一个id
			$_where = [];
			$_where[] = [$this->getPk(), '>', $id];

			$_sub_sql = $this
				->where($_where)
				->fetchSql(true)
				->min($this->getPk());

			$_where = [];
			$_where[] = [$this->getPk(), 'EXP', Db::raw(" = ( {$_sub_sql} )")];

			$item = $this
				->field($field)
				->where($_where)
				->find();

			$itemArr = $this->cToArray($item);
			if ($itemArr === false) {
				return $this->return_error();
			}

			return return_status_ok_data($itemArr);
		} catch (Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	public function build_tree_list(&$list, $pid, $sourceArr, $level = 0, $path_id = [], $field_set = []) {
		if (empty($sourceArr)) {
			return;
		}
		
		$fp = $this->field_prefix;
		$_pid_field = !empty($field_set['pid']) ? $field_set['pid'] : $fp . 'pid';
		$_id_field = !empty($field_set['id']) ? $field_set['id'] : $fp . 'id';
		$_name_field = !empty($field_set['name']) ? $field_set['name'] : $fp . 'name';
		$_tree_title_field = !empty($field_set['tree_title']) ? $field_set['tree_title'] : 'tree_title';
		
		foreach ($sourceArr as &$item) {
			if (!isset($item[$_pid_field])) {
				continue;
			}
			
			$_id = $item[$_id_field];
			$_pid = $item[$_pid_field];
			$_item = $item;
			
			if ($pid == $_pid) {
				$_item[$_tree_title_field] = str_pad_unicode("", $level * 2, "—") . $item[$_name_field];
				$_item['path_id'] = $path_id;
				$_item['path_id'][] = $_id;
				$list[] = $_item;
				
				$this->build_tree_list($list, $_id, $sourceArr, $level + 1, $_item['path_id']);
			}
		}
	}
	
	/**
	 * 获取树列表
	 * @param array $where
	 * @param array $order
	 * @return array|mixed
	 * @throws Exception
	 */
	public function getTreeList($where = [], $order = []) {
		$reList = $this->getDataList($where, $order);
		if (!is_return_ok($reList)) {
			return $reList;
		}
		
		$reData = get_return_data($reList);
		$total = $reData['total'];
		$rows = $reData['data'];
		
		$list = [];
		$this->build_tree_list($list, 0, $rows, 0);
		
		$result = [
			'total' => $total,
			'data' => $list,
		];
		
		return return_status_ok_data($result);
	}
	
	public function build_tree(&$list, $pid, $sourceArr, $level = 0, $path_id = [], $field_set = []) {
		if (empty($sourceArr)) {
			return;
		}
		
		$fp = $this->field_prefix;
		$_pid_field = !empty($field_set['pid']) ? $field_set['pid'] : $fp . 'pid';
		$_id_field = !empty($field_set['id']) ? $field_set['id'] : $fp . 'id';
		$_children_field = !empty($field_set['children']) ? $field_set['children'] : 'children';
		
		foreach ($sourceArr as $item) {
			if (!isset($item[$_pid_field])) {
				continue;
			}
			
			$_id = $item[$_id_field];
			$_pid = $item[$_pid_field];
			$_item = $item;
			
			if ($pid == $_pid) {
				$_item[$_children_field] = [];
				$_item['path_id'] = $path_id;
				$_item['path_id'][] = $_id;
				$list[] = $_item;
				$this->build_tree($list[count($list) - 1][$_children_field], $_id, $sourceArr, $level + 1, $_item['path_id']);
			}
		}
	}
	
	/**
	 * 获取树
	 * @param array  $where
	 * @param array  $order
	 * @param string $field
	 * @return array|mixed
	 * @throws Exception
	 */
	public function getTree($where = [], $order = [], $field = '*') {
		$reList = $this->getDataList($where, $order, 1, PHP_INT_MAX, $field);
		if (!is_return_ok($reList)) {
			return $reList;
		}
		
		$reData = get_return_data($reList);
		$total = $reData['total'];
		$rows = $reData['data'];
		
		$list = [];
		$this->build_tree($list, 0, $rows, 0);
		
		$result = [
			//total' => $total,
			'data' => $list,
		];
		
		return return_status_ok_data($result);
	}

	/**
	 * 更改id
	 * @param $id
	 * @param $data
	 * @return array
	 */
	public function editById($id, $data, $checkExist = true) {
		$result = [];
		if (!$this->beforeEditById($id, $data, $result)) {
			return $result;
		}

		$re = $this->updateDataById($data, $id, $checkExist);
		if ($re === false) {
			return $this->return_error();
		}

		$result = [];
		if (!$this->afterEditById($id, $data, $result)) {
			return $result;
		}

		return return_status_ok();
	}

	public function beforeEditById($id, &$data, &$result = []) {
		$result = return_status_ok();
		return true;
	}

	public function afterEditById($id, $data, &$result = []) {
		$result = return_status_ok();
		return true;
	}

	/**
	 * 更改where
	 * @param $where
	 * @param $data
	 * @return array
	 */
	public function editByWhere($where, $data, $checkExist = true) {
		$result = [];
		if (!$this->beforeEditByWhere($where, $data, $result)) {
			return $result;
		}

		$re = $this->updateDataByWhere($data, $where, $checkExist);
		if ($re === false) {
			return $this->return_error();
		}

		//$result = [];
		if (!$this->afterEditByWhere($where, $data, $result)) {
			return $result;
		}

		return return_status_ok();
	}

	public function beforeEditByWhere($where, &$data, &$result = []) {
		$result = return_status_ok();
		return true;
	}

	public function afterEditByWhere($where, $data, &$result = []) {
		$result = return_status_ok();
		return true;
	}

	public function add($data) {
		$result = [];
		if (!$this->beforeAdd($data, $result)) {
			return $result;
		}

		$re = $this->createData($data);
		if ($re === false) {
			return $this->return_error();
		}
		
		$result = rsData(['id' => $re]);
		
		//$result = [];
		if (!$this->afterAdd($data, $result)) {
			return $result;
		}

		return return_status_ok_data(['id' => $re]);
	}

	public function beforeAdd(&$data, &$result = []) {
		$result = return_status_ok();
		return true;
	}

	public function afterAdd($data, &$result = []) {
		$result = return_status_ok();
		return true;
	}
	
	/**
	 * 删除id
	 * @param int  $id
	 * @param bool $delSon
	 * @return array
	 * @throws \think\exception\PDOException
	 */
	public function delById($id, $delSon = false, $softDel = true) {
		log_record("--- delById id=" . $id);
		$result = $this->getItemById($id);
		log_record("--- delById result=" . json_encode_u($result));
		if (!is_return_ok($result)) {
			return $result;
		}
		
		if (!$this->beforeDelById($id, $result)) {
			return $result;
		}

		$re = $this->delDataById($id, $delSon, $softDel);
		if ($re === false) {
			return $this->return_error();
		}

		//$result = [];
		if (!$this->afterDelById($id, $result)) {
			return $result;
		}

		return return_status_ok();
	}

	public function beforeDelById($id, &$result = []) {
		//$result = return_status_ok();
		return true;
	}

	public function afterDelById($id, &$result = []) {
		//$result = return_status_ok();
		return true;
	}

	/**
	 * 删除where
	 * @param $where
	 * @param $data
	 * @return array
	 */
	public function delByWhere($where, $delSon = false) {
		$result = $this->getList($where);
		if (!is_return_ok($result)) {
			return $result;
		}
		
		if (!$this->beforeDelByWhere($where, $result)) {
			return $result;
		}

		$re = $this->delDataByWhere($where, $delSon);
		if ($re === false) {
			return $this->return_error();
		}

		//$result = [];
		if (!$this->afterDelByWhere($where, $result)) {
			return $result;
		}

		return return_status_ok();
	}

	public function beforeDelByWhere($where, &$result = []) {
		//$result = return_status_ok();
		return true;
	}

	public function afterDelByWhere($where, &$result = []) {
		//$result = return_status_ok();
		return true;
	}
	
	/**
	 * 构建排序字段 需要继承类实现
	 * @param array $order_source   排序原型
	 * @return array
	 */
	public function makeSortField($order_source = []) {
		return $order_source;
	}
	
	public function getDir() {
		return __FILE__;
	}
	
	/**
	 * 构建mid 根据请求类型判断公众号还是小程序 筛选mpid或maid
	 * @param $where
	 * @return array
	 */
	// public function makeMidWhere(&$where) {
	// 	$addonParam = sessionOrGLOBALS('addonParam');
	// 	$addonType = $addonParam['addon_type'];
	// 	$mid = $addonParam['mid'];
	//
	// 	switch ($addonType) {
	// 		case 'mp':
	// 			$where[] = ['mpid', '=', $mid];
	// 			break;
	// 		case 'miniapp':
	// 			$where[] = ['maid', '=', $mid];
	// 			break;
	// 		default:
	// 			return rsErr('未知请求类型', 11010);
	// 	}
	//
	// 	return rsOk();
	// }
	
	/**
	 * 更改状态
	 * @param $id
	 * @param $status
	 * @return array
	 */
	public function setStatus($id, $status) {
		$field_status = $this->field_status;
		
		$_d = [];
		$_d[$field_status] = $status;
		$re = $this->editById($id, $_d);
		return $re;
	}
}
