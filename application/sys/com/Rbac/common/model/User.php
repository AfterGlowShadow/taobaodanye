<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\model;


use app\sys\com\Crypt\common\v1\facade\Crypt;

class User extends \app\sys\com\Rbac\common\model\table\User {
	
	protected $enabled_validate_add = true;
	protected $enabled_validate_edit = true;
	
	public static $_STATUS = [
		'disabled' => 0,
		'enabled' => 1,
	];
	
	public static $_IS_ROOT = [
		'no' => 0,
		'yes' => 1,
	];
	
	/**
	 * 关联角色
	 * @return \think\model\relation\hasMany
	 */
	public function hUserRole() {
		$pre = config('database.prefix');
		$userRole = "{$pre}" . 'sys_rbac_user_role';
		
		return $this
			->hasMany('app\sys\com\Rbac\common\model\UserRole', 'user_id', 'id')
			->leftJoin('sys_rbac_role b', "b.id={$userRole}.role_id")
			->field("{$userRole}.user_id, {$userRole}.role_id, b.name, b.intro");
	}
	/**
	 * 关联用户表
	 * @return \think\model\relation\belongsTo
	 */
	public function hUser() {
		$pre = config('database.prefix');

		return $this
			->belongsTo('User', 'pid', 'id')
            ->selfRelation(true);
	}
	
	/**
	 * 关联店面
	 * @return \think\model\relation\hasMany
	 */
	public function hUserStore() {
		$pre = config('database.prefix');
		$userStore = "{$pre}" . 'sys_rbac_user_store';
		
		return $this
			->hasMany('app\sys\com\Rbac\common\model\UserStore', 'user_id', 'id')
			->leftJoin('sys_rbac_store b', "b.id={$userStore}.store_id")
			->field("{$userStore}.user_id, {$userStore}.store_id, {$userStore}.identity_type,
						  b.name, b.province, b.city, b.area, b.address, b.storekeeper_name, b.mobile");
	}
	
	public function _init() {
		parent::_init();
		
		$this->enabled_validate_add_obj = new \app\sys\com\Rbac\common\validate\User();
		$this->enabled_validate_edit_obj = new \app\sys\com\Rbac\common\validate\User();
		$this->enabled_validate_editw_obj = new \app\sys\com\Rbac\common\validate\User();
	}
	
	/**
	 * 用uid查找用户
	 * @param $uid
	 * @return array
	 */
	public function findUser_Uid($uid) {
		try {
			$re = $this->where('id', $uid)->find();
			if ($re === false) {
				return $this->return_error();
			} else if (empty($re)) {
				return rsErr('管理员账号不存在', 10010); // 找不到用户
			}
			return return_status_ok_data($re->toArray());
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}
	
	/**
	 * 管理员登录
	 * @param array $data
	 * @return array|bool
	 * @throws \think\Exception
	 */
	public function login($data = []) {
		if (empty($data['username'])) {
			return rsErr('帐号不能为空', 10003);
		}
		if (empty($data['passwd'])) {
			return rsErr('密码不能为空', 10003);
		}
		
		$username = $data['username'];
		$passwd = md5($data['passwd']);
		
		//$addonParam = sessionOrGLOBALS('addonParam');
		
		$where = [];
		$where[] = ['name', '=', $username];
		$where[] = ['passwd', '=', $passwd];
		// $where[] = ['status', '=', User::$_STATUS['enabled']];
		
		$re = $this->getItem($where);
		if (isErr($re)) {
			return rsErr('登录失败', 10003);
		}
		
		$reAdmin = gData($re);
		if (empty($reAdmin)) {
			return rsErr('用户名密码错误', 10011);
		}
		
		if ($reAdmin['status'] == User::$_STATUS['disabled']) {
			return rsErr('该用户被禁用', 10011);
		}
		
		$aid = $reAdmin['id'];
		
		// 获取权限列表
		$userRoleModel = new UserRole();
		$re = $userRoleModel->getUserRoleRuleList($aid, $reAdmin['is_root']);
		if (isErr($re)) {
			return rsErr('获取权限列表失败', 10003);
		}
		
		$reUserRoleRule = gData($re);
		
		// 获取菜单树
		$_menu_pid = 500;
		$re = $userRoleModel->getUserRoleRuleMenuList($aid, true, $reAdmin['is_root'], $_menu_pid);
		if (isErr($re)) {
			return rsErr('获取菜单失败', 10003);
		}
		
		$reUserRoleMenu = gData($re);
		
		// 获取拒绝访问的列表
		$re = $userRoleModel->getUserRoleRuleRejectList($aid, $reAdmin['is_root']);
		if (isErr($re)) {
			return rsErr('权限获取列表失败', 10003);
		}
		
		$reUserRoleRuleReject = gData($re);
		
		$authRejectList = $reUserRoleRuleReject['rules'];
		// foreach ($authRejectList as $k => $v) {
		// 	$authRejectList[$k] = $this->exchange_var($authRejectList[$k], 'mid', $mid);
		// }
		
		// 获取店面身份列表
		$userStoreModel = new UserStore();
		$re = $userStoreModel->getStoreList($aid);
		if (isErr($re)) {
			return rsErr('获取店面身份列表失败', 10003);
		}
		
		$reUserStore = gData($re);
		
		// 缓存当前用户
		//session_start();
		$info['userInfo'] = $reAdmin;
		$info['sessionId'] = session_id();
		//$info['addonType'] = sessionOrGLOBALS('addonParam')['addon_type'];
		$authKey = md5($reAdmin['name'] . $reAdmin['passwd'] . $info['sessionId'] . rand(1000, 9999));
		
		$_d = [];
		//$_d['ssid'] = session_id();
		$_d['akey'] = $authKey;
		//$_d['adtp'] = $info['addonType'];
		//$_d['rad'] = rand(1000, 9999);
		$_d['expire_time'] = config('sys_config.admin_session_expires_in');
		
		$re = Crypt::createToken($_d);
		$_jwt = gData($re);
		
		$info['JWT'] = $_jwt['jwt'];
		
		$info['_AUTH_LIST_'] = $reUserRoleRule['rules'];
		$info['_AUTH_URL_REJECT_'] = $reUserRoleRuleReject['rules'];
		$info['_AUTH_MENU_'] = $reUserRoleMenu['menus'];
		$info['_AUTH_STORE_'] = $reUserStore;
		$info['authKey'] = $authKey;
		cache('login:Auth_'.$authKey, null);
		cache('login:Auth_'.$authKey, $info, config('sys_config.admin_session_expires_in'));
		
		unset($reAdmin['passwd']);
		
		// 返回信息
		//$_data['authKey']        = $authKey;
		//$_data['sessionId']      = $info['sessionId'];
		$_data['token']          = $_jwt['jwt'];
		$_data['userInfo']       = $reAdmin;
		$_data['authRejectList'] = $authRejectList; // $reUserRoleRuleReject['rules'];
		$_data['menusList']      = $reUserRoleMenu['menus'];
		$_data['StoreList']      = $reUserStore['stores'];
		$_data['aid']            = $aid;
		
		return rsData($_data);
	}

	public function logout($data = []) {
		$authKey = $data['authKey'];
		cache('login:Auth_'.$authKey, null);
		return rsOk();
	}
	
	public function changePasswd($data = []) {
		$aid = $data['aid'];
		$new_pw = md5($data['new_passwd']);
		$old_pw = md5($data['old_passwd']);
		
		if (empty($aid)) {
			return rsErr('管理员账号无效，请先登录', 10011);
		}
		
		$re = $this->findUser_Uid($aid);
		if (isErr($re)) {
			return $re;
		}
		
		$reAdmin = gData($re);
		if ($reAdmin['passwd'] !== $old_pw) {
			return rsErr('原密码错误', 10011);
		}
		
		if ($new_pw == $old_pw) {
			return rsErr('密码相同', 10011);
		}
		
		$_d = [];
		$_d['passwd'] = $new_pw;
		$this->tmp_scene = 'change_pw';
		$re = $this->editById($aid, $_d);
		return $re;
	}
	
	public function resetPasswd($data = []) {
		$aid = $data['aid'];
		$new_pw = md5($data['new_passwd']);
		
		if (empty($aid)) {
			return rsErr('管理员账号无效，请先登录', 10011);
		}
		
		$re = $this->findUser_Uid($aid);
		if (isErr($re)) {
			return $re;
		}
		
		$_d = [];
		$_d['passwd'] = $new_pw;
		$this->tmp_scene = 'reset_pw';
		$re = $this->editById($aid, $_d);
		return $re;
	}
	
	public function setStatus($id, $status) {
		$_d = [];
		$_d['status'] = $status;
		$this->tmp_scene = 'set_status';
		$re = $this->editById($id, $_d);
		return $re;
	}
	
	public function beforeDelById($id, &$result = []) {
		if (!empty($GLOBALS['aid']) && $GLOBALS['aid'] == $id) {
			$result = rsErr('不能删除自己', 10011);
			return false;
		}
		
		$_data = gData($result);
		
		if ($_data['is_root'] == self::$_IS_ROOT['yes']) {
			$result = rsErr('超级管理员不能删除', 10011);
			return false;
		}
		
		//$result = return_status_ok();
		return true;
	}
	
	public function afterDelById($id, &$result = []) {
		// 同时删除用户角色关联表
		$userRoleModel = new UserRole();
		$_w = [];
		$_w[] = ['user_id', '=', $id];
		$re = $userRoleModel->delByWhere($_w);
		if (isErr($re)) {
			$result = $this->return_error();
			return false;
		}
		
		// 同时删除用户店面关联表
		$userStoreModel = new UserStore();
		$_w = [];
		$_w[] = ['user_id', '=', $id];
		$re = $userStoreModel->delByWhere($_w);
		if (isErr($re)) {
			$result = $this->return_error();
			return false;
		}
		
		return parent::afterDelById($id, $result);
	}
	
	public function beforeDelByWhere($where, &$result = []) {
		if (isErr($result)) {
			return false;
		}
		
		$_data = glData($result);
		if (empty($_data)) {
			return true;
		}
		
		foreach ($_data as $item) {
			$id = $item['id'];
			$_result = $result;
			$re = $this->beforeDelById($id, $_result);
			if ($re === false) {
				$result = $_result;
				return false;
			}
		}
		
		//$result = return_status_ok();
		return true;
	}

}
