<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller;

use app\sys\com\Rbac\common\model\Role;
use think\Db;

/**
 * Class Roles
 * 权限角色表
 * @api_name       角色管理
 * @api_type       2
 * @api_is_menu    0
 * @api_is_maker   1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package        app\sys\com\Rbac\admin\controller\logic
 */
class Roles extends \app\sys\com\Rbac\admin\controller\logic\Roles {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 获取列表
	 * 权限角色表
	 * @api_name 获取角色列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Roles.getList
	 *
	 * page_num
	 * page_limit
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getList() {
		$param = $this->param;
		
		$where = [];
		
		if (isset($param['keywords'])) {
			$keywords = $param['keywords'];
			$where[] = ['name|intro', 'like', "%{$keywords}%"];
		}
		
		$this->_buf['getList'] = [
			'link' => ['h_role_rule'],
			'where' => $where,
		];
		return parent::getList();
	}
	
	/**
	 * 获取详情 通过id查询
	 * 权限角色表
	 * @api_name 获取角色详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Roles.getItemById
	 *
	 * id
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getItemById() {
		$this->_buf['getItemById'] = [
			'link' => ['h_role_rule'],
		];
		return parent::getItemById();
	}
 
	/**
	 * 添加
	 * 权限角色表
	 * @api_name 添加角色
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Roles.add
	 *
	 * name				用户名
	 * intro			简介
	 * type				类型（0-未知 1-通用）
	 * status			状态,1启用 0禁用
	 * remark			备注
	 *
	 * @return mixed|string
	 */
	public function add() {
		$this->param['type'] = Role::$_TYPE['normal'];
		$this->param['status'] = Role::$_STATUS['enabled'];
		return parent::add();
	}
	
}
