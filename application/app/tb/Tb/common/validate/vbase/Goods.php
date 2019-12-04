<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\common\validate\vbase;

use think\Validate;

class Goods extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'goodsname' => 'require',
		'price' => 'require',
		'title' => 'require',
		'description' => 'require',
		'content' => 'require',
		'modelid' => 'require',
		'classify' => 'require',
		'qrcode' => 'require',
		'imgspecs' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'goodsname.require' => '“商品名称”必须填写',
		'price.require' => '“价格”必须填写',
		'title.require' => '“标题”必须填写',
		'description.require' => '“描述”必须填写',
		'content.require' => '“详情”必须填写',
		'modelid.require' => '“宣传模型id”必须填写',
		'classify.require' => '“商品分类id”必须填写',
		'qrcode.require' => '“二维码图片地址”必须填写',
		'imgspecs.require' => '“带图片规格id”必须填写',

    ];

	protected $scene = [
		'add'  => ["goodsname", "price", "title", "description", "content", "modelid", "classify", "qrcode", "imgspecs"],
		'edit' => ["goodsname", "price", "title", "description", "content", "modelid", "classify", "qrcode", "imgspecs"],
	];
}
