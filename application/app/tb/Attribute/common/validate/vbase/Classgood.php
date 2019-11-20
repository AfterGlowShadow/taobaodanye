<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\common\validate\vbase;

use think\Validate;

class Classgood extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'classify' => 'require',
		'goodsid' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'classify.require' => '“分类id”必须填写',
		'goodsid.require' => '“商品id”必须填写',

    ];

	protected $scene = [
		'add'  => ["classify", "goodsid"],
		'edit' => ["classify", "goodsid"],
	];
}
