<?php
// +----------------------------------------------------------------------
// | Description: 登录通用
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\api;

// use app\common\model\RecordShare;
// use app\common\model\RecordUserCoin;
// use app\common\model\RuleCoin;
// use app\common\model\User;
// use app\api\controller\common\ApiCommon;

class LoginCommon extends ControllerCommon {
	// 请求来源
	public static $_REQ_SOURCE = [
		//'e' => 'externalApi', // 外部接口访问（用不到）
		'l' => 'localFront', // 内部前端访问
		//'s' => 'localSelf', // 内部自身访问（用不到）
	];

	// 访问类型
	public static $_REQ_TYPE = [
		'n' => 'normal',    // 一般行为（用不到）
		'l' => 'login',     // 登录
	];

	/**
	 * @throws \Exception
	 */
	public function initialize()
    {
    	$this->need_check_token = true;
        parent::initialize();

		$this->headerLogin();
    }

	/**
	 * 从url中获取分享码
	 * @throws \Exception
	 */
	protected function headerLogin() {
		$login_info = [
			'source' => self::$_REQ_SOURCE['l'],
			'type' => self::$_REQ_TYPE['l'],
			'share_code' => '',
			'ip' => $this->request->ip(),
			//'third_session_token' => '',
		];

		if (isset($this->param['share_code'])) {
			$login_info['share_code'] = $this->param['share_code'];
		}
		
		// if (isset($this->param['st'])) {
		// 	$login_info['third_session_token'] = $this->param['st']; // TP_token
		// }

		$GLOBALS['login_info'] = $login_info;
		$GLOBALS['user_info'] = [
			// 'share_code' => $login_info['share_code'],
			// 'third_session_token' => $login_info['third_session_token'],
		];
		
		isset($login_info['share_code']) && $GLOBALS['user_info']['share_code'] = $login_info['share_code'];

		//if (!empty($login_info['share_code'])) {
			// 写分享
			//$reRecordShare = $this->AddShare();
			//log_record("--- LoginCommon - AddShare = " . json_encode_u($reRecordShare));
		//}
	}
	
}
