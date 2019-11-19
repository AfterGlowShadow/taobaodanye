<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\validate;

use think\Validate;

class User extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:sys_rbac_user,name',
		'passwd' => 'require',
		'nickname' => 'require',
		'avatar' => 'require',
		'status' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '“用户名”必须填写',
		'name.unique' => '“用户名”已存在',
		'passwd.require' => '“密码”必须填写',
		'nickname.require' => '“昵称”必须填写',
		'avatar.require' => '“头像”必须填写',
		'status.require' => '“状态”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "passwd"],
		'edit' => ["name"],
		
		'change_pw' => ["passwd"],
		'reset_pw' => ["passwd"],
		
		'set_status' => ["status"],
	];
}
