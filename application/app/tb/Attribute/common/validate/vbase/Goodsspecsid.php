<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\common\validate\vbase;

use think\Validate;

class Goodsspecsid extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'goods' => 'require',
		'specsid' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'goods.require' => '“商品id”必须填写',
		'specsid.require' => '“规格id”必须填写',

    ];

	protected $scene = [
		'add'  => ["goods", "specsid"],
		'edit' => ["goods", "specsid"],
	];
}
