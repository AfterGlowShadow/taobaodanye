<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Vars\common\validate\vbase;

use think\Validate;

class Vars extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'var' => 'require',
		'name' => 'require|unique:sys_vars,name',
		'intro' => 'require',
		'value' => 'require',
		'type' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'var.require' => '“识别变量名”必须填写',
		'name.require' => '“名称”必须填写',
		'name.unique' => '“名称”已存在',
		'intro.require' => '“简介”必须填写',
		'value.require' => '“变量值（json）”必须填写',
		'type.require' => '“类型（普通）”必须填写',

    ];

	protected $scene = [
		'add'  => ["var", "name", "intro", "value", "type"],
		'edit' => ["var", "name", "intro", "value", "type"],
	];
}
