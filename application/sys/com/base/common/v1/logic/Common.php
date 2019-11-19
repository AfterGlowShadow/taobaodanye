<?php
// +----------------------------------------------------------------------
// | Description: 公共模型,所有模型都可继承此模型，基于RESTFUL CRUD操作
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\logic;

use app\sys\com\base\common\v1\traits\Base;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Model;

class Common extends Model {
	use Base;
	
	protected $field_prefix           = '';
	protected $createTime             = '';
	protected $updateTime             = '';
	
	protected $enabled_validate_add   = false;
	protected $enabled_validate_edit  = false;
	protected $enabled_validate_editw = false;
	
	protected $enabled_validate_add_obj     = null;
	protected $enabled_validate_edit_obj    = null;
	protected $enabled_validate_editw_obj   = null;
	
	public    $tmp_scene              = ''; // 临时验证场景 验证过后就清空 用于那些非add、edit的特殊场景 需要用时临时设置
	public    $validate_model         = 'common';
	
	public function getFieldPrefix() {
		return $this->field_prefix;
	}
	
	public function getEnabledValidateAdd() {
		return $this->enabled_validate_add;
	}
	
	public function getEnabledValidateEdit() {
		return $this->enabled_validate_edit;
	}
	
	public function getEnabledValidateEditW() {
		return $this->enabled_validate_editw;
	}
	
	/**
	 * 错误信息按格式返回
	 * @param string $msg
	 * @return array
	 */
	public function return_error($msg = '') {
		if (empty($msg)) {
			$e = $this->getError();
			empty($e) && $e = '数据操作失败';
		} else {
			$e = $msg;
		}

		return return_status_err($e, 10009);
	}

	/**
	 * 根据主键获取详情
	 * @param     string $id [主键]
	 * @return Common|bool|null
	 */
	public function getDataById($id = '') {
		try {
			$data = $this->get($id);
			if (!$data) {
				$this->error = '暂无此数据';
				return false;
			}
			return $data;
		} catch (Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return false;
		}
	}

	/**
	 * 获取单项
	 * @param array $where
	 * @return array
	 */
	public function getDataByWhere($where = []) {
		try {
			$re = $this->where($where)->find();
		} catch (Exception $e) {
			$this->error = $e->getMessage();
			return $this->return_error();
		}
		$reArr = $this->cToArray($re);
		if ($reArr === false) {
			return $this->return_error();
		}
		return return_status_ok_data($reArr);
	}
	
	/**
	 * 列表
	 * @param array  $where
	 * @param array  $order
	 * @param int    $page  当前页数
	 * @param int    $limit 每页数量
	 * @param string $field
	 * @return array
	 * @throws Exception
	 */
	public function getDataList($where = [], $order = [], $page = 1, $limit = PHP_INT_MAX, $field = '*') {
		$_where = [];
		$_where = array_merge($_where, $where);
		$dataCount = $this->where($_where)->count($this->getPk());

		$listM = $this;

		// 若有分页
		if ($page && $limit) {
			$listM = $listM->page($page, $limit);
		}

		$listM = $listM
			->field($field)
			->where($_where);

		if (!empty($order)) {
			$listM = $listM->order($order);
		}

		try {
			$list = $listM->select();
		} catch (Exception $e) {
			return $this->return_error();
		}

		if ($list === false) {
			return $this->return_error();
		}

		$arrList = $this->cToArray($list);
		log_record("--- list=" . json_encode($list, JSON_UNESCAPED_UNICODE));
		log_record("--- list sql=" . $this->getLastSql());

		$data = [
			'total' => $dataCount,
			'data' => $arrList,
			//'objData' => $list,
		];

		return return_status_ok_data($data);
	}

	/**
	 * 保存数据 存在就更新 不存在就新增
	 * @param array $data
	 * @param array $where
	 * @return array|bool|false|\PDOStatement|string|Model
	 */
	public function saveData($data, $where) {
		try {
			$re = $this->where($where)->find();

			if ($re === false) {
				return false;
			}

			if (empty($re)) {
				$re = $this->save($data);
			} else {
				$re = $this->save($data, $where);
			}

			return $re;
		} catch (Exception $e) {
			$this->error = $e->getMessage();
			return false;
		}
	}

	/**
	 * 新增多条数据
	 * @param $dataList
	 * @return bool
	 */
	public function createDataList($dataList) {
		try {
			$re = $this->saveAll($dataList, false);
			if ($re === false) {
				return false;
			}

			return true;
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '添加失败' : $e->getMessage();
			return false;
		}
	}

	/**
	 * 新建
	 * @param array $param
	 * @return bool array
	 */
	public function createData($param) {
		// 验证
		if ($this->enabled_validate_add) {
			//$validate = app()->validate($this->name, 'validate', false, $this->validate_model);
			$validate = $this->enabled_validate_add_obj;
			if (!$validate->scene(empty($this->tmp_scene) ? 'add' : $this->tmp_scene)->check($param)) {
				$this->tmp_scene = '';
				$this->error = $validate->getError();
				return false;
			}
			$this->tmp_scene = '';
		}

		try {
			//$re = $this->isUpdate(false)->allowField(true)->save($param, [], $this->getPk());
			$re = $this->data($param)->allowField(true)->insertData($this->getPk());
			//$re = $this->insert($param, false, true, $this->getPk());
			if ($re !== false) {
				//$id = $this->getLastInsID($this->getPk());
				$id = $this->getKey();
				if (!empty($id)) {
					$id = (int)$id;
				}
				return $id;
			}

			return false;
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '添加失败' : $e->getMessage();
			return false;
		}
	}

	/**
	 * 编辑
	 * @param $param
	 * @param $id
	 * @return bool
	 */
	public function updateDataById($param, $id, $checkExist = true) {
		try {
			if (empty($param)) {
				$this->error = '更改数据为空';
				return false;
			}

			if ($checkExist) {
				$checkData = $this->get($id);
				if (!$checkData) {
					$this->error = '暂无此数据';
					return false;
				}
			}
			
			$pk = $this->getPk();

			// 验证
			if ($this->enabled_validate_edit) {
				// $validate = app()->validate($this->name, 'validate', false, $this->validate_model);
				$validate = $this->enabled_validate_edit_obj;
				$_d = [$pk => $id];
				$_d = array_merge($_d, $param);
				if (!$validate->scene(empty($this->tmp_scene) ? 'edit' : $this->tmp_scene)->check($_d)) {
					$this->tmp_scene = '';
					$this->error = $validate->getError();
					return false;
				}
				$this->tmp_scene = '';
			}

			//$this->allowField(true)->save($param, [$this->getPk() => $id]);
			
			// save好像有问题 有时莫名其妙更新失败（TP5框架问题 不是我干的）改为update 这样会不能自动更新时间 失去事件 等待TP5更新
			if ($this->autoWriteTimestamp && !empty($this->updateTime)) {
				$param[$this->updateTime] = time();
			}
			
			$re = $this->allowField(true)->where($pk, $id)->update($param);
			return $re;
		} catch (\Exception $e) {
			$this->error = '编辑失败 ' . $e->getMessage();
			return false;
		}
	}

	/**
	 * 编辑
	 * @param $param
	 * @param $where
	 * @return bool
	 */
	public function updateDataByWhere($param, $where, $checkExist = true) {
		try {
			if (empty($param)) {
				$this->error = '更改数据为空';
				return false;
			}
			
			if ($checkExist) {
				$checkData = $this->where($where)->find();
				if (!$checkData) {
					$this->error = '暂无此数据';
					return false;
				}
			}

			// 验证
			if ($this->enabled_validate_editw) {
				// $validate = app()->validate($this->name, 'validate', false, $this->validate_model);
				$validate = $this->enabled_validate_editw_obj;
				
				$_d = [];
				$_d = array_merge($_d, $param);
				
				if (!$validate->scene(empty($this->tmp_scene) ? 'editw' : $this->tmp_scene)->check($_d)) {
					$this->tmp_scene = '';
					$this->error = $validate->getError();
					return false;
				}
				$this->tmp_scene = '';
			}

			$this->allowField(true)->save($param, $where);
			return true;
		} catch (\Exception $e) {
			$this->error = '编辑失败';
			return false;
		}
	}
	
	/**
	 * 根据id删除数据
	 * @param string  $id     主键
	 * @param boolean $delSon 是否删除子孙数据
	 * @param bool    $softDel 是否软删除
	 * @return bool
	 */
	public function delDataById($id = '', $delSon = false, $softDel = true) {
		//$this->startTrans();
		try {
			// $checkData = $this->get($id);
			// if (!$checkData) {
			// 	$this->error = '暂无此数据';
			// 	return false;
			// }
			
			if ($softDel) {
				$this->destroy($id);
			} else {
				//$this->where($this->getPk(), $id)->delete(true);
				//$this->destroy($id, true);
				$this->execute("DELETE FROM `" . $this->getTable() . "` WHERE `" . $this->getPk() . "` = :id", ['id' => $id]);
			}
			
			if ($delSon && is_numeric($id)) {
				// 删除子孙
				$childIds = $this->getAllChild($id);
				if ($childIds) {
					$this->where($this->getPk(), 'in', $childIds)->delete();
				}
			}
			//$this->commit();
			return true;
		} catch (\Exception $e) {
			$this->error = '删除失败';
			//$this->rollback();
			return false;
		}
	}

	/**
	 * 批量删除数据
	 * @param array   $ids    主键数组
	 * @param boolean $delSon 是否删除子孙数据
	 * @return bool
	 */
	public function delDatas($ids = [], $delSon = false) {
		if (empty($ids)) {
			$this->error = '删除失败';
			return false;
		}
		
		if (is_string($ids)) {
			$ids = json_decode($ids, true);
		}

		// 查找所有子元素
		if ($delSon) {
			foreach ($ids as $k => $v) {
				if (!is_numeric($v)) continue;
				$childIds = $this->getAllChild($v);
				$ids      = array_merge($ids, $childIds);
			}
			$ids = array_unique($ids);
		}

		try {
			$this->where($this->getPk(), 'in', $ids)->delete();
			return true;
		} catch (\Exception $e) {
			$this->error = '操作失败';
			return false;
		}

	}
	
	/**
	 * 删除where
	 * @param array $where
	 * @param bool  $delSon
	 * @return bool
	 */
	public function delDataByWhere($where = [], $delSon = false) {
		//$this->startTrans();
		try {
			// $checkData = $this->where($where)->find();
			// if (!$checkData) {
			// 	$this->error = '暂无此数据';
			// 	return false;
			// }
			
			$ids = $this->where($where)->column($this->getPk());
			if (empty($ids)) {
				// $this->error = '暂无此数据';
				return true;
			}
			
			// 查找所有子元素
			if ($delSon) {
				foreach ($ids as $k => $v) {
					if (!is_numeric($v)) continue;
					$childIds = $this->getAllChild($v);
					$ids      = array_merge($ids, $childIds);
				}
				//$ids = array_unique($ids);
			}
			
			$this->where($where)->delete();

			return true;
		} catch (\Exception $e) {
			$this->error = '删除失败';
			return false;
		}
	}

	/**
	 * 批量启用、禁用
	 * @param array   $ids    主键数组
	 * @param integer $status 状态1启用0禁用
	 * @param boolean $delSon 是否删除子孙数组
	 * @return bool
	 */
	public function enableDatas($ids = [], $status = 1, $delSon = false) {
		if (empty($ids)) {
			$this->error = '删除失败';
			return false;
		}
		
		if (is_string($ids)) {
			$ids = json_decode($ids, true);
		}

		// 查找所有子元素
		if ($delSon && $status === '0') {
			foreach ($ids as $k => $v) {
				$childIds = $this->getAllChild($v);
				$ids      = array_merge($ids, $childIds);
			}
			$ids = array_unique($ids);
		}
		try {
			$this->where($this->getPk(), 'in', $ids)->setField('status', $status);
			return true;
		} catch (\Exception $e) {
			$this->error = '操作失败';
			return false;
		}
	}

	/**
	 * 获取所有子孙
	 * @param       $id
	 * @param array $data
	 * @return array
	 */
	public function getAllChild($id, &$data = []) {
		$map[$this->field_prefix . 'pid'] = $id;
		$childIds   = $this->where($map)->column($this->getPk());
		if (!empty($childIds)) {
			foreach ($childIds as $v) {
				$data[] = $v;
				$this->getAllChild($v, $data);
			}
		}
		return $data;
	}

	/**
	 * 数据集转数组
	 * @param array|Model $re
	 * @return array|false
	 */
	public function cToArray($re) {
		if ($re === false) {
			return $re;
		} else if (empty($re)) {
			return [];
		}

		return $re->toArray();
	}

	/**
	 * 构建逗号查询where
	 * @param $where
	 * @param $field
	 * @param array $searchArr 多个条件的数组 例如：[1,2,3] 会生成3条AND FIND_IN_SET条件
	 */
	public static function makeWhereFindInSet(&$where, $field, $searchArr) {
		// if (is_string($searchArr)) {
		// 	$where[] = ["", 'EXP', Db::raw(" FIND_IN_SET('{$searchArr}', {$field}) ")];
		// } elseif (is_array($searchArr)) {
		// 	foreach ($searchArr as $item) {
		// 		$where[] = ['', 'exp', Db::raw(" FIND_IN_SET('{$item}', {$field}) ")];
		// 	}
		// }
		
		if (is_array($searchArr)) {
			foreach ($searchArr as $item) {
				$where[] = ['', 'exp', Db::raw(" FIND_IN_SET('{$item}', {$field}) ")];
			}
		} else {
			$where[] = ["", 'EXP', Db::raw(" FIND_IN_SET('{$searchArr}', {$field}) ")];
		}
	}

}