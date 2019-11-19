<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\model;


class Rule extends \app\sys\com\Rbac\common\model\table\Rule {
	
	public static $_STATUS = [
		'disabled' => 0,
		'enabled' => 1,
	];
	
	public static $_TYPE = [
		'none' => 0,
		'common' => 1,
		'after' => 2,
		'front' => 3,
	];
	
	// public static $_ADDON_TYPE = [
	// 	'none' => 0,
	// 	'mp' => 1,
	// 	'miniapp' => 2,
	// ];
	
	public function afterEditById($id, $data, &$result = []) {
		$roleRuleModel = new RoleRule();
		$_w = [];
		$_w[] = ['rule_id', '=', $id];
		$_d = [];
		$_d['rule_url'] = $data['url'];
		$re = $roleRuleModel->editByWhere($_w, $_d);
		if (isErr($re)) {
			$result = $this->return_error();
			return false;
		}
		
		return parent::afterEditById($id, $data, $result);
	}
	
	public function afterEditByWhere($where, $data, &$result = []) {
		// ——查询删除的数据 提取相关信息
		$reData = glData($result);
		if (empty($reData)) {
			return true;
		}
		
		foreach ($reData as $row) {
			$rule_id = $row['id'];
			return $this->afterEditById($rule_id, $data, $result);
		}
		
		return parent::afterEditByWhere($where, $data, $result);
	}
	
	public function afterDelById($id, &$result = []) {
		$roleRuleModel = new RoleRule();
		$_w = [];
		$_w[] = ['rule_id', '=', $id];
		$re = $roleRuleModel->delByWhere($_w);
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
		
		$rule_ids = [];
		foreach ($reData as $row) {
			$rule_ids[] = $row['id'];
		}
		
		if (!empty($rule_ids)) {
			$roleRuleModel = new RoleRule();
			$_w = [];
			$_w[] = ['rule_id', 'IN', $rule_ids];
			$re = $roleRuleModel->delByWhere($_w);
			if (isErr($re)) {
				$result = $this->return_error();
				return false;
			}
		}
		
		return parent::afterDelByWhere($where, $result);
	}
	
}
