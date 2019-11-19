<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\model;


class Role extends \app\sys\com\Rbac\common\model\table\Role {
	
	public static $_TYPE = [
		'none' => 0,
		'normal' => 1,
	];
	
	public static $_STATUS = [
		'disabled' => 0,
		'enabled' => 1,
	];
	
	/**
	 * 关联规则
	 * @return \think\model\relation\hasMany
	 */
	public function hRoleRule() {
		$pre = config('database.prefix');
		$roleRule = "{$pre}" . 'sys_rbac_role_rule';
		
		return $this
			->hasMany('app\sys\com\Rbac\common\model\RoleRule', 'role_id', 'id')
			->leftJoin('sys_rbac_rule b', "b.id={$roleRule}.rule_id")
			->field("{$roleRule}.role_id, {$roleRule}.rule_id, b.name, b.intro");
	}
	
	public function afterDelById($id, &$result = []) {
		$userRoleModel = new UserRole();
		$_w = [];
		$_w[] = ['role_id', '=', $id];
		$re = $userRoleModel->delByWhere($_w);
		if (isErr($re)) {
			$result = $this->return_error();
			return false;
		}
		
		return parent::afterDelById($id, $result);
	}
	
	public function afterDelByWhere($where, &$result = []) {
		// ——查询删除的数据 提取相关信息
		$reData = glData($result);
		if (empty($reData)) {
			return true;
		}
		
		$role_ids = [];
		foreach ($reData as $row) {
			$role_ids[] = $row['id'];
		}
		
		if (!empty($role_ids)) {
			$userRoleModel = new UserRole();
			$_w = [];
			$_w[] = ['role_id', 'IN', $role_ids];
			$re = $userRoleModel->delByWhere($_w);
			if (isErr($re)) {
				$result = $this->return_error();
				return false;
			}
		}
		
		return parent::afterDelByWhere($where, $result);
	}

}
