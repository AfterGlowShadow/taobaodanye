<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller;

use app\sys\com\Rbac\common\model\User;
use app\sys\com\Rbac\common\model\UserRole;
use think\Db;

/**
 * Class Users
 * 管理员表
 * @api_name 管理员管理
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Rbac\admin\controller\logic
 */
class Users extends \app\sys\com\Rbac\admin\controller\logic\Users {
	
	protected $beforeActionList = [
		'checkLogin' => ['except'=>'login,resetPasswd'],
	];

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 获取列表
	 * 管理员表
	 * @api_name 获取管理员列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.getList
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
			$where[] = ['name|nickname', 'like', "%{$keywords}%"];
		}
		
		$this->_buf['getList'] = [
			'link' => ['h_user_role', 'h_user_store','h_user'],
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
	 * 管理员表
	 * @api_name 获取管理员详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.getItemById
	 *
	 * id
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getItemById() {
		$this->_buf['getItemById'] = [
			'link' => ['h_user_role', 'h_user_store'],
		];
		return parent::getItemById();
	}
	
	/**
	 * 管理员登录
	 * @api_name 管理员登录
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_auth 0
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.login
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 * @throws \think\Exception
	 */
	public function login() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$re = $m->login($param);
		return return_json($re);
	}
	
	/**
	 * 管理员注销
	 * @api_name 管理员注销
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.logout
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function logout() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		// $authKey = empty($this->header['authkey']) ? '' : $this->header['authkey'];
		$authKey = !empty($GLOBALS['authKey']) ? $GLOBALS['authKey'] : '';
		$data = [];
		$data['authKey'] = $authKey;
		
		$re = $m->logout($data);
		return return_json($re);
	}
	
	/**
	 * 更改密码
	 * @api_name 更改密码
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.changePasswd
	 *
	 * @return array|mixed|\Services_JSON_Error|string
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
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.resetPasswd
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function resetPasswd() {
		/** @var $m User */
		$m = $this->_model;
		$param = $this->param;
		
		$data = [];
		$data['aid'] = $param['id'];
		$data['new_passwd'] = $param['new_passwd'];
		
		$re = $m->resetPasswd($data);
		return return_json($re);
	}
	
	/**
	 * 设置管理员状态
	 * @api_name 设置管理员状态
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.setStatus
	 *
	 * @return array|mixed|\Services_JSON_Error|string
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
	 * 管理员表
	 * @api_name 添加管理员
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.add
	 *
	 * name				用户名
	 * passwd			密码
	 * nickname			昵称
	 * avatar			头像
	 * is_root			是否超级管理员（0-否 1-是）
	 * status			状态（1启用 0禁用）
	 *
	 * @return mixed|string
	 */
	public function add() {

        /** @var $m User */
        //验证该超管添加了多少个管理员
        $m = $this->_model;
        $_where = [];
        $_where['pid']=$this->aid;
        $admin_count = $m->where($_where)->count('id');
        if($admin_count >= 5){
            return rjErr('最多添加5个管理员');
        }
        $this->param['pid'] = $this->aid;
		$this->param['is_root'] = User::$_IS_ROOT['no'];
		$this->param['status'] = User::$_STATUS['enabled'];
		$aid = parent::add();
        $newUserData = $aid->getData();
        if($newUserData['code'] == 200){
            $userModel = new UserRole();
            $uid = $newUserData['result']['id'];
            $role_ids = [8];
            $re = $this->transaction(function () use ($userModel, $uid, $role_ids) {
                $re = $userModel->setRoles($uid, $role_ids);
                return $re;
            });
            return return_json($re);
        }else {
            return $aid;
        }

	}
	
	/**
	 * 更改
	 * 管理员表
	 * @api_name 更改管理员
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_auth 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Users.edit
	 *
	 * id
	 * name				用户名
	 * passwd			密码
	 * nickname			昵称
	 * avatar			头像
	 * is_root			是否超级管理员（0-否 1-是）
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
	
}
