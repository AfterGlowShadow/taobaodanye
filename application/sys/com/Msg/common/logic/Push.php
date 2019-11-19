<?php


namespace app\sys\com\Msg\common\logic;


use app\sys\com\Msg\common\model\Send;
use app\sys\com\Msg\common\model\Text;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;

class Push {
	
	/**
	 * 推送消息
	 * @param $event
	 * @return array
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function pushMessage($event) {
		if (!isset($event['id']) || !isset($event['addonParam'])) {
			return rsErr('事件参数不完整');
		}
		
		$id = $event['id'];
		$addonParam = $event['addonParam'];
		
		$sendModel = new Send();
		
		$join = [
			['sys_msg_text b', 'b.id = a.msg_text_id'],
		];
		
		$field = '*';
		
		$re = $sendModel->getItemById($id, $field, false, $join);
		if (isErr($re)) {
			return $re;
		}
		
		$reSend = gData($re);
		
		if (empty($reSend)) {
			return rsErr('推送数据为空');
		}
		
		$type = $reSend['type'];
		
		switch ($type) {
			case Text::$_TYPE['none']:
				$re = rsOk();
				break;
			case Text::$_TYPE['mp_push']:
				
				break;
			case Text::$_TYPE['miniapp_push']:
				$_data = [];
				$_data['id'] = $id;
				$_data['addonParam'] = $addonParam;
				$_data['sendData'] = $reSend;
				//$re = $this->pushMiniappMessage($_data);
				break;
			case Text::$_TYPE['sms']:
				
				break;
			case Text::$_TYPE['email']:
				
				break;
			default:
				
				break;
		}
		
		// 期间可以插事件自定义
		
		if (isOk($re)) {
			$sendModel->setStatusSuccess($id);
		} else {
			$sendModel->setStatusFailure($id);
		}
		
		return rsOk();
	}
	
	/**
	 * 推送到小程序客服消息
	 * @param $data
	 * @return array
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function pushMiniappMessage($data) {
		// try {
		// 	$mid = $data['addonParam']['mid'];
		// 	$_p  = $data['sendData']['send_param'];
		// 	if (empty($_p)) {
		// 		return rsErr('缺少推送参数');
		// 	}
		//
		// 	$_title = $data['sendData']['title'];
		// 	$_content = $data['sendData']['content'];
		//
		// 	$_jp = json_decode($_p, true);
		//
		// 	$miniappInfo               = getMimiappInfo($mid);
		// 	$options['appid']          = $miniappInfo['appid'];
		// 	$options['appsecret']      = $miniappInfo['appsecret'];
		// 	$options['token']          = $miniappInfo['token'];
		// 	$options['encodingaeskey'] = $miniappInfo['encodingaeskey'];
		// 	$miniappObj                = getMiniProgramObj($options);
		//
		// 	$_d           = [];
		// 	$_d['touser'] = $_jp['openid'];
		// 	$_d['msgtype'] = 'text';
		// 	$_d['text'] = [
		// 		'content' => "【{$_title}】{$_content}",
		// 	];
		//
		// 	$re = $miniappObj->sendCustomMessage($_d);
		// 	if ($re === false) {
		// 		return rsErr('推送失败');
		// 	}
		//
		// 	return rsOk();
		// } catch (\Exception $e) {
		// 	return rsErr($e->getMessage());
		// }
	}
	
}