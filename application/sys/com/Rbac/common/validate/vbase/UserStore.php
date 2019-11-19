<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\validate\vbase;

use think\Validate;

class UserStore extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'user_id' => 'require',
		'store_id' => 'require',
		'identity_type' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'user_id.require' => '“用户id”必须填写',
		'store_id.require' => '“店面id”必须填写',
		'identity_type.require' => '“身份类型（0-未知 1-店长 2-店员）”必须填写',

    ];

	protected $scene = [
		'add'  => ["user_id", "store_id", "identity_type"],
		'edit' => ["user_id", "store_id", "identity_type"],
	];
}
