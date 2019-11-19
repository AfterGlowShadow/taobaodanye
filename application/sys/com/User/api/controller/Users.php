<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\api\controller;

use app\sys\com\Code\common\model\Sms;
use app\sys\com\User\common\model\ShareRecord;
use app\sys\com\User\common\model\User;
use think\Db;

/**
 * Class Users
 * 管理员表
 * @api_name 管理员管理
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @package app\sys\com\User\api\controller
 */
class Users extends \app\sys\com\User\api\controller\logic\Users {
	public $_use_username = 0;
	public $_use_mobile = 0;
	public $_use_sms_code = 0;
	public $_use_share = 0;
	
	// 验证码类型
	public static $_verify_type = [
		'login'  => 3, // 用户登录
		'reg'    => 1, // 用户注册
		'forget' => 2, // 忘记密码
	];
	
    public function init_before() {
        parent::init_before();

        // $this->need_check_token = true;
	    // $this->check_token_white_list = [
		//     ['c' => 'Users', 'a' => 'unique_check'],
		//     ['c' => 'Users', 'a' => 'login_user'],
		//     ['c' => 'Users', 'a' => 'reg_user'],
		//     ['c' => 'Users', 'a' => 'getList'],
		//     ['c' => 'Users', 'a' => 'forget_pw'],
		//     //['c' => 'Users', 'a' => 'sign'],
	    // ];
    }
    
    public function init_after() {
	    parent::init_after();
	    
	    $this->_use_username = app_config('reg_use.username');
	    $this->_use_mobile = app_config('reg_use.mobile');
	    $this->_use_sms_code = app_config('reg_use.sms_code');
	    $this->_use_share = app_config('reg_use.share');
    }
	
	public function uniqueCheck() {
		$param = $this->param;
		
		if (isset($param['email'])) {
			$validate = app()->validate('User', 'validate', false, 'api');
			if (!$validate->scene('unique_email')->check(['us_email' => $param['email']])) {
				return return_json_err($validate->getError(), 10011);
			}
			
			return return_json_ok();
		}
		
		if (isset($param['name'])) {
			$validate = app()->validate('User', 'validate', false, 'api');
			if (!$validate->scene('unique_name')->check(['us_name' => $param['name']])) {
				return return_json_err($validate->getError(), 10011);
			}
			
			return return_json_ok();
		}
		
		return return_json_err_c(10001);
	}
	
	/**
	 * 获取用户信息
	 * 用户表
	 * @api_name 获取用户个人信息
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.getUserInfo
	 *
	 * @return array
	 */
	public function getUserInfo() {
		$param = $this->param;
		// $token = $param['access_token'];
		
		if (empty($GLOBALS['token'])) {
			return rjErrCode(11001); // 请先登录
		}
		
		$token = $GLOBALS['token'];
		
		$where = [];
		$where['token'] = $token;
		
		$userModel = new User();
		$re = $userModel->getItem($where);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		
		$reData = get_return_data($re);
		if (empty($reData)) {
			return rjErrCode(11011); // 找不到用户
		}

//	    $uid = $reData['us_id'];
		
		unset($reData['passwd']);
		
		return rjData($reData);
	}
	
	protected function doLoginUser($data = []) {
		$userModel = new User();
		$reUser = $userModel->login_user($data);
		if (!is_return_ok($reUser)) {
			return $reUser;
		}
		
		return $reUser;
	}
	
	protected function doLogoutUser() {
		$userModel = new User();
		$re = $userModel->logout();
		if (!is_return_ok($re)) {
			return $re;
		}
		
		return $re;
	}
	
	/**
	 * 登录
	 * 用户表
	 * @api_name 登录
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.login
	 *
	 * @return mixed|string|\think\response\Json
	 * @throws \think\exception\PDOException
	 */
	public function login() {
		$param = $this->param;
		
		if (empty($param)) {
			return return_json_err_c(10001);
		}

//		$username = $param['username'];
//		$passwd = $param['passwd'];
		
		$re = $this->transaction(function () use ($param) {
			$re = $this->doLoginUser($param);
			return $re;
		});
		
		return return_json($re);
	}
	
	/**
	 * 手机号登录
	 * 用户表
	 * @api_name        手机号登录
	 * @api_type        3
	 * @api_is_menu     0
	 * @api_is_maker    1
	 * @api_is_show     1
	 * @api_is_def_name 0
	 * @api_url         /sys/api/User.v1.Users.loginMobile
	 *
	 * @return mixed|string|\think\response\Json
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function loginMobile() {
		$param = $this->param;
		$param['_login_type'] = 'mobile_code';
		
		if (empty($param)) {
			return return_json_err_c(10001);
		}
		
		// 验证短信验证码
		if ($this->_use_sms_code) {
			$p = [];
			$p['mobile'] = $param['mobile'];
			$p['code'] = $param['code'];
			$p['code_type'] = Sms::$_CODE_TYPE['login'];
			
			$smsModel = new Sms();
			$re = $smsModel->checkSmsCode($p);
			if (isErr($re)) {
				return rjErr('验证码不正确', 10001);
			}
		}
		
		$re = $this->transaction(function () use ($param) {
			$re = $this->doLoginUser($param);
			return $re;
		});
		
		return return_json($re);
	}
	
	/**
	 * 退出登陆
	 * 用户表
	 * @api_name 退出登录
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.logout
	 *
	 * @return mixed|string|\think\response\Json
	 * @throws \think\exception\PDOException
	 */
	public function logout() {
		$param = $this->param;
		
		if (empty($param)) {
			return return_json_err_c(10001);
		}

		$re = $this->transaction(function () {
			$re = $this->doLogoutUser();
			return $re;
		});
		
		return return_json($re);
	}
	
	protected function doAddShare($data = []) {
		if (empty($data)) {
			return return_status_err_c(11012); // 分享为空
		}
		
		if (!empty($data['uid1']) && !empty($data['uid2'])) {
			$shareRecordModel = new ShareRecord();
			$reShareRecord = $shareRecordModel->addShare($data);
			return $reShareRecord;
		}
		
		return return_status_ok();
	}
	
	/**
	 * 处理注册信息
	 * @param array $data
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	protected function doRegUser($data = []) {
		if (isset($GLOBALS['user_info'])) {
			$user_info = $GLOBALS['user_info'];
			
			$shareCode = $GLOBALS['user_info']['share_code'];
			$uid1 = 0; // 邀请人uid
			
			// $st = $GLOBALS['user_info']['third_session_token'];
			
			
			
			$userModel = new User();
			
			// 检查手机号是否注册过
			if ($this->_use_mobile && !empty($data['mobile'])) {
				$re = $userModel->findUser_Mobile($data['mobile'], true);
				if (isErr($re)) {
					return $re;
				}
				
				$reData = gData($re);
				if (!empty($reData)) {
					return rsErr('手机号已注册，请直接登录', 11017);
				}
			}
			
			// 检查用户名是否注册过
			if ($this->_use_username && !empty($data['name'])) {
				$re = $userModel->findUser_Name($data['name'], true);
				if (isErr($re)) {
					return $re;
				}
				
				$reData = gData($re);
				if (!empty($reData)) {
					return rsErr('用户名已注册，请直接登录', 10011);
				}
			}
			
			// 检查分享码
			if ($this->_use_share && !empty($shareCode)) {
				$reUser = $userModel->findUser_InviteCode($shareCode);
				if (is_return_ok($reUser)) {
					$reUserData = get_return_data($reUser);
					if (!empty($reUserData)) {
						$uid1 = $reUserData['id'];
					}
				} else {
					return rsErr('邀请码不正确', 10011);
				}
			}
			
			// 注册用户
			$_data           = $data;
			$_data['passwd'] = md5($data['passwd']);
			
			// $this->_use_username && $_data['name'] = $data['name'];
			// $this->_use_mobile && $_data['mobile'] = $data['mobile'];
			
			$reUser = $userModel->reg_user($_data);
			if (isErr($reUser)) {
				return $reUser;
			}
			
			$uid = $GLOBALS['user_info']['uid'];
			$token = $GLOBALS['user_info']['token'];
			
			if (empty($uid)) {
				return return_status_err_c(11005);
			}
			
			// 写所得记录表
			
			// 添加分享
			if ($this->_use_share && !empty($uid1)) {
				$_data = [];
				$_data['uid1'] = $uid1;
				$_data['uid2'] = $uid;
				$re = $this->doAddShare($_data);
				if (!is_return_ok($re)) {
					//return $re;
				}
			}
			
			// return rsData(['token' => $token]);
			$userInfo = $GLOBALS['user_info'];
			
			unset($userInfo['id']);
			unset($userInfo['uid']);
			unset($userInfo['passwd']);
			unset($userInfo['code']);
			unset($userInfo['_com']);
			unset($userInfo['_type']);
			unset($userInfo['component']);
			unset($userInfo['ver']);
			unset($userInfo['col']);
			unset($userInfo['act']);
			unset($userInfo['token_expires_in']);
			unset($userInfo['share_code']);
			
			return rsData($userInfo);
		}
		
		return rsErrCode(1000);
	}
	
	/**
	 * 注册用户
	 * 用户表
	 * @api_name 注册
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.reg
	 *
	 * @return array|mixed|string|\think\response\Json
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function reg() {
		$param = $this->param;
		
		if (empty($param)) {
			return return_json_err_c(10001);
		}
		
		// 手机号非空验证
		if ($this->_use_mobile && empty($param['mobile'])) {
			return rsErr('手机号不能为空', 10011);
		}
		
		// 用户名非空验证
		if ($this->_use_username && empty($param['name'])) {
			return rsErr('用户名不能为空', 10011);
		}
		
		// 验证码非空验证
		if ($this->_use_sms_code && empty($param['code'])) {
			return rjErr('验证码不能为空', 10001);
		}
		
		// $code = $param['verify_code'];
		// $type = self::$_verify_type['reg']; // $param['verify_type'];
		//
		// if ( !captcha_check($code, $type)) {
		// 	// 验证失败
		// 	return return_json_err_c(11021); // 码错误
		// }
		
		// 验证短信验证码
		if ($this->_use_sms_code) {
			$p = [];
			$p['mobile'] = $param['mobile'];
			$p['code'] = $param['code'];
			$p['code_type'] = Sms::$_CODE_TYPE['reg'];
			
			$smsModel = new Sms();
			$re = $smsModel->checkSmsCode($p);
			if (isErr($re)) {
				return rjErr('验证码不正确', 10001);
			}
		}
		
		$that = $this;
		$re = $this->transaction(function () use ($that, $param) {
			$re = $that->doRegUser($param);
			return $re;
		});
		
		return return_json($re);
	}
	
	/**
	 * 获取并发送短信验证码
	 * @return array|mixed|string|\think\response\Json
	 * @throws \think\exception\PDOException
	 */
	// public function getCode() {
	// 	$param = $this->param;
	//
	// 	if (empty($param)) {
	// 		return return_json_err_c(10001);
	// 	}
	//
	// 	$re = $this->transaction(function () use ($param) {
	// 		$smsCodeModel = new SmsCode();
	// 		$re = $smsCodeModel->getCode($param);
	// 		if (!is_return_ok($re)) {
	// 			return $re;
	// 		}
	//
	// 		return $re;
	// 	});
	//
	// 	return return_json($re);
	// }
	
	/**
	 * 更改密码
	 * 用户表
	 * @api_name 更改密码
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.changePw
	 *
	 * @return array|mixed|string|\think\response\Json
	 * @throws \think\exception\PDOException
	 */
	public function changePw() {
		$param = $this->param;
		
		if (empty($param)) {
			return rjErrCode(10001);
		}
		
		if (empty($GLOBALS['uid'])) {
			return rjErrCode(11001); // 请先登录
		}
		
		$uid = $GLOBALS['uid'];
		$param['uid'] = $uid;
		
		$re = $this->transaction(function () use ($param) {
			$userModel = new User();
			$re = $userModel->changePasswd($param);
			if (isErr($re)) {
				return $re;
			}
			
			return rsOk();
		});
		
		return return_json($re);
	}
	
	/**
	 * 忘记密码
	 * 用户表
	 * @api_name 忘记密码
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/User.v1.Users.forgetPw
	 *
	 * mobile
	 * code
	 * @return \think\response\Json
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function forgetPw() {
		$param = $this->param;
		
		if (empty($param)) {
			return return_json_err_c(10001);
		}
		
		if (empty($GLOBALS['uid'])) {
			return rjErrCode(11001); // 请先登录
		}
		
		// 手机号非空验证
		if ($this->_use_mobile && empty($param['mobile'])) {
			return rsErr('手机号不能为空', 10011);
		}
		
		// 用户名非空验证
		if ($this->_use_username && empty($param['name'])) {
			return rsErr('用户名不能为空', 10011);
		}
		
		// 验证码非空验证
		if ($this->_use_sms_code && empty($param['code'])) {
			return rjErr('验证码不能为空', 10001);
		}
		
		$uid = $GLOBALS['uid'];
		$param['uid'] = $uid;
		
		// $param['type'] = SmsCode::$_TYPE['forget_password'];
		//
		// $smsCodeModel = new SmsCode();
		// $re = $smsCodeModel->checkCode($param);
		// if (isErr($re)) {
		// 	return return_json($re);
		// }
		
		// 短信验证码
		if ($this->_use_sms_code) {
			$p = [];
			$p['mobile'] = $param['mobile'];
			$p['code'] = $param['code'];
			$p['code_type'] = Sms::$_CODE_TYPE['forget_pw'];
			
			$smsModel = new Sms();
			$re = $smsModel->checkSmsCode($p);
			if (isErr($re)) {
				return rjErr('验证码不正确', 10001);
			}
		}
		
		$re = $this->transaction(function () use ($param) {
			$userModel = new User();
			$re = $userModel->resetPasswd($param);
			return $re;
		});
		
		return return_json($re);
	}
	
	/**
	 * 签到
	 * @return mixed|string|\think\response\Json
	 * @throws \think\exception\PDOException
	 */
	// public function sign() {
	// 	$param = $this->param;
	//
	// 	if (empty($param)) {
	// 		return return_json_err_c(10001);
	// 	}
	//
	// 	$token = $param['access_token'];
	//
	// 	$re = $this->transaction(function () use ($token) {
	// 		$userMode = new User();
	// 		$re = $userMode->signUser($token);
	// 		return $re;
	// 	});
	//
	// 	return return_json($re);
	// }
	
	/**
	 * 获取列表
	 *
	 * page_num
	 * page_limit
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getList() {
		$param = $this->param;
		
		$page_num = isset($param['page_num']) ? $param['page_num'] : 1;
		$page_limit = isset($param['page_limit']) ? $param['page_limit'] : PHP_INT_MAX;
		
		/** @var $m User */
		$m = $this->_model;
		$_where = [];
		
		$_order = ['us_create_time' => 'DESC'];
		
		$re = $m->getList($_where, $_order, $page_num, $page_limit);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		
		$reData = get_return_data($re);
		return rjData($reData);
	}
	
	/**
	 * 更改用户
	 * 用户表
	 * @api_name 更改用户信息
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/user.v1.users.editUser
	 *
	 * @return mixed|string|\think\response\Json
	 */
	public function editUser() {
		$param = $this->param;
		$data = $param;
		
		if (empty($data)) {
			return rjErrCode(10001);
		}
		
		if (empty($GLOBALS['uid'])) {
			return rjErrCode(11001); // 请先登录
		}
		
		$uid = $GLOBALS['uid'];
		
		$user_info = $data;
		
		$userModel = new User();
		
		$_data = [];
		isset($user_info['email']) && $_data['email'] = $user_info['email'];
		//isset($user_info['name']) && $_data['us_name'] = $user_info['name'];
		// isset($user_info['passwd']) && $_data['us_password'] = $user_info['passwd'];
		isset($user_info['avatar']) && $_data['avatar'] = $user_info['avatar'];
		isset($user_info['nickname']) && $_data['nickname'] = $user_info['nickname'];
		isset($user_info['realname']) && $_data['realname'] = $user_info['realname'];
		isset($user_info['gender']) && $_data['gender'] = $user_info['gender'];
		isset($user_info['identity_number']) && $_data['identity_number'] = $user_info['identity_number'];
		isset($user_info['province']) && $_data['province'] = $user_info['province'];
		isset($user_info['city']) && $_data['city'] = $user_info['city'];
		isset($user_info['district']) && $_data['district'] = $user_info['district'];
		isset($user_info['address']) && $_data['address'] = $user_info['address'];
		isset($user_info['birthday']) && $_data['birthday'] = $user_info['birthday'];
		// isset($user_info['mobile']) && $_data['mobile'] = $user_info['mobile'];
		
		if (empty($_data)) {
			return rjErrCode(10004);
		}
		
		// 校验唯一
		$p = $_data;
		$p['id'] = $uid;
		$re = $userModel->unique_check($p, [], false);
		if (isErr($re)) {
			return return_json($re);
		}
		
		$userModel->tmp_scene = 'edit_user';
		$re = $userModel->editById($uid, $_data);
		return return_json($re);
	}
	
	/**
	 * 查询用户uid
	 * @return array
	 */
	public function find_user_uid() {
		$param = $this->param;
		$token = $param['token'];
		
		$userModel = new User();
		$reUser = $userModel->findUser_Token($token);
		if (!is_return_ok($reUser)) {
			return return_json($reUser);
		}
		
		return return_json($reUser);
	}

}
