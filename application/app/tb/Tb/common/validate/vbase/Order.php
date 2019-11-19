<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\common\validate\vbase;

use think\Validate;

class Order extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'phone' => 'require',
		'address' => 'require',
		'productid' => 'require',
		'price' => 'require',
		'pay_time' => 'require',
		'status' => 'require',
		'ordersn' => 'require',
		'orderoutsn' => 'require',
		'number' => 'require',
		'typeid' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'phone.require' => '“收件人手机号”必须填写',
		'address.require' => '“寄货地址”必须填写',
		'productid.require' => '“商品id”必须填写',
		'price.require' => '“价格”必须填写',
		'pay_time.require' => '“支付时间”必须填写',
		'status.require' => '“支付状态0未支付 1支付成功 2支付中 3待审核 4支付失败”必须填写',
		'ordersn.require' => '“订单编号”必须填写',
		'orderoutsn.require' => '“外部订单编号”必须填写',
		'number.require' => '“购买产品数量”必须填写',
		'typeid.require' => '“产品类型id”必须填写',

    ];

	protected $scene = [
		'add'  => ["phone", "address", "productid", "price", "pay_time", "status", "ordersn", "orderoutsn", "number", "typeid"],
		'edit' => ["phone", "address", "productid", "price", "pay_time", "status", "ordersn", "orderoutsn", "number", "typeid"],
	];
}
