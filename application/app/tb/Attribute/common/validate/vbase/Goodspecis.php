<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\common\validate\vbase;

use think\Validate;

class Goodspecis extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'goodsid' => 'require',
		'specsidl' => 'require',
		'price' => 'require',
		'zprice' => 'require',
		'img' => 'require',
		'pricetype' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'goodsid.require' => '“商品id”必须填写',
		'specsidl.require' => '“规格id列表”必须填写',
		'price.require' => '“真实价格”必须填写',
		'zprice.require' => '“折扣价格”必须填写',
		'img.require' => '“图片地址”必须填写',
		'pricetype.require' => '“折扣还是不折扣(0为不折扣1为折扣)”必须填写',

    ];

	protected $scene = [
		'add'  => ["goodsid", "specsidl", "price", "zprice", "img", "pricetype"],
		'edit' => ["goodsid", "specsidl", "price", "zprice", "img", "pricetype"],
	];
}
