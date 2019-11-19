<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class CategoryDetail extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:app_yss_category_detail,name',
		'pid' => 'require',
		'is_show' => 'require',
		'type' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '“分类值”必须填写',
		'name.unique' => '“分类值”已存在',
		'pid.require' => '“上级id”必须填写',
		'is_show.require' => '“是否导航显示”必须填写',
		'type.require' => '“0”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "pid", "is_show", "type"],
		'edit' => ["name", "pid", "is_show", "type"],
	];
}
