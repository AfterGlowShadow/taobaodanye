<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Finance extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'cat_id' => 'require',
		'cat_second_id' => 'require',
		'title' => 'require',
		'title_desc' => 'require',
		'shop_price' => 'require',
		'price' => 'require',
		'view_num' => 'require',
		'celection_num' => 'require',
		'service_type' => 'require',
		'service_name' => 'require',
		'address' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'cat_id.require' => '“所属分类”必须填写',
		'cat_second_id.require' => '“所属二级分类”必须填写',
		'title.require' => '“标题”必须填写',
		'title_desc.require' => '“描述”必须填写',
		'shop_price.require' => '“市场价”必须填写',
		'price.require' => '“价格”必须填写',
		'view_num.require' => '“累计申请量”必须填写',
		'celection_num.require' => '“收藏数量”必须填写',
		'service_type.require' => '“服务类型id”必须填写',
		'service_name.require' => '“服务类型名”必须填写',
		'address.require' => '“服务地区”必须填写',

    ];

	protected $scene = [
		'add'  => ["cat_id", "cat_second_id", "title", "title_desc", "shop_price", "price", "view_num", "celection_num", "service_type", "service_name", "address"],
		'edit' => ["cat_id", "cat_second_id", "title", "title_desc", "shop_price", "price", "view_num", "celection_num", "service_type", "service_name", "address"],
	];
}
