<?php

namespace app\sys\com\Rbac\common\logic;

use app\sys\com\base\common\v1\traits\VarBase;
use app\sys\com\Crypt\common\v1\facade\Crypt;
use app\sys\com\Rbac\common\model\User;
use think\Controller;
use think\facade\Request;

class Rbac extends Controller {
	use VarBase;
	
	public $header;
	
	public function initialize()
	{
		parent::initialize();
		/*获取头部信息*/
//        $header = Request::instance()->header();
		$this->header = Request::header();
	}
	
	public function checkAuth($event) {
		// $authKey = empty($this->header['authkey']) ? '' : $this->header['authkey'];
		// $sessionId = empty($this->header['sessionid']) ? '' : $this->header['sessionid'];
		$addonParam = $event['addonParam'];
		//$mid = $addonParam['mid'];
		
		$_jwt = !empty($this->header['authorization']) ? $this->header['authorization'] : '';
		if (empty($_jwt)) {
			return rsErrCode(11001); // 请先登录
		}
		
		$re = Crypt::checkToken($_jwt);
		if (isErr($re)) {
			return rsErrCode(11001); // 请先登录
		}
		
		$_jData = gData($re);
		
		if (empty($_jData['akey'])) {
			return rsErrCode(11001); // 请先登录
		}
		
		$authKey = $_jData['akey'];
		//$sessionId = $_jData['ssid'];
		// $addonType = $_jData['adtp'];
		
		$cache = cache('login:Auth_' . $authKey);
		
		if (empty($authKey) || empty($cache) || !isset($cache['userInfo'])) {
			return rsErrCode(11001); // 请先登录
		}
		
		// 检查账号有效性
		if (empty($cache['userInfo'])) {
			$GLOBALS['userInfo'] = [];
			$GLOBALS['authList'] = [];
			return ['aid' => 0];
		}
		
		$userInfo = $cache['userInfo'];
		$authList = $cache['_AUTH_LIST_'];
		$authRejectList = $cache['_AUTH_URL_REJECT_']; // 拒绝的route url
		
		// foreach ($authRejectList as $k => $v) {
		// 	$authRejectList[$k] = $this->exchange_var($authRejectList[$k], 'mid', $mid);
		// }
		
		$GLOBALS['authKey'] = $authKey;
		// $GLOBALS['addonType'] = $addonType;
		$GLOBALS['userInfo'] = $userInfo;
		$GLOBALS['aid'] = $userInfo['id'];
		$GLOBALS['authList'] = $authList;
		$GLOBALS['authRejectList'] = $authRejectList;
		
		$userModel = new User();
		$where = [];
		$where[] = ['id', '=', $userInfo['id']];
		$where[] = ['status', '=', User::$_STATUS['enabled']];
		
		$re = $userModel->getItem($where);
		if (isErr($re)) {
			return rsErr('查找管理员失败，请重试', 11010);
		}
		
		$reAdmin = gData($re);
		if (empty($reAdmin)) {
			return rsErr('账号已被删除或禁用', 11010);
		}
		
		// 更新缓存
		//cache('login:Auth_' . $authKey, $cache, config('sys_config.admin_session_expires_in'));
		
		if ($reAdmin['is_root'] == 1) {
			// 超级管理员直接授权
			return rsData(['aid' => $reAdmin['id']]);
		}
		
		$route_url = sessionOrGLOBALS('route_url');
		foreach ($authRejectList as $k=>$v){
            $authRejectList[$k] = strtolower($v);
        }
		if (in_array(strtolower($route_url), $authRejectList)) {
			// 如果当前url存在于拒绝列表 就没有权限
			return rsErr('权限不足', 11002);
		}
		
		return rsData(['aid' => $reAdmin['id']]);
	}
}