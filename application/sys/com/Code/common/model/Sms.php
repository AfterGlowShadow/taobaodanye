<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Code\common\model;


use app\sys\com\Code\common\service\Sms114;
use app\sys\com\Code\common\service\SmsAliyun;
use think\facade\Log;

class Sms extends \app\sys\com\Code\common\model\table\Sms {
	
	public static $_SEND_STATUS = [
		'none' => 0,
		'wait_send' => 1,
		'sending' => 2,
		'send_ok' => 3,
		'send_error' => 4,
	];
	
	public static $_STATUS = [
		'none' => 0,
		'enabled' => 1,
		'disabled' => 2,
	];
	
	public static $_CODE_TYPE = [
		'none' => 0,
		'reg' => 1,
		'forget_pw' => 2,
		'login' => 3,
	];

	public static $_TYPE = [
		'none' => 0,
		'sms_code' => 1, // 短信验证码
	];
	
	public static $_SMS_TYPE = [
		'none' => 0,
		'ali_sms' => 1, // 阿里大鱼
		'sms_114' => 2, // 114第三方
		
	];
	
	/**
	 * 获取并发送短信验证码
	 *
	 * @param $data
	 * @return array|mixed|void
	 * @throws \Toplan\PhpSms\PhpSmsException
	 */
	public function getSmsCode($data) {
		if (!isset($data['mobile']) || !isset($data['code_type'])) {
			return rsErrCode(10001);
		}
		
		$mobile = $data['mobile'];
		$code = rand(100000, 999999);
		$code_type = $data['code_type'];
		
		$config_sms_type = app_config('sms_code.sms_type');
		
		$_msg = '';
		$_rmsg = '';
		$_send_status = self::$_SEND_STATUS['sending'];
		$reSms = [];
		
		$content = '';

		// 发送
		switch ($config_sms_type) {
			case self::$_SMS_TYPE['ali_sms']:
				$_config = app_config('sms_code.ali_sms');
				
				$smsAlidayu = new SmsAliyun();
				$_p = [];
				$_p['accessKeyId'] = $_config['accessKeyId'];
				$_p['accessKeySecret'] = $_config['accessKeySecret'];
				$_p['signName'] = $_config['signName'];
				$_p['templates'] = $_config['templates'];
				$re = $smsAlidayu->send_code($mobile, $code, $_p);
				$reSms = gData($re);
				$_sms = false;
				$_msg = '发送失败';
				$_response_message = json_encode_u($reSms);
				// if (isset($reSms['returnstatus'])) {
				// 	if ($reSms['returnstatus'] == 'Success') {
				// 		$_sms = true;
				// 		$_msg = $reSms['message'];
				// 	} else {
				// 		$_msg = $reSms['message'];
				// 	}
				// }

				if (isOk($re)) {
					if ($reSms['success']) {
						$_sms = true;
						$_msg = '发送成功';
						$_send_status = self::$_SEND_STATUS['send_ok'];
					} else {
						$_sms = false;
						$_msg = '发送失败';
						$_send_status = self::$_SEND_STATUS['send_error'];
					}
				} else {
					//$reSmsData = gData($reSms);
					$_msg = $re;
					$_send_status = self::$_SEND_STATUS['send_error'];
				}
				break;
			case self::$_SMS_TYPE['sms_114']:
				$_config = app_config('sms_code.sms_114');
				
				$sms114 = new Sms114();
				$_p = [];
				$_p['userid'] = $_config['userid'];
				$_p['account'] = $_config['account'];
				$_p['password'] = $_config['password'];
				$_p['content'] = "{$_config['content']}您的验证码为：{$code}，请在5分钟内使用。";
				$_p['url'] = $_config['url'];
				$content = $_p['content'];
				$reSms = $sms114->sendCode($mobile, $code, $_p);
				$_sms = false;
				$_msg = '发送失败';
				$_rmsg = '发送失败';
				$_response_message = json_encode_u($reSms);
				if (isset($reSms['returnstatus'])) {
					if ($reSms['returnstatus'] == 'Success') {
						$_sms = true;
						$_msg = $reSms['message'];
						$_rmsg = '发送成功';
						$_send_status = self::$_SEND_STATUS['send_ok'];
					} else {
						$_msg = $reSms['message'];
						$_rmsg = '发送失败';
						$_send_status = self::$_SEND_STATUS['send_error'];
					}
				} else {
					$_send_status = self::$_SEND_STATUS['send_error'];
				}
				break;
		}
		
		$_data = [];
		$_data['mobile'] = $mobile;
		$_data['code'] = $code;
		$_data['code_type'] = $code_type;
		$_data['code_expire_in'] = strtotime('+5 minutes');
		$_data['content'] = $content;
		$_data['send_status'] = $_send_status;
		$_data['send_errmsg'] = $_msg;
		$_data['status'] = self::$_STATUS['enabled'];
		$_data['type'] = self::$_TYPE['sms_code'];
		$_data['sms_type'] = $config_sms_type;
		$_data['remark'] = '';
		$_data['response_message'] = $_response_message;
		$re = $this->add($_data);
		
		$result = [
			//'data' => $re,
			//'sms_return' => $reSms,
			'sms' => [
				'status' => $_send_status,
				'msg' => $_rmsg,
			]
		];
		
		return rsData($result);
	}
	
	/**
	 * 验证短信验证码
	 * @param $data
	 * @return array
	 * @throws \think\Exception
	 */
	public function checkSmsCode($data) {
		if (!isset($data['mobile']) || !isset($data['code']) || !isset($data['code_type'])) {
			return rsErrCode(10001);
		}
		
		$config_sms_type = app_config('sms_code.sms_type');
		
		$_where = [];
		$_where[] = ['mobile', '=', $data['mobile']];
		$_where[] = ['code', '=', $data['code']];
		$_where[] = ['code_type', '=', $data['code_type']];
		$_where[] = ['send_status', '=', self::$_SEND_STATUS['send_ok']];
		$_where[] = ['status', '=', self::$_STATUS['enabled']];
		$_where[] = ['type', '=', self::$_TYPE['sms_code']];
		$_where[] = ['sms_type', '=', $config_sms_type];
		$_where[] = ['code_expire_in', '>', time()];
		$_order = ['create_time' => 'DESC'];
		$param = [
			'func' => function ($m) use ($_order) {
				/** @var Sms $m */
				$m = $m->order($_order);
				return $m;
			}
		];
		$re = $this->getItem($_where, '*', false, [], $param);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		if (empty($reData)) {
			return rsErrCode(11016);
		}
		
		$id = $reData['id'];
		
		// 更新状态
		$_d = [];
		$_d['status'] = self::$_STATUS['disabled'];
		$re = $this->editById($id, $_d);
		if (isErr($re)) {
			return $re;
		}
		
		return rsData(['check' => 'ok']);
	}

}
