<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\validate\vbase;

use think\Validate;

class RoleRule extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'role_id' => 'require',
		'rule_id' => 'require',
		'rule_url' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'role_id.require' => '“角色id”必须填写',
		'rule_id.require' => '“权限规则id”必须填写',
		'rule_url.require' => '“权限规则url”必须填写',

    ];

	protected $scene = [
		'add'  => ["role_id", "rule_id", "rule_url"],
		'edit' => ["role_id", "rule_id", "rule_url"],
	];
}
