<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\admin\controller;

use app\sys\com\User\common\model\User;
use think\Db;

/**
 * Class Users
 * 用户表
 * @api_name 用户管理
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\User\admin\controller\logic
 */
class Users extends \app\sys\com\User\admin\controller\logic\Users {
	
    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 获取列表
	 * 用户表
	 * @api_name 获取用户列表
	 * @api_type 2
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Users.getList
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
			$where[] = ['mobile|nickname', 'like', "%{$keywords}%"];
		}
		
		$this->_buf['getList'] = [
			'where' => $where,
			'param' => [
				'func' => function ($_m) {
					/** @var User $_m */
					$_m = $_m->hidden(['passwd']);
					return $_m;
				}
			]
		];
		return parent::getList();
	}
	
	/**
	 * 获取详情 通过id查询
	 * 用户表
	 * @api_name 获取用户详情
	 * @api_type 2
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Users.getItemById
	 *
	 * id
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getItemById() {
		// $this->_buf['getItemById'] = [
		// 	'link' => ['h_user_role', 'h_user_store'],
		// ];
		return parent::getItemById();
	}
	
	/**
	 * 更改密码
	 * @api_name 更改密码
	 * @api_type 2
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Users.changePasswd
	 *
	 * @return array|mixed|string
	 */
	public function changePasswd() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$data = [];
		$data['aid'] = $this->aid;
		$data['new_passwd'] = $param['new_passwd'];
		$data['old_passwd'] = $param['old_passwd'];
		
		$re = $m->changePasswd($data);
		return return_json($re);
	}
	
	/**
	 * 重置密码
	 * @api_name 重置密码
	 * @api_type 2
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Users.resetPasswd
	 *
	 * @return array|mixed|string
	 */
	public function resetPasswd() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$data = [];
		$data['uid'] = $param['id'];
		$data['new_passwd'] = $param['new_passwd'];
		
		$re = $m->resetPasswd($data);
		return return_json($re);
	}
	
	/**
	 * 设置用户状态
	 * @api_name 设置用户状态
	 * @api_type 2
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Users.setStatus
	 *
	 * @return array|mixed|string
	 */
	public function setStatus() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $this->p('id');
		$status = $this->p('status');
		
		$re = $m->setStatus($id, $status);
		return return_json($re);
	}
	
	/**
	 * 添加
	 * 用户表
	 * @api_name 添加用户
	 * @api_type 2
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Users.add
	 *
	 * name				用户名
	 * passwd			密码
	 * nickname			昵称
	 * avatar			头像
	 * status			状态（1启用 0禁用）
	 *
	 * @return mixed|string
	 */
	public function add() {
		$this->param['status'] = User::$_STATUS['enabled'];
		return parent::add();
	}
	
	/**
	 * 更改
	 * 用户表
	 * @api_name 更改用户
	 * @api_type 2
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/User.v1.Users.edit
	 *
	 * id
	 * name				用户名
	 * passwd			密码
	 * nickname			昵称
	 * avatar			头像
	 * status			状态（1启用 0禁用）
	 *
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$re = $this->fp();
		$id = $re['id'];
		$reData = $re['data'];
		
		return parent::edit();
	}

    /**
     * 封停
     * 用户表
     * @api_name 封停用户
     * @api_type 2
     * @api_is_maker 1
     * @api_is_auth 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /sys/admin/User.v1.Users.frozenUser
     *
     * id
     * frozen_time	    封停时间 0为永久封停 status改为0
     *
     * @return mixed|string
     */
    
    public function frozenUser() {
        $param = $this->param;
        if($param['frozen_time'] > 0){
            $this->param['frozen_start_time'] = time();
            $this->param['frozen_end_time'] = $this->param['frozen_start_time'] + $param['frozen_time'];
        }else{
            $this->param['status'] = 0;
        }
        return parent::edit();
    }
}
