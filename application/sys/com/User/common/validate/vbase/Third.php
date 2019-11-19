<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\common\validate\vbase;

use think\Validate;

class Third extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'uid' => 'require',
		'openid' => 'require',
		'unionid' => 'require',
		'channel' => 'require',
		'nick' => 'require',
		'gender' => 'require',
		'avatar' => 'require',
		'status' => 'require',
		'session_token' => 'require',
		'expire_time' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'uid.require' => '“绑定用户uid”必须填写',
		'openid.require' => '“openid”必须填写',
		'unionid.require' => '“unionid”必须填写',
		'channel.require' => '“channel”必须填写',
		'nick.require' => '“昵称”必须填写',
		'gender.require' => '“性别（0-保密 1-男 2-女）”必须填写',
		'avatar.require' => '“头像”必须填写',
		'status.require' => '“状态（0-未知 1-绑定用户 2-未绑定 3-禁用）”必须填写',
		'session_token.require' => '“会话token（在未绑定用户之前 前端以会话token定位 目的是不公开openid）”必须填写',
		'expire_time.require' => '“token过期时间”必须填写',

    ];

	protected $scene = [
		'add'  => ["uid", "openid", "unionid", "channel", "nick", "gender", "avatar", "status", "session_token", "expire_time"],
		'edit' => ["uid", "openid", "unionid", "channel", "nick", "gender", "avatar", "status", "session_token", "expire_time"],
	];
}
