<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller;

use app\sys\com\Rbac\common\model\Rule;
use think\Db;

/**
 * Class Rules
 * 权限规则表
 * @api_name       权限规则
 * @api_type       2
 * @api_is_menu    0
 * @api_is_maker   1
 * @api_is_show 0
 * @api_is_def_name 0
 * @package        app\sys\com\Rbac\admin\controller\logic
 */
class Rules extends \app\sys\com\Rbac\admin\controller\logic\Rules {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 获取权限规则树状列表
	 * 权限规则表
	 * @api_name       获取权限规则树状列表
	 * @api_type       2
	 * @api_is_menu    0
	 * @api_is_maker   1
	 * @api_is_auth    1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_is_rule_db 0
	 * @api_url        /sys/admin/Rbac.v1.Rules.getTreeList
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 * @throws \Throwable
	 */
	public function getTreeList() {
		/** @var $m Rule */
		$m = $this->_model;
		$param = $this->param;
		
		$where = [];
		$where[] = ['status', '=', Rule::$_STATUS['enabled']];
		
		$order = ['sort' => 'ASC'];
		
		$re = $m->getTreeList($where, $order);
		return return_json($re);
	}
	
	/**
	 * 获取权限规则树
	 * 权限规则表
	 * @api_name       获取权限规则树
	 * @api_type       2
	 * @api_is_menu    0
	 * @api_is_maker   1
	 * @api_is_auth    1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url        /sys/admin/Rbac.v1.Rules.getTree
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 * @throws \Throwable
	 */
	public function getTree() {
		/** @var $m Rule */
		$m = $this->_model;
		$param = $this->param;
		
		$where = [];
		$where[] = ['status', '=', Rule::$_STATUS['enabled']];
		
		$order = ['sort' => 'ASC'];
		$field = 'id, pid, name, title, icon, intro, url, type, sort, remark';
		
		$re = $m->getTree($where, $order, $field);
		return return_json($re);
	}
	
	/**
	 * 获取列表
	 * 权限规则表
	 * @api_name 获取权限规则列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_is_rule_db 0
	 * @api_url /sys/admin/Rbac.v1.Rules.getList
	 *
	 * page_num
	 * page_limit
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getList() {
		return parent::getList();
	}
	
	/**
	 * 获取详情 通过id查询
	 * 权限规则表
	 * @api_name 获取权限规则详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_is_rule_db 0
	 * @api_url /sys/admin/Rbac.v1.Rules.getItemById
	 *
	 * id
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getItemById() {
		return parent::getItemById();
	}
	
	/**
	 * 添加
	 * 权限规则表
	 * @api_name 添加权限规则
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_is_rule_db 0
	 * @api_url /sys/admin/Rbac.v1.Rules.add
	 */
	public function add() {
		return parent::add();
	}
	
	/**
	 * 更改
	 * 权限规则表
	 * @api_name       更改权限规则
	 * @api_type       2
	 * @api_is_menu    0
	 * @api_is_maker   1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_is_rule_db 0
	 * @api_url        /sys/admin/Rbac.v1.Rules.edit
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 * @throws \Throwable
	 */
	public function edit() {
    	$re = $this->transaction(function () {
		    $re = parent::edit();
		    return $re->getData();
	    });
		return return_json($re);
	}
	
	/**
	 * 删除
	 * 权限规则表
	 * @api_name       删除权限规则
	 * @api_type       2
	 * @api_is_menu    0
	 * @api_is_maker   1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_is_rule_db 0
	 * @api_url        /sys/admin/Rbac.v1.Rules.delete
	 *
	 * @return array|mixed|\Services_JSON_Error|string|\think\response\Json
	 * @throws \Throwable
	 */
	public function delete() {
		$re = $this->transaction(function () {
			$re = parent::delete();
			return $re->getData();
		});
		return return_json($re);
	}
}
