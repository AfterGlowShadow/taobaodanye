<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\model;


use app\sys\com\base\common\v1\traits\VarBase;
use think\Db;

class UserRole extends \app\sys\com\Rbac\common\model\table\UserRole {
	//use VarBase;
	
	public function getRoleIDsList($uid) {
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
		
		$roleModel = new Role();
		$sqlRole = $roleModel
			->field('id')
			->where('status', '=', Role::$_STATUS['enabled'])
			->where('id', '=', 'a.role_id')
			->buildSql(true);
		
		$field = 'role_id';
		$order = [];
		
		try {
			$m = $this
				->alias('a')
				->distinct(true)
				->field($field)
				->where('a.user_id', $uid)
				->whereExists($sqlRole)
				->order($order);
			
			$list = $m->select();
			
			$reList = $this->cToArray($list);
			$role_ids = [];
			
			foreach ($reList as $row) {
				$role_ids[] = $row['role_id'];
			}
			
			$result = [
				'role_ids' => $role_ids,
			];
			
			return rsData($result);
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	public function getRoleList($uid) {
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
		
		$field = 'b.*';
		$order = [];
		
		try {
			$m = $this
				->alias('a')
				->distinct(true)
				->field($field)
				->leftJoin('sys_rbac_role b', 'b.id = a.role_id')
				->where('a.user_id', $uid)
				->where('b.status', Role::$_STATUS['enabled'])
				->order($order);
			
			$list = $m->select();
			
			$reList = $this->cToArray($list);
			
			$result = [
				'roles' => $reList,
			];
			
			return rsData($result);
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	/**
	 * 获取管理员角色对应规则列表
	 * @param      $uid
	 * @param bool $is_root
	 * @return array
	 */
	public function getUserRoleRuleList($uid, $is_root = false) {
		$role_ids = [];
		if (!$is_root) {
			// 先获取用户对应角色ID列表
			$re = $this->getRoleIDsList($uid);
			if (isErr($re)) {
				return $re;
			}
			
			$reData = gData($re);
			if (empty($reData)) {
				$result = [
					'rules' => [],
				];
				return rsData($result);
			}
			
			// 再获取角色对应规则列表
			$role_ids = $reData['role_ids'];
		}
		
		$roleRuleModel = new RoleRule();
		$re = $roleRuleModel->getRuleList($role_ids, true, $is_root);
		return $re;
	}
	
	/**
	 * 获取管理员角色对应菜单列表
	 * @param      $uid
	 * @param bool $is_tree 是否返回树状
	 * @param bool $is_root
	 * @param int  $pid
	 * @return array
	 */
	public function getUserRoleRuleMenuList($uid, $is_tree = true, $is_root = false, $pid = 0) {
		$role_ids = [];
		
		if (!$is_root) {
			// 先获取用户对应角色ID列表
			$re = $this->getRoleIDsList($uid);
			if (isErr($re)) {
				return $re;
			}
			
			$reData = gData($re);
			
			if (empty($reData)) {
				$result = [
					'rules' => [],
				];
				return rsData($result);
			}
			
			// 再获取角色对应规则列表
			$role_ids = $reData['role_ids'];
		}
		
		$roleRuleModel = new RoleRule();
		$re = $roleRuleModel->getRuleMenuList($role_ids, $is_tree, $is_root, $pid);
		return $re;
	}
	
	/**
	 * 获取管理员角色对应拒绝访问的规则列表
	 * @param      $uid
	 * @param bool $is_root
	 * @return array
	 * @throws \think\Exception
	 */
	public function getUserRoleRuleRejectList($uid, $is_root = false) {
		if ($is_root) {
			$result = [
				'rules' => [],
			];
			return rsData($result);
		}
		
		$ruleModel = new Rule();
		
		// $_addon_param = session('addonParam');
		// $_mid = isset($_addon_param['mid']) ? $_addon_param['mid'] : 0;
		
		// 先获取用户对应角色ID列表
		$re = $this->getRoleIDsList($uid);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		if (empty($reData)) {
			// 如果是空的就返回所有列表
			$_field = 'url';
			$where = [];
			$where[] = ['url', '<>', ''];
			$where[] = ['is_auth', '=', 1];
			$re = $ruleModel->getList($where, [], 1, PHP_INT_MAX, $_field);
			if (isErr($re)) {
				return $re;
			}
			
			$_reRule = glData($re);
			$_urls = array_column($_reRule, 'url');
			
			$result = [
				'rules' => $_urls,
			];
			return rsData($result);
		}
		
		// 再获取角色对应规则id列表
		$role_ids = $reData['role_ids'];
		
		$roleRuleModel = new RoleRule();
		$re = $roleRuleModel->getRuleIDsList($role_ids);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		$_rule_ids = [];
		if (!empty($reData)) {
			$_rule_ids = $reData['rule_ids'];
		}
		
		$_field = 'url';
		$_where = [];
		$_where[] = ['id', 'NOT IN', $_rule_ids];
		$_where[] = ['url', '<>', ''];
		$_where[] = ['is_auth', '=', 1];
		$re = $ruleModel->getList($_where, [], 1, PHP_INT_MAX, $_field);
		if (isErr($re)) {
			return $re;
		}
		
		$_reRule = glData($re);
		
		$result = [
			'rules' => array_column($_reRule, 'url'),
		];
		return rsData($result);
	}
	
	public function setRoles($uid, $role_ids = []) {
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
		
		// 先删除原有的
		$where = [];
		$where[] = ['user_id', '=', $uid];
		$re = $this->delByWhere($where);
		if (isErr($re)) {
			return $re;
		}
		
		$roleModel = new Role();
		
		// 再添加新的
		foreach ($role_ids as $item) {
			$re = $roleModel->getItemById($item);
			if (isErr($re)) {
				return $re;
			}
			
			$reData = gData($re);
			if (empty($reData)) {
				return rsErr('存在无效的角色id', 10003);
			}
			
			$_d = [];
			$_d['user_id'] = $uid;
			$_d['role_id'] = $item;
			$re = $this->add($_d);
			if (isErr($re)) {
				return $re;
			}
		}
		
		return rsOk();
	}

}
