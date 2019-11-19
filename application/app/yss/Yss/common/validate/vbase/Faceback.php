<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Faceback extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'content' => 'require',
		'uid' => 'require',
		'status' => 'require',
		'type' => 'require',
		'nickname' => 'require',
		'phone' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'content.require' => '“建议”必须填写',
		'uid.require' => '“用户id”必须填写',
		'status.require' => '“1已读 0未读”必须填写',
		'type.require' => '“1投诉 2建议”必须填写',
		'nickname.require' => '“称呼”必须填写',
		'phone.require' => '“手机号”必须填写',

    ];

	protected $scene = [
		'add'  => ["content", "uid", "status", "type", "nickname", "phone"],
		'edit' => ["content", "uid", "status", "type", "nickname", "phone"],
	];
}
