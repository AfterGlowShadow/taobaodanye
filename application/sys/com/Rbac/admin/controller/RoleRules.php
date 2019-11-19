<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller;

use app\sys\com\Rbac\common\model\RoleRule;
use think\Db;

/**
 * Class RoleRules
 * 角色规则关联表
 * @api_name       角色规则关联管理
 * @api_type       2
 * @api_is_menu    0
 * @api_is_maker   1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package        app\sys\com\Rbac\admin\controller\logic
 */
class RoleRules extends \app\sys\com\Rbac\admin\controller\logic\RoleRules {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 获取管理员关联的角色ID列表
	 * 角色规则关联表
	 * @api_name 获取管理员关联的角色ID列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Rolerules.getRuleIDsList
	 *
	 * @return array|mixed|string
	 */
	public function getRuleIDsList() {
		/** @var $m RoleRule */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['role_id'];
		
		$re = $m->getRuleIDsList($uid);
		return return_json($re);
	}
	
	/**
	 * 获取管理员关联的角色列表
	 * 角色规则关联表
	 * @api_name 获取管理员关联的角色列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Rolerules.getRuleList
	 *
	 * @return array|mixed|string
	 */
	public function getRuleList() {
		/** @var $m RoleRule */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['role_id'];
		
		$re = $m->getRuleList($uid);
		return return_json($re);
	}
	
	/**
	 * 添加更改角色对应权限规则列表（批量）
	 * 角色规则关联表
	 * @api_name 添加更改角色对应权限规则列表（批量）
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Rolerules.setRules
	 *
	 * @return array|mixed|string
	 * @throws \Throwable
	 */
	public function setRules() {
		/** @var $m RoleRule */
		$m = $this->_model;
		$param = $this->param;
		
		$role_id = $param['role_id'];
		$rule_ids = isset($param['rule_ids']) ? json_decode($param['rule_ids'], true) : [];
		
		$re = $this->transaction(function () use ($m, $role_id, $rule_ids) {
			$re = $m->setRules($role_id, $rule_ids);
			return $re;
		});
		
		return return_json($re);
	}

}
