<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\common\validate\vbase;

use think\Validate;

class Classify extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:app_attribute_classify,name',
		'pga' => 'require',
		'level' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '“产品分类名称”必须填写',
		'name.unique' => '“产品分类名称”已存在',
		'pga.require' => '“父亲分类id”必须填写',
		'level.require' => '“层级(表明第几层)”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "pga", "level"],
		'edit' => ["name", "pga", "level"],
	];
}
