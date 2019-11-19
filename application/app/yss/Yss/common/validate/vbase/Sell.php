<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Sell extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'uid' => 'require',
		'user_name' => 'require',
		'phone' => 'require',
		'order_sn' => 'require',
		'title' => 'require',
		'city' => 'require',
		'country' => 'require',
		'industry_type' => 'require',
		'industry_name' => 'require',
		'industry_second_type' => 'require',
		'industry_second_name' => 'require',
		'investor_type' => 'require',
		'investor_name' => 'require',
		'tax_types' => 'require',
		'tax_types_name' => 'require',
		'intangible_assets' => 'require',
		'intangible_assets_name' => 'require',
		'wechat_pay' => 'require',
		'registered_capital' => 'require',
		'registered_capital_name' => 'require',
		'years' => 'require',
		'psychological_price' => 'require',
		'demand' => 'require',
		'status' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'uid.require' => '“用户id”必须填写',
		'user_name.require' => '“申请人名”必须填写',
		'phone.require' => '“手机号”必须填写',
		'order_sn.require' => '“编号”必须填写',
		'title.require' => '“求购标题”必须填写',
		'city.require' => '“市”必须填写',
		'country.require' => '“县”必须填写',
		'industry_type.require' => '“求购行业id一级”必须填写',
		'industry_name.require' => '“求购行业名一级”必须填写',
		'industry_second_type.require' => '“求购行业id二级”必须填写',
		'industry_second_name.require' => '“求购行业名二级”必须填写',
		'investor_type.require' => '“投资主体”必须填写',
		'investor_name.require' => '“投资主体字”必须填写',
		'tax_types.require' => '“纳税类型”必须填写',
		'tax_types_name.require' => '“纳税类型名”必须填写',
		'intangible_assets.require' => '“无形资产”必须填写',
		'intangible_assets_name.require' => '“无形资产名”必须填写',
		'wechat_pay.require' => '“微信支付 1否 2是”必须填写',
		'registered_capital.require' => '“注册资金”必须填写',
		'registered_capital_name.require' => '“注册资金名”必须填写',
		'years.require' => '“成立年限”必须填写',
		'psychological_price.require' => '“心理价位”必须填写',
		'demand.require' => '“求购需求”必须填写',
		'status.require' => '“1提交待查看 2已查看”必须填写',

    ];

	protected $scene = [
		'add'  => ["uid", "user_name", "phone", "order_sn", "title", "city", "country", "industry_type", "industry_name", "industry_second_type", "industry_second_name", "investor_type", "investor_name", "tax_types", "tax_types_name", "intangible_assets", "intangible_assets_name", "wechat_pay", "registered_capital", "registered_capital_name", "years", "psychological_price", "demand", "status"],
		'edit' => ["uid", "user_name", "phone", "order_sn", "title", "city", "country", "industry_type", "industry_name", "industry_second_type", "industry_second_name", "investor_type", "investor_name", "tax_types", "tax_types_name", "intangible_assets", "intangible_assets_name", "wechat_pay", "registered_capital", "registered_capital_name", "years", "psychological_price", "demand", "status"],
	];
}
