<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Code\common\validate\vbase;

use think\Validate;

class Sms extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'mobile' => 'require',
		'code' => 'require',
		'code_type' => 'require',
		'code_expire_in' => 'require',
		'content' => 'require',
		'send_status' => 'require',
		'send_errmsg' => 'require',
		'status' => 'require',
		'type' => 'require',
		'sms_type' => 'require',
		'remark' => 'require',
		'response_message' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'mobile.require' => '“手机”必须填写',
		'code.require' => '“短信验证码”必须填写',
		'code_type.require' => '“验证码类型（0-未知 1-注册 2-忘记密码 3-登录）”必须填写',
		'code_expire_in.require' => '“验证码过期时间戳”必须填写',
		'content.require' => '“发送内容”必须填写',
		'send_status.require' => '“发送状态（0-未知 1-等待发送 2-发送中 3-成功 4-失败）”必须填写',
		'send_errmsg.require' => '“发送失败信息”必须填写',
		'status.require' => '“状态（0-未知 1-启用 2-禁用）”必须填写',
		'type.require' => '“类型（0-未知 1-短信验证码）”必须填写',
		'sms_type.require' => '“短信类型（0-未知 1-阿里大鱼 2-114）”必须填写',
		'remark.require' => '“备注”必须填写',
		'response_message.require' => '“返回消息”必须填写',

    ];

	protected $scene = [
		'add'  => ["mobile", "code", "code_type", "code_expire_in", "content", "send_status", "send_errmsg", "status", "type", "sms_type", "remark", "response_message"],
		'edit' => ["mobile", "code", "code_type", "code_expire_in", "content", "send_status", "send_errmsg", "status", "type", "sms_type", "remark", "response_message"],
	];
}
