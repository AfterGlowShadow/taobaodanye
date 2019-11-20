<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\common\validate\vbase;

use think\Validate;

class Specs extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:app_attribute_specs,name',
		'classifyid' => 'require',
		'userid' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '“规格名称”必须填写',
		'name.unique' => '“规格名称”已存在',
		'classifyid.require' => '“所属分类id”必须填写',
		'userid.require' => '“使用用户添加规格时 用户的id”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "classifyid", "userid"],
		'edit' => ["name", "classifyid", "userid"],
	];
}
