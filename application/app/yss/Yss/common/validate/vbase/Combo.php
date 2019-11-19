<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Combo extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:app_yss_combo,name',
		'cat_ids' => 'require',
		'cat_names' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '“名称”必须填写',
		'name.unique' => '“名称”已存在',
		'cat_ids.require' => '“所有子分类id”必须填写',
		'cat_names.require' => '“所有子分类名”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "cat_ids", "cat_names"],
		'edit' => ["name", "cat_ids", "cat_names"],
	];
}
