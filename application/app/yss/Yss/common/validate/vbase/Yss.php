<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\validate\vbase;

use think\Validate;

class Yss extends Validate {
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		'order_sn' => 'require',
		'user_id' => 'require',
		'user_name' => 'require',
		'product_name' => 'require',
		'company_type' => 'require',
		'company_type_name' => 'require',
		'company_name' => 'require',
		'city' => 'require',
		'county_id' => 'require',
		'county' => 'require',
		'phone' => 'require',
		'credit_code' => 'require',
		'pay_taxes' => 'require',
		'pay_taxes_type' => 'require',
		'declare_tax' => 'require',
		'declare_tax_type' => 'require',
		'recive_invoice' => 'require',
		'internetbank' => 'require',
		'bank_account' => 'require',
		'bank_account_type' => 'require',
		'sell_price' => 'require',
		'qq' => 'require',
		'status' => 'require',
		'industry_type' => 'require',
		'industry_name' => 'require',
		'industry_second_type' => 'require',
		'industry_second_name' => 'require',
		'establishment' => 'require',
		'registered_capital' => 'require',
		'contributed_capital' => 'require',
		'business_license' => 'require',
		'legal_person' => 'require',
		'business_scope' => 'require',
		'other_infomation' => 'require',
		'view_num' => 'require',
		'celection_num' => 'require',
		'publish_time' => 'require',

	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
		'order_sn.require' => '“编号”必须填写',
		'user_id.require' => '“出售人id”必须填写',
		'user_name.require' => '“出售人名称”必须填写',
		'product_name.require' => '“商品名”必须填写',
		'company_type.require' => '“企业类型”必须填写',
		'company_type_name.require' => '“企业类型名称”必须填写',
		'company_name.require' => '“企业名称”必须填写',
		'city.require' => '“市”必须填写',
		'county_id.require' => '“地区id”必须填写',
		'county.require' => '“县”必须填写',
		'phone.require' => '“手机”必须填写',
		'credit_code.require' => '“注册号/统一社会信用代码”必须填写',
		'pay_taxes.require' => '“纳税类型”必须填写',
		'pay_taxes_type.require' => '“纳税类型id”必须填写',
		'declare_tax.require' => '“报税情况”必须填写',
		'declare_tax_type.require' => '“报税情况id”必须填写',
		'recive_invoice.require' => '“是否申领过发票 1否 2是”必须填写',
		'internetbank.require' => '“有无网银 1有 2否”必须填写',
		'bank_account.require' => '“银行账户”必须填写',
		'bank_account_type.require' => '“银行账户 1已开基本户 2未开基本户”必须填写',
		'sell_price.require' => '“出售金额 元”必须填写',
		'qq.require' => '“联系qq”必须填写',
		'status.require' => '“状态 1待审核 2在售中的企业 3交接中的企业 4已售出的企业 5拒绝”必须填写',
		'industry_type.require' => '“所属行业id”必须填写',
		'industry_name.require' => '“所属行业名”必须填写',
		'industry_second_type.require' => '“所属行业二级id”必须填写',
		'industry_second_name.require' => '“求购行业名二级”必须填写',
		'establishment.require' => '“成立日期”必须填写',
		'registered_capital.require' => '“注册资本”必须填写',
		'contributed_capital.require' => '“实缴资本”必须填写',
		'business_license.require' => '“营业执照图片”必须填写',
		'legal_person.require' => '“法人姓名”必须填写',
		'business_scope.require' => '“经营范围”必须填写',
		'other_infomation.require' => '“其他信息”必须填写',
		'view_num.require' => '“浏览量”必须填写',
		'celection_num.require' => '“收藏量”必须填写',
		'publish_time.require' => '“发布时间”必须填写',

    ];

	protected $scene = [
		'add'  => ["order_sn", "user_id", "user_name", "product_name", "company_type", "company_type_name", "company_name", "city", "county_id", "county", "phone", "credit_code", "pay_taxes", "pay_taxes_type", "declare_tax", "declare_tax_type", "recive_invoice", "internetbank", "bank_account", "bank_account_type", "sell_price", "qq", "status", "industry_type", "industry_name", "industry_second_type", "industry_second_name", "establishment", "registered_capital", "contributed_capital", "business_license", "legal_person", "business_scope", "other_infomation", "view_num", "celection_num", "publish_time"],
		'edit' => ["order_sn", "user_id", "user_name", "product_name", "company_type", "company_type_name", "company_name", "city", "county_id", "county", "phone", "credit_code", "pay_taxes", "pay_taxes_type", "declare_tax", "declare_tax_type", "recive_invoice", "internetbank", "bank_account", "bank_account_type", "sell_price", "qq", "status", "industry_type", "industry_name", "industry_second_type", "industry_second_name", "establishment", "registered_capital", "contributed_capital", "business_license", "legal_person", "business_scope", "other_infomation", "view_num", "celection_num", "publish_time"],
	];
}
