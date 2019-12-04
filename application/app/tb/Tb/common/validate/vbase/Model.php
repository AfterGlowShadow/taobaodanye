<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\common\validate\vbase;

use think\Validate;

class Model extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'name' => 'require|unique:app_tb_model,name',
		'url' => 'require',
		'field' => 'require',
		'config' => 'require',
		'function' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'name.require' => '“”必须填写',
		'name.unique' => '“”已存在',
		'url.require' => '“”必须填写',
		'field.require' => '“所用商品表字段”必须填写',
		'config.require' => '“配置信息”必须填写',
		'function.require' => '“请求方法”必须填写',

    ];

	protected $scene = [
		'add'  => ["name", "url", "field", "config", "function"],
		'edit' => ["name", "url", "field", "config", "function"],
	];
}
