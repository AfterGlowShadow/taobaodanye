<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\model;


class UserStore extends \app\sys\com\Rbac\common\model\table\UserStore {
	
	public static $_IDENTITY_TYPE = [
		'none' => 0,
		'manager' => 1, // 店长
		'clerk' => 2, // 店员
	];
	
	/**
	 * 关联用户
	 * @return \think\model\relation\BelongsTo
	 */
	public function hUser() {
		return $this
			->belongsTo('app\sys\com\Rbac\common\model\User', 'user_id', 'id')
			->field("id, name, nickname, avatar, mobile");
	}
	
	/**
	 * 关联店铺
	 * @return \think\model\relation\BelongsTo
	 */
	public function hStore() {
		return $this
			->belongsTo('app\sys\com\Rbac\common\model\Store', 'store_id', 'id')
			->field("id, name, province, city, area, address");
	}
	
	public function getStoreIDsList($uid) {
		// 检查管理员账号是否存在
		$userModel = new User();
		$re = $userModel->findUser_Uid($uid);
		if (isErr($re)) {
			return $re;
		}
		
		$reAdmin = gData($re);
		if ($reAdmin['status'] == User::$_STATUS['disabled']) {
			return rsErr('管理员账号已禁用', 10010);
		}
		
		$storeModel = new Store();
		$sqlStore = $storeModel
			->field('id')
			//->where('status', '=', Role::$_STATUS['enabled'])
			->where('id', '=', 'a.store_id')
			->buildSql(true);
		
		$field = 'store_id';
		$order = [];
		
		try {
			$list = $this
				->alias('a')
				->distinct(true)
				->field($field)
				->where('a.user_id', $uid)
				->whereExists($sqlStore)
				->order($order)
				->select();
			
			$reList = $this->cToArray($list);
			$store_ids = [];
			
			foreach ($reList as $row) {
				$store_ids[] = $row['store_id'];
			}
			
			$result = [
				'store_ids' => $store_ids,
			];
			
			return rsData($result);
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	public function getStoreList($uid) {
		// 检查管理员账号是否存在
		$userModel = new User();
		$re = $userModel->findUser_Uid($uid);
		if (isErr($re)) {
			return $re;
		}
		
		$reAdmin = gData($re);
		if ($reAdmin['status'] == User::$_STATUS['disabled']) {
			return rsErr('管理员账号已禁用', 10010);
		}
		
		$field = 'a.identity_type, b.*';
		$order = [];
		
		try {
			$list = $this
				->alias('a')
				->distinct(true)
				->field($field)
				->leftJoin('sys_rbac_store b', 'b.id = a.store_id')
				->where('a.user_id', $uid)
				// ->where('b.status', Role::$_STATUS['enabled'])
				->order($order)
				->select();
			
			$reList = $this->cToArray($list);
			
			$result = [
				'stores' => $reList,
			];
			
			return rsData($result);
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	public function setStores($uid, $stores = []) {
		// 检查管理员账号是否存在
		$userModel = new User();
		$re = $userModel->findUser_Uid($uid);
		if (isErr($re)) {
			return $re;
		}
		
		$reAdmin = gData($re);
		if ($reAdmin['status'] == User::$_STATUS['disabled']) {
			return rsErr('管理员账号已禁用', 10010);
		}
		
		// 获取原有数据
		$where = [];
		$where[] = ['user_id', '=', $uid];
		$field = '*, create_time AS ct, update_time AS ut';
		$re = $this->getList($where, [], 1, PHP_INT_MAX, $field);
		if (isErr($re)) {
			return $re;
		}
		
		$reUserStore = glData($re);
		$_userStores = [];
		if (!empty($reUserStore)) {
			foreach ($reUserStore as $item) {
				$_userStores[$item['store_id']] = $item;
			}
		}
		
		// 先删除原有的
		$re = $this->delByWhere($where);
		if (isErr($re)) {
			return $re;
		}
		
		$storeModel = new Store();
		
		// 再添加新的
		foreach ($stores as $item) {
			if (!isset($item['id']) || !isset($item['id_type'])) {
				return rsErr('存在无效数据', 10003);
			}
			
			$re = $storeModel->getItemById($item['id']);
			if (isErr($re)) {
				return $re;
			}
			
			$reData = gData($re);
			if (empty($reData)) {
				return rsErr('存在无效的店铺id', 10003);
			}
			
			$_d = [];
			$_d['user_id'] = $uid;
			$_d['store_id'] = $item['id'];
			$_d['identity_type'] = $item['id_type'];
			if (isset($_userStores[$item['id']])) {
				$_d['create_time'] = $_userStores[$item['id']]['ct'];
				$_d['update_time'] = $_userStores[$item['id']]['ut'];
			}
			$re = $this->add($_d);
			if (isErr($re)) {
				return $re;
			}
		}
		
		return rsOk();
	}

}
