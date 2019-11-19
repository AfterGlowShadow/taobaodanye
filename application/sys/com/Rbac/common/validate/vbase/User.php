<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\validate\vbase;

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
		'mobile' => 'require',
		'is_root' => 'require',
		'status' => 'require',
		'pid' => 'require',

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
		'mobile.require' => '“电话”必须填写',
		'is_root.require' => '“是否超级管理员（0-否 1-是）”必须填写',
		'status.require' => '“状态（1启用 0禁用）”必须填写',
		'pid.require' => '“所属的超管的id”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "passwd", "nickname", "avatar", "mobile", "is_root", "status", "pid"],
		'edit' => ["name", "passwd", "nickname", "avatar", "mobile", "is_root", "status", "pid"],
	];
}
