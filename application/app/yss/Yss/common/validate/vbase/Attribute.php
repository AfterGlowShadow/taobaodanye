<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Attribute extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'ind_id' => 'require',
		'cat_ids' => 'require',
		'cat_price' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'ind_id.require' => '“工商变更id”必须填写',
		'cat_ids.require' => '“属性id 中划线隔开”必须填写',
		'cat_price.require' => '“属性钱”必须填写',

    ];

	protected $scene = [
		'add'  => ["ind_id", "cat_ids", "cat_price"],
		'edit' => ["ind_id", "cat_ids", "cat_price"],
	];
}
