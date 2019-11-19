<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Industry extends Validate {
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
		'service_type' => 'require',
		'service_name' => 'require',
		'type' => 'require',
		'view_num' => 'require',
		'collection_num' => 'require',
		'address_id' => 'require',
		'address' => 'require',
		'meal_name' => 'require',
		'meal_ids' => 'require',
		'company_type' => 'require',
		'company_name' => 'require',
		'attribute_info' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'cat_id.require' => '“所属分类id”必须填写',
		'cat_second_id.require' => '“二级id”必须填写',
		'title.require' => '“标题”必须填写',
		'title_desc.require' => '“标题描述”必须填写',
		'shop_price.require' => '“市场价”必须填写',
		'price.require' => '“价格”必须填写',
		'service_type.require' => '“服务行业”必须填写',
		'service_name.require' => '“服务行业名”必须填写',
		'type.require' => '“1工商服务 2财税服务”必须填写',
		'view_num.require' => '“浏览量”必须填写',
		'collection_num.require' => '“收藏量”必须填写',
		'address_id.require' => '“地区id”必须填写',
		'address.require' => '“地区”必须填写',
		'meal_name.require' => '“套餐名称”必须填写',
		'meal_ids.require' => '“服务套餐”必须填写',
		'company_type.require' => '“企业类型”必须填写',
		'company_name.require' => '“企业类型名”必须填写',
		'attribute_info.require' => '“属性加价”必须填写',

    ];

	protected $scene = [
		'add'  => ["cat_id", "cat_second_id", "title", "title_desc", "shop_price", "price", "service_type", "service_name", "type", "view_num", "collection_num", "address_id", "address", "meal_name", "meal_ids", "company_type", "company_name", "attribute_info"],
		'edit' => ["cat_id", "cat_second_id", "title", "title_desc", "shop_price", "price", "service_type", "service_name", "type", "view_num", "collection_num", "address_id", "address", "meal_name", "meal_ids", "company_type", "company_name", "attribute_info"],
	];
}
