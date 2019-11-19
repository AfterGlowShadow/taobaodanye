<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Msg\common\model;


class Text extends \app\sys\com\Msg\common\model\table\Text {
	
	public static $_TYPE = [
		'none' => 0,
		'mp_push' => 1, // 公众号推送
		'miniapp_push' => 2, // 小程序推送
		'sms' => 3, // 短信
		'email' => 4, // 邮箱
		'other' => 5, // 其他
		// 大于100为自定义
	];
	
	public static $_STATUS = [
		'none'      => 0,
		'wait_send' => 1,   // 待发送
		'send'      => 2,   // 发送中
		'sended'    => 3,   // 已发送
	];


}
