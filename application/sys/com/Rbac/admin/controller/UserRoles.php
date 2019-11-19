<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller;

use app\sys\com\Rbac\common\model\UserRole;
use think\Db;

/**
 * Class UserRoles
 * 管理员角色关联表
 * @api_name       管理员角色关联
 * @api_type       2
 * @api_is_menu    0
 * @api_is_maker   1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package        app\sys\com\Rbac\admin\controller\logic
 */
class UserRoles extends \app\sys\com\Rbac\admin\controller\logic\UserRoles {

    public function init_before() {
        parent::init_before();


    }
    
	/**
	 * 获取管理员关联的角色ID列表
	 * 管理员角色关联表
	 * @api_name 获取管理员关联的角色ID列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userroles.getRoleIDsList
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function getRoleIDsList() {
		/** @var $m UserRole */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['aid'];
		
		$re = $m->getRoleIDsList($uid);
		return return_json($re);
	}
	
	/**
	 * 获取管理员关联的角色列表
	 * 管理员角色关联表
	 * @api_name 获取管理员关联的角色列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userroles.getRoleList
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function getRoleList() {
		/** @var $m UserRole */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['aid'];
		
		$re = $m->getRoleList($uid);
		return return_json($re);
	}
	
	/**
	 * 获取用户角色对应规则列表
	 * 管理员角色关联表
	 * @api_name 获取用户角色对应规则列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userroles.getUserRoleRuleList
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function getUserRoleRuleList() {
		/** @var $m UserRole */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['aid'];
		
		$re = $m->getUserRoleRuleList($uid);
		return return_json($re);
	}
	
	/**
	 * 获取管理员角色对应拒绝访问的规则列表
	 * 管理员角色关联表
	 * @api_name 获取管理员角色对应拒绝访问的规则列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userroles.getUserRoleRuleRejectList
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 * @throws \think\Exception
	 */
	public function getUserRoleRuleRejectList() {
		/** @var $m UserRole */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['aid'];
		
		$re = $m->getUserRoleRuleRejectList($uid);
		return return_json($re);
	}
	
	/**
	 * 获取管理员角色对应菜单列表
	 * 管理员角色关联表
	 * @api_name 获取管理员角色对应菜单列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userroles.getUserRoleRuleMenuList
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function getUserRoleRuleMenuList() {
		/** @var $m UserRole */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['aid'];
		$is_tree = isset($param['is_tree']) ? $param['is_tree'] : 1;
		
		$re = $m->getUserRoleRuleMenuList($uid, $is_tree);
		return return_json($re);
	}
	
	/**
	 * 添加更改管理员对应角色列表（批量）
	 * 管理员角色关联表
	 * @api_name 添加更改管理员对应角色列表（批量）
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userroles.setRoles
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 * @throws \Throwable
	 */
	public function setRoles() {
		/** @var $m UserRole */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['aid'];
		$role_ids = isset($param['role_ids']) ? json_decode($param['role_ids'], true) : [];
		
		$re = $this->transaction(function () use ($m, $uid, $role_ids) {
			$re = $m->setRoles($uid, $role_ids);
			return $re;
		});
		
		return return_json($re);
	}
	
	
}
