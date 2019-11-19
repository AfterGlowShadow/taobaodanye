<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\validate\vbase;

use think\Validate;

class Role extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:sys_rbac_role,name',
		'intro' => 'require',
		'type' => 'require',
		'status' => 'require',
		'remark' => 'require',

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
		'intro.require' => '“简介”必须填写',
		'type.require' => '“类型（0-未知 1-通用）”必须填写',
		'status.require' => '“状态,1启用 0禁用”必须填写',
		'remark.require' => '“备注”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "intro", "type", "status", "remark"],
		'edit' => ["name", "intro", "type", "status", "remark"],
	];
}
