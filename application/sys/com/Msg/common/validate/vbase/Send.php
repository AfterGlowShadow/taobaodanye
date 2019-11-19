<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Msg\common\validate\vbase;

use think\Validate;

class Send extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'send_id' => 'require',
		'receiver_id' => 'require',
		'send_param' => 'require',
		'send_time' => 'require',
		'read_flag' => 'require',
		'msg_text_id' => 'require',
		'status' => 'require',
		'addon_name' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'send_id.require' => '“发送者id”必须填写',
		'receiver_id.require' => '“接收者id”必须填写',
		'send_param.require' => '“附件参数 推送相关参数”必须填写',
		'send_time.require' => '“发送时间（保留定时发送）”必须填写',
		'read_flag.require' => '“已读标志（0-未读 1-已读）”必须填写',
		'msg_text_id.require' => '“消息内容id”必须填写',
		'status.require' => '“状态（0-等待发送 1-发送中 2-成功 3-失败）”必须填写',
		'addon_name.require' => '“应用名称”必须填写',

    ];

	protected $scene = [
		'add'  => ["send_id", "receiver_id", "send_param", "send_time", "read_flag", "msg_text_id", "status", "addon_name"],
		'edit' => ["send_id", "receiver_id", "send_param", "send_time", "read_flag", "msg_text_id", "status", "addon_name"],
	];
}
