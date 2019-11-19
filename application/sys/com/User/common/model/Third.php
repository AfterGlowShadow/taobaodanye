<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\common\model;


class Third extends \app\sys\com\User\common\model\table\Third {

	// 性别
	public static $_GENDER = [
		'none'  => 0,
		'm'     => 1,         // 男
		'f'     => 2,         // 女
	];
	
	// 状态
	public static $_STATUS = [
		'none'      => 0,
		'binding'   => 1,   // 已绑定用户
		'unbinding' => 2,   // 未绑定用户
		'disabled'  => 3,   // 禁用
	];
	
	
	public function findId($id, $checkEmpty = true) {
		$re = $this->getItemById($id);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		if ($checkEmpty && empty($reData)) {
			return rsErrCode(14001); // 未找到三方记录
		}
		
		return rsData($reData);
	}
	
	public function findOpenId($channel, $openId, $checkEmpty = true) {
		$_where = [];
		$_where[] = ['channel', '=', $channel];
		$_where[] = ['openid', '=', $openId];
		
		$re = $this->getDataItem($_where);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		if ($checkEmpty && empty($reData)) {
			return rsErrCode(14001); // 未找到三方记录
		}
		
		return rsData($reData);
	}
	
	public function findSessionToken($sessionToken, $checkEmpty = true) {
		$_where = [];
		$_where[] = ['session_token', '=', $sessionToken];
		
		$re = $this->getDataItem($_where);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		if ($checkEmpty && empty($reData)) {
			return rsErrCode(14001); // 未找到三方记录
		}
		
		if ($reData['expire_time'] < time()) {
			return rsErrCode(14008); // 会话token已过期
		}
		
		return rsData($reData);
	}
	
	/**
	 * 注册第三方
	 * @param $data
	 * @return array
	 */
	public function regThird($data) {
		if (empty($data)) {
			return rsErrCode(14005); // 数据为空
		}
		
		if (empty($data['openid']) || empty($data['channel'])) {
			return rsErrCode(10001); // 缺少参数
		}
		
		$openId = $data['openid'];
		$channel = $data['channel'];
		$re = $this->findOpenId($channel, $openId, false);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		if (empty($reData)) {
			// 是空表示还没注册第三方记录
			$data['session_token'] = makeAccessToken();
			$data['expire_time'] = strtotime('+1 minute');
			$data['status'] = self::$_STATUS['unbinding'];
			$re = $this->add($data);
			if (isErr($re)) {
				return $re;
			}
			
			$reData = gData($re);
			$id = $reData['id'];
			
			$result = [
				'isExist' => false,
				'isBinding' => false,
				'third_session_token' => $data['session_token'],
			];
			
			if (!empty($data['miss_user']) && $data['miss_user'] == 1) {
				$_d = [];
				$_d['id'] = $id;
				$_d['uid'] = 0;
				$_d['openid'] = $data['openid'];
				$_d['unionid'] = $data['unionid'];
				$_d['channel'] = $data['channel'];
				$_d['status'] = $data['status'];
				$_d['gender'] = $data['gender'];
				$_d['avatar'] = $data['avatar'];
				$result['user'] = $_d;
			}
		} else {
			$result = [
				'isExist' => true,
				'isBinding' => !empty($reData['uid']),
				'third_session_token' => $reData['session_token'],
			];
			
			if (!empty($data['miss_user']) && $data['miss_user'] == 1) {
				$_d = [];
				$_d['id'] = $reData['id'];
				$_d['uid'] = $reData['uid'];
				$_d['openid'] = $reData['openid'];
				$_d['unionid'] = $reData['unionid'];
				$_d['channel'] = $reData['channel'];
				$_d['status'] = $reData['status'];
				$_d['gender'] = $data['gender'];
				$_d['avatar'] = $data['avatar'];
				$result['user'] = $_d;
			}
		}
		
		return rsData($result);
	}
	
	/**
	 * 登录第三方（其实就是拿st换token）
	 * @param $param
	 * @return array
	 */
	public function loginThird($param) {
		if (isset($param['session_token'])) {
			$thirdSessionToken = $param['session_token'];
			$re = $this->findSessionToken($thirdSessionToken);
		} elseif (isset($param['openid'])) {
			$openid = $param['openid'];
			$channel = $param['channel'];
			$re = $this->findOpenId($channel, $openid);
		}
		
		if (isErr($re)) {
			return $re;
		}
		
		$reThirdData = gData($re);
		$utUid = $reThirdData['uid'];
		
		if (empty($utUid)) {
			return rsErrCode(14006); // 请先绑定用户
		}
		
		$userModel = new User();
		$re = $userModel->findUser_Uid($utUid);
		if (isErr($re)) {
			return $re;
		}
		
		$reUserData = gData($re);
		$_d = [];
		// $_d['username'] = $reUserData['us_email'];
		// $_d['passwd'] = $reUserData['us_passwd'];
		$_d['uid'] = $utUid;
		$re = $userModel->login_user($_d);
		if (isErr($re)) {
			return $re;
		}
		
		return $re;
	}
	
	/**
	 * App第三方登录
	 * @param $param
	 * @return array|bool
	 */
	public function loginThirdApp($param) {
		$param['miss_user'] = 1;
		$re = $this->regThird($param);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		$isExist = $reData['isExist'];
		$isBinding = $reData['isBinding'];
		$utUid = $reData['user']['uid'];
		
		$new_token = makeAccessToken($utUid);
		cache('tlogin:st_'.$new_token, $reData['user'], 10 * 60);
		
		if (!$isBinding) {
			return rsErrCode(14006, ['third_session_token' => $new_token]); // 请先绑定用户
		}
		
		$userModel = new User();
		$re = $userModel->findUser_Uid($utUid);
		if (isErr($re)) {
			return $re;
		}
		
		$reUserData = gData($re);
		$_d = [];
		$_d['uid'] = $utUid;
		$re = $userModel->login_user($_d);
		if (isErr($re)) {
			return $re;
		}
		
		return $re;
	}
	
	/**
	 * 绑定用户uid
	 * @param $param
	 * @return array
	 */
	public function bindingUser($param) {
		$uid = $param['uid'];
		if (isset($param['session_token'])) {
			// 查找session_token对应的三方记录
			$thirdSessionToken = $param['session_token'];
			$re = $this->findSessionToken($thirdSessionToken);
		} elseif (isset($param['openid'])) {
			$openid = $param['openid'];
			$channel = $param['channel'];
			$re = $this->findOpenId($channel, $openid);
		}
		
		if (isErr($re)) {
			return $re;
		}
		
		$reThirdData = gData($re);
		$utId = $reThirdData['id'];
		$utUid = $reThirdData['uid'];
		if (!empty($utUid)) {
			return rsErrCode(14004); // 已绑定
		}
		
		// 绑定用户
		if (empty($uid)) {
			return rsErrCode(14002); // uid无效
		}
		
		$userModel = new User();
		$re = $userModel->findUser_Uid($uid);
		if (!is_return_ok($re)) {
			return $re;
		}
		
		$_d = [];
		$_d['uid'] = $uid;
		$_d['status'] = self::$_STATUS['binding'];
		$re = $this->editById($utId, $_d);
		if (isErr($re)) {
			return $re;
		}
		
		return rsOk();
	}
	
	/**
	 * 解绑用户uid
	 * @param $param
	 * @return array
	 */
	public function unbindingUser($param) {
		if (isset($param['session_token'])) {
			// 查找session_token对应的三方记录
			$thirdSessionToken = $param['session_token'];
			$re = $this->findSessionToken($thirdSessionToken);
		} elseif (isset($param['openid'])) {
			$openid = $param['openid'];
			$channel = $param['channel'];
			$re = $this->findOpenId($channel, $openid);
		}
		
		if (isErr($re)) {
			return $re;
		}
		
		$reThirdData = gData($re);
		$utId = $reThirdData['id'];
		$utUid = $reThirdData['uid'];
		if (empty($utUid)) {
			return rsOk();
		}
		
		$_d = [];
		$_d['uid'] = 0;
		$_d['status'] = self::$_STATUS['unbinding'];
		$re = $this->editById($utId, $_d);
		if (isErr($re)) {
			return $re;
		}
		
		return rsOk();
	}



}
