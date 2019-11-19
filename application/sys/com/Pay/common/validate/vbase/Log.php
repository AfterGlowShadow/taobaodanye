<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Pay\common\validate\vbase;

use think\Validate;

class Log extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'title' => 'require',
		'order_number' => 'require',
		'out_trade_no' => 'require',
		'realname' => 'require',
		'identity_number' => 'require',
		'money' => 'require',
		'openid' => 'require',
		'pay_type' => 'require',
		'reason' => 'require',
		'status' => 'require',
		'remark' => 'require',
		'tag' => 'require',
		'attach' => 'require',
		'notify_info' => 'require',
		'pay_time' => 'require',
		'refund_time' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'title.require' => '“标题（body subject）”必须填写',
		'order_number.require' => '“订单号”必须填写',
		'out_trade_no.require' => '“外部订单号”必须填写',
		'realname.require' => '“姓名”必须填写',
		'identity_number.require' => '“身份证号”必须填写',
		'money.require' => '“金额（total_amount total_fee）”必须填写',
		'openid.require' => '“微信openid 支付宝用不到”必须填写',
		'pay_type.require' => '“支付类型（0-未知 1-支付宝 2-微信 3-银行卡）”必须填写',
		'reason.require' => '“退款原因”必须填写',
		'status.require' => '“状态（0-未知 1-支付中 2-支付完成 3-支付失败 4-支付取消 5-退款中 6-退款完成 7-退款失败 8-退款取消）”必须填写',
		'remark.require' => '“备注”必须填写',
		'tag.require' => '“应用标记（区分不同支付）”必须填写',
		'attach.require' => '“附加数据json”必须填写',
		'notify_info.require' => '“回调返回内容信息”必须填写',
		'pay_time.require' => '“回调支付成功时间”必须填写',
		'refund_time.require' => '“退款成功时间”必须填写',

    ];

	protected $scene = [
		'add'  => ["title", "order_number", "out_trade_no", "realname", "identity_number", "money", "openid", "pay_type", "reason", "status", "remark", "tag", "attach", "notify_info", "pay_time", "refund_time"],
		'edit' => ["title", "order_number", "out_trade_no", "realname", "identity_number", "money", "openid", "pay_type", "reason", "status", "remark", "tag", "attach", "notify_info", "pay_time", "refund_time"],
	];
}
