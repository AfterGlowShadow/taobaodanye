<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Msg\common\validate\vbase;

use think\Validate;

class Text extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'title' => 'require',
		'content' => 'require',
		'send_param' => 'require',
		'type' => 'require',
		'status' => 'require',
		'remark' => 'require',
		'addon_name' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'title.require' => '“标题”必须填写',
		'content.require' => '“内容”必须填写',
		'send_param.require' => '“附件参数 推送相关参数”必须填写',
		'type.require' => '“类型（0-未知 1-公众号推送 2-小程序推送 3-短信 4-邮箱 5-其他 大于100为自定义）”必须填写',
		'status.require' => '“状态（0-未知 1-待发送 2-发送中 3-已发送）”必须填写',
		'remark.require' => '“备注”必须填写',
		'addon_name.require' => '“应用名称”必须填写',

    ];

	protected $scene = [
		'add'  => ["title", "content", "send_param", "type", "status", "remark", "addon_name"],
		'edit' => ["title", "content", "send_param", "type", "status", "remark", "addon_name"],
	];
}
