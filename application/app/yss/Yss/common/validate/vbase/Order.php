<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Order extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'uid' => 'require',
		'realname' => 'require',
		'mobile' => 'require',
		'product_number' => 'require',
		'order_number' => 'require',
		'company_sn' => 'require',
		'explor_id' => 'require',
		'explor_name' => 'require',
		'explor_phone' => 'require',
		'title' => 'require',
		'price' => 'require',
		'customer_id' => 'require',
		'customer_name' => 'require',
		'remark' => 'require',
		'real_price' => 'require',
		'pay_price' => 'require',
		'status' => 'require',
		'type' => 'require',
		'pay_time' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'uid.require' => '“购买人id”必须填写',
		'realname.require' => '“购买人姓名”必须填写',
		'mobile.require' => '“购买人手机号手机号”必须填写',
		'product_number.require' => '“数量”必须填写',
		'order_number.require' => '“订单号”必须填写',
		'company_sn.require' => '“企业编号”必须填写',
		'explor_id.require' => '“出售企业人id”必须填写',
		'explor_name.require' => '“出售人姓名”必须填写',
		'explor_phone.require' => '“出售人手机号”必须填写',
		'title.require' => '“标题”必须填写',
		'price.require' => '“价格”必须填写',
		'customer_id.require' => '“客服id”必须填写',
		'customer_name.require' => '“客服名”必须填写',
		'remark.require' => '“备注”必须填写',
		'real_price.require' => '“真实价格（确认后的价格）”必须填写',
		'pay_price.require' => '“支付价格”必须填写',
		'status.require' => '“状态（0-未知 1-未付款 2-交接中 3-已完成）”必须填写',
		'type.require' => '“类型 1企业注册 2工商变更 3财税服务 4购买企业”必须填写',
		'pay_time.require' => '“支付时间”必须填写',

    ];

	protected $scene = [
		'add'  => ["uid", "realname", "mobile", "product_number", "order_number", "company_sn", "explor_id", "explor_name", "explor_phone", "title", "price", "customer_id", "customer_name", "remark", "real_price", "pay_price", "status", "type", "pay_time"],
		'edit' => ["uid", "realname", "mobile", "product_number", "order_number", "company_sn", "explor_id", "explor_name", "explor_phone", "title", "price", "customer_id", "customer_name", "remark", "real_price", "pay_price", "status", "type", "pay_time"],
	];
}
