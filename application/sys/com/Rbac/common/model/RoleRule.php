<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\model;


class RoleRule extends \app\sys\com\Rbac\common\model\table\RoleRule {
	
	public static $_STATUS = [
		'disabled' => 0,
		'enabled' => 1,
	];
	
	public static $_MENU = [
		'no' => 0,
		'yes' => 1,
	];
	
	public function getRuleIDsList($role_id = []) {
		$ruleModel = new Rule();
		$sqlRule = $ruleModel
			->field('id')
			->where('status', '=', Rule::$_STATUS['enabled'])
			->where('id', '=', 'a.rule_id')
			->buildSql(true);
		
		$field = 'rule_id';
		$order = [];
		
		try {
			$list = $this
				->alias('a')
				->distinct(true)
				->field($field)
				->where('a.role_id', 'IN', $role_id)
				->whereExists($sqlRule)
				->order($order)
				->select();
			
			$reList = $this->cToArray($list);
			$rule_ids = [];
			
			foreach ($reList as $row) {
				$rule_ids[] = $row['rule_id'];
			}
			
			$result = [
				'rule_ids' => $rule_ids,
			];
			
			return rsData($result);
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	public function getRuleList($role_id = [], $urlNotEmpty = false, $is_root = false) {
		$field = 'b.*';
		$order = ['b.sort' => 'ASC'];
		
		try {
			if ($is_root) {
				$m = new Rule();
				$m = $m
					->alias('b')
					->where('b.status', Role::$_STATUS['enabled'])
					->order($order);
			} else {
				$m = $this
					->alias('a')
					->distinct(true)
					->field($field)
					->leftJoin('sys_rbac_rule b', 'b.id = a.rule_id')
					->where('a.role_id', 'IN', $role_id)
					->where('b.status', Role::$_STATUS['enabled'])
					->order($order);
			}
			
			if ($urlNotEmpty) {
				$m = $m->where('url', '<>', '');
			}
			
			$list = $m->select();
			
			$reList = $this->cToArray($list);
			
			$result = [
				'rules' => $reList,
			];
			
			return rsData($result);
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	/**
	 * 获取规则中属于菜单的列表 可返回树状
	 * @param array $role_id
	 * @param bool  $is_tree
	 * @param bool  $is_root
	 * @param int   $pid
	 * @return array
	 */
	public function getRuleMenuList($role_id = [], $is_tree = true, $is_root = false, $pid = 0) {
		$field = 'b.*';
		$order = ['b.sort' => 'ASC'];
		
		try {
			if ($is_root) {
				$m = new Rule();
				$m = $m
					->alias('b')
					->where('b.status', Role::$_STATUS['enabled'])
					->where('b.is_menu', self::$_MENU['yes'])
					->order($order);
			} else {
				$m = $this
					->alias('a')
					->distinct(true)
					->field($field)
					->leftJoin('sys_rbac_rule b', 'b.id = a.rule_id')
					->where('a.role_id', 'IN', $role_id)
					->where('b.status', Role::$_STATUS['enabled'])
					->where('b.is_menu', self::$_MENU['yes'])
					->order($order);
			}
			
			$list = $m->select();
			$reList = $this->cToArray($list);
			
			$result = [
				'menus' => $reList,
			];
			
			if ($is_tree) {
				$tree = [];
				
				// $t_data = [];
				// $i = 1;
				// foreach ($reList as $row) {
				// 	$_d = [];
				// 	$_d['id'] = $i;
				// 	$_d['pid'] = 0;
				// 	$_d['title'] = !empty($row['title']) ? $row['title'] : '';
				// 	$_d['title_path'] = explode("|", $_d['title']);
				//
				// 	$_tmp = $_d['title_path'];
				// 	$_tmp = end($_tmp);
				// 	$_d['title_name'] = $_tmp !== false ? $_tmp : '';
				//
				// 	$tmp = $_d['title_path'];
				// 	array_pop($tmp);
				// 	$_d['title_head'] = implode('|', $tmp);
				// 	$_d['data'] = $row;
				// 	$t_data[] = $_d;
				// 	$i++;
				// }
				//
				// foreach ($t_data as &$row) {
				// 	foreach ($t_data as $row2) {
				// 		if ($row['id'] != $row2['id'] && $row['title_head'] == $row2['title']) {
				// 			$row['pid'] = $row2['id'];
				// 			break;
				// 		}
				// 	}
				// }
				//
				// $this->build_tree($tree, 0, $t_data);
				$this->build_tree($tree, $pid, $reList);
				$result['menus'] = $tree;
			}
			
			return rsData($result);
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	public function setRules($role_id, $rule_ids = []) {
		// 检查管理员账号是否存在
		$roleModel = new Role();
		$re = $roleModel->getItemById($role_id);
		if (isErr($re)) {
			return $re;
		}
		
		$reRole = gData($re);
		if (empty($reRole)) {
			return rsErr('角色id无效', 10010);
		}
		
		// 先删除原有的
		$where = [];
		$where[] = ['role_id', '=', $role_id];
		$re = $this->delByWhere($where);
		if (isErr($re)) {
			return $re;
		}
		
		$ruleModel = new Rule();
		
		// 再添加新的
		foreach ($rule_ids as $item) {
			$re = $ruleModel->getItemById($item);
			if (isErr($re)) {
				return $re;
			}
			
			$reData = gData($re);
			if (empty($reData)) {
				return rsErr('存在无效的权限规则id', 10003);
			}
			
			$_d = [];
			$_d['role_id'] = $role_id;
			$_d['rule_id'] = $item;
			$_d['rule_url'] = $reData['url'];
			$re = $this->add($_d);
			if (isErr($re)) {
				return $re;
			}
		}
		
		return rsOk();
	}
	
	
}
