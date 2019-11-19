<?php

namespace app\sys\com\User\common\logic;

use app\sys\com\base\common\v1\traits\VarBase;
use app\sys\com\User\common\model\User as UserM;
use think\Controller;
use think\facade\Request;

class User extends Controller {
	use VarBase;
	
	public $header;
	
	public function initialize()
	{
		parent::initialize();
		/*获取头部信息*/
//        $header = Request::instance()->header();
		$this->header = Request::header();
	}
	
	public function checkLogin($event) {
		// $authKey = empty($this->header['authkey']) ? '' : $this->header['authkey'];
		// $sessionId = empty($this->header['sessionid']) ? '' : $this->header['sessionid'];
		//$addonParam = $event['addonParam'];
		//$mid = $addonParam['mid'];
		
		$route_url = sessionOrGLOBALS('route_url');
		$auth_white = app_config('auth_white.');
		
		$_token = !empty($this->header['authorization-token']) ? $this->header['authorization-token'] : '';
		if (empty($_token)) {
			if (in_array($route_url, $auth_white)) {
				$GLOBALS['token'] = '';
				$GLOBALS['uInfo'] = [];
				$GLOBALS['uid'] = 0;
				
				return rsData(['uid' => 0]);
			}
			return rsErrCode(11001); // 请先登录
		}
		
		$cache = cache('ulogin:User_' . $_token);
		
		if (empty($_token) || empty($cache) || !isset($cache['uInfo'])) {
			return rsErrCode(11001); // 请先登录
		}
		
		// 检查账号有效性
		if (empty($cache['uInfo'])) {
			$GLOBALS['uInfo'] = [];
			return ['uid' => 0];
		}
		
		$userInfo = $cache['uInfo'];
		
		$GLOBALS['token'] = $_token;
		$GLOBALS['uInfo'] = $userInfo;
		$GLOBALS['uid'] = $userInfo['id'];
		
		$userModel = new UserM();
		$where = [];
		$where[] = ['id', '=', $userInfo['id']];
		$where[] = ['status', '=', UserM::$_STATUS['enabled']];
		
		$re = $userModel->getItem($where);
		if (isErr($re)) {
			return rsErr('查询用户失败，请重试', 11010);
		}
		
		$reUser = gData($re);
		if (empty($reUser)) {
			return rsErr('账号已被删除或禁用', 11010);
		}
		
		if ($reUser['token'] != $_token) {
			return rsErr('登录态已失效 请重新登录', 11010);
		}
		
		// 更新缓存
		//cache('ulogin:User_' . $_token, $cache, config('sys_config.user_token_expires_in'));
		
		return rsData(['uid' => $reUser['id']]);
	}
}