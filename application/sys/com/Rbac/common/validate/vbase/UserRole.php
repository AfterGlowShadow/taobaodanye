<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\validate\vbase;

use think\Validate;

class UserRole extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'user_id' => 'require',
		'role_id' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'user_id.require' => '“用户id”必须填写',
		'role_id.require' => '“角色id”必须填写',

    ];

	protected $scene = [
		'add'  => ["user_id", "role_id"],
		'edit' => ["user_id", "role_id"],
	];
}
