<?php


namespace app\sys\com\Code\common\service;

class Sms114 {
	public static $_SMS_API = 'http://114.115.203.99:8088/sms.aspx';
	
	public static function isimplexml_load_string($string, $class_name = 'SimpleXMLElement', $options = 0, $ns = '', $is_prefix = false) {
		libxml_disable_entity_loader(true);
		
		if (preg_match('/(\<\!DOCTYPE|\<\!ENTITY)/i', $string)) {
			return false;
		}
		
		return simplexml_load_string($string, $class_name, $options, $ns, $is_prefix);
	}

	public static function xml2arr($xml) {
		if (empty($xml)) {
			return array();
		}
		
		$result = array();
		
		$xmlobj = self::isimplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		$result = json_decode(json_encode($xmlobj), true);
		
		if (is_array($result)) {
			return $result;
		} else {
			return array();
		}
	}
	
	public static function sendCode($phoneNumber, $code, $param) {
		// $_config = app_config('sms_code.sms_114');
		
		$param = [
			'userid' => $param['userid'],
			'account' => $param['account'],
			'password' => $param['password'],
			'mobile' => $phoneNumber,
			'content' => $param['content'],
			'sendTime' => '',
			'action' => 'send',
			'extno' => '',
		];
		
		$url = self::$_SMS_API;
		!empty($_config['url']) && $url = $param['url'];
		
		try {
			$re = http($url, $param, 'POST');
			$re_arr = self::xml2arr($re);
			
			return $re_arr;
		} catch (\Exception $e) {
			return rsErr('发送异常 ' . $e->getMessage(), 1000);
		}
	}

}