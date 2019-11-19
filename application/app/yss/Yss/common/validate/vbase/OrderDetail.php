<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class OrderDetail extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'order_id' => 'require',
		'type' => 'require',
		'company_type' => 'require',
		'industry_type' => 'require',
		'meal_type' => 'require',
		'address' => 'require',
		'pay_taxes_type' => 'require',
		'operating_time' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'order_id.require' => '“订单id”必须填写',
		'type.require' => '“类型”必须填写',
		'company_type.require' => '“企业类型”必须填写',
		'industry_type.require' => '“行业类别”必须填写',
		'meal_type.require' => '“套餐”必须填写',
		'address.require' => '“地区”必须填写',
		'pay_taxes_type.require' => '“纳税类型”必须填写',
		'operating_time.require' => '“经营时间”必须填写',

    ];

	protected $scene = [
		'add'  => ["order_id", "type", "company_type", "industry_type", "meal_type", "address", "pay_taxes_type", "operating_time"],
		'edit' => ["order_id", "type", "company_type", "industry_type", "meal_type", "address", "pay_taxes_type", "operating_time"],
	];
}
