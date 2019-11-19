<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller\logic;

use app\app\yss\Yss\common\model\Yss;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Ysss
 * 卖家出售企业表
 * @api_name 卖家出售企业
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\api\controller\logic
 */
class Ysss extends ControllerCommon {
    protected $_route_url = '/app/api/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Yss();

        // $this->need_check_token = false;
        // $this->check_token_white_list = [
        //     ['c' => 'Index', 'a' => 'test'],
        // ];
    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 卖家出售企业表
	 * @api_name 获取卖家出售企业列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Ysss.getList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getList() {
        $param = $this->param;

        $page_num = isset($param['page_num']) ? $param['page_num'] : 1;
        $page_limit = isset($param['page_limit']) ? $param['page_limit'] : PHP_INT_MAX;

		$order_sn = isset($param['order_sn']) ? $param['order_sn'] : '';
		$user_id = isset($param['user_id']) ? $param['user_id'] : 0;
		$user_name = isset($param['user_name']) ? $param['user_name'] : '';
		$product_name = isset($param['product_name']) ? $param['product_name'] : '';
		$company_type = isset($param['company_type']) ? $param['company_type'] : 0;
		$company_type_name = isset($param['company_type_name']) ? $param['company_type_name'] : '';
		$company_name = isset($param['company_name']) ? $param['company_name'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$county_id = isset($param['county_id']) ? $param['county_id'] : 0;
		$county = isset($param['county']) ? $param['county'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$credit_code = isset($param['credit_code']) ? $param['credit_code'] : '';
		$pay_taxes = isset($param['pay_taxes']) ? $param['pay_taxes'] : '';
		$pay_taxes_type = isset($param['pay_taxes_type']) ? $param['pay_taxes_type'] : 0;
		$declare_tax = isset($param['declare_tax']) ? $param['declare_tax'] : '';
		$declare_tax_type = isset($param['declare_tax_type']) ? $param['declare_tax_type'] : 0;
		$recive_invoice = isset($param['recive_invoice']) ? $param['recive_invoice'] : 0;
		$internetbank = isset($param['internetbank']) ? $param['internetbank'] : 0;
		$bank_account = isset($param['bank_account']) ? $param['bank_account'] : '';
		$bank_account_type = isset($param['bank_account_type']) ? $param['bank_account_type'] : 0;
		$sell_price = isset($param['sell_price']) ? $param['sell_price'] : 0;
		$qq = isset($param['qq']) ? $param['qq'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$industry_type = isset($param['industry_type']) ? $param['industry_type'] : 0;
		$industry_name = isset($param['industry_name']) ? $param['industry_name'] : '';
		$industry_second_type = isset($param['industry_second_type']) ? $param['industry_second_type'] : 0;
		$industry_second_name = isset($param['industry_second_name']) ? $param['industry_second_name'] : '';
		$establishment = isset($param['establishment']) ? $param['establishment'] : '';
		$registered_capital = isset($param['registered_capital']) ? $param['registered_capital'] : 0;
		$contributed_capital = isset($param['contributed_capital']) ? $param['contributed_capital'] : 0;
		$business_license = isset($param['business_license']) ? $param['business_license'] : '';
		$legal_person = isset($param['legal_person']) ? $param['legal_person'] : '';
		$business_scope = isset($param['business_scope']) ? $param['business_scope'] : '';
		$other_infomation = isset($param['other_infomation']) ? $param['other_infomation'] : '';
		$view_num = isset($param['view_num']) ? $param['view_num'] : 0;
		$celection_num = isset($param['celection_num']) ? $param['celection_num'] : 0;
		$publish_time = isset($param['publish_time']) ? $param['publish_time'] : 0;

        /** @var $m Yss */
        $m = $this->_model;
        $_where = [];
		isset($param['order_sn']) && $_where[] = ['order_sn', '=', $order_sn];
		isset($param['user_id']) && $_where[] = ['user_id', '=', $user_id];
		isset($param['user_name']) && $_where[] = ['user_name', '=', $user_name];
		isset($param['product_name']) && $_where[] = ['product_name', '=', $product_name];
		isset($param['company_type']) && $_where[] = ['company_type', '=', $company_type];
		isset($param['company_type_name']) && $_where[] = ['company_type_name', '=', $company_type_name];
		isset($param['company_name']) && $_where[] = ['company_name', '=', $company_name];
		isset($param['city']) && $_where[] = ['city', '=', $city];
		isset($param['county_id']) && $_where[] = ['county_id', '=', $county_id];
		isset($param['county']) && $_where[] = ['county', '=', $county];
		isset($param['phone']) && $_where[] = ['phone', '=', $phone];
		isset($param['credit_code']) && $_where[] = ['credit_code', '=', $credit_code];
		isset($param['pay_taxes']) && $_where[] = ['pay_taxes', '=', $pay_taxes];
		isset($param['pay_taxes_type']) && $_where[] = ['pay_taxes_type', '=', $pay_taxes_type];
		isset($param['declare_tax']) && $_where[] = ['declare_tax', '=', $declare_tax];
		isset($param['declare_tax_type']) && $_where[] = ['declare_tax_type', '=', $declare_tax_type];
		isset($param['recive_invoice']) && $_where[] = ['recive_invoice', '=', $recive_invoice];
		isset($param['internetbank']) && $_where[] = ['internetbank', '=', $internetbank];
		isset($param['bank_account']) && $_where[] = ['bank_account', '=', $bank_account];
		isset($param['bank_account_type']) && $_where[] = ['bank_account_type', '=', $bank_account_type];
		isset($param['sell_price']) && $_where[] = ['sell_price', '=', $sell_price];
		isset($param['qq']) && $_where[] = ['qq', '=', $qq];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['industry_type']) && $_where[] = ['industry_type', '=', $industry_type];
		isset($param['industry_name']) && $_where[] = ['industry_name', '=', $industry_name];
		isset($param['industry_second_type']) && $_where[] = ['industry_second_type', '=', $industry_second_type];
		isset($param['industry_second_name']) && $_where[] = ['industry_second_name', '=', $industry_second_name];
		isset($param['establishment']) && $_where[] = ['establishment', '=', $establishment];
		isset($param['registered_capital']) && $_where[] = ['registered_capital', '=', $registered_capital];
		isset($param['contributed_capital']) && $_where[] = ['contributed_capital', '=', $contributed_capital];
		isset($param['business_license']) && $_where[] = ['business_license', '=', $business_license];
		isset($param['legal_person']) && $_where[] = ['legal_person', '=', $legal_person];
		isset($param['business_scope']) && $_where[] = ['business_scope', '=', $business_scope];
		isset($param['other_infomation']) && $_where[] = ['other_infomation', '=', $other_infomation];
		isset($param['view_num']) && $_where[] = ['view_num', '=', $view_num];
		isset($param['celection_num']) && $_where[] = ['celection_num', '=', $celection_num];
		isset($param['publish_time']) && $_where[] = ['publish_time', '=', $publish_time];

		$_order = ['create_time' => 'DESC'];

        $_field = isset($this->_buf['getList']['field']) ? $this->_buf['getList']['field'] : '*';
        $_link = isset($this->_buf['getList']['link']) ? $this->_buf['getList']['link'] : false;
        $_join = isset($this->_buf['getList']['join']) ? $this->_buf['getList']['join'] : [];
        $_where = isset($this->_buf['getList']['where']) ? array_merge($_where, $this->_buf['getList']['where']) : $_where;
        $_order = isset($this->_buf['getList']['order']) ? $this->_buf['getList']['order'] : $_order;
        $_param = isset($this->_buf['getList']['param']) ? $this->_buf['getList']['param'] : [];
        $re = $m->getList($_where, $_order, $page_num, $page_limit, $_field, $_link, $_join, $_param);
        if (!is_return_ok($re)) {
            return return_json($re);
        }

        $reData = get_return_data($re);
        return rjData($reData);
    }

    /**
     * 获取详情 通过id查询
	 * 卖家出售企业表
	 * @api_name 获取卖家出售企业详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Ysss.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Yss */
        $m = $this->_model;
        $param = $this->param;

        $id = isset($param['id']) ? $param['id'] : 0;

        $_field = isset($this->_buf['getItemById']['field']) ? $this->_buf['getItemById']['field'] : '*';
        $_link = isset($this->_buf['getItemById']['link']) ? $this->_buf['getItemById']['link'] : false;
        $_join = isset($this->_buf['getItemById']['join']) ? $this->_buf['getItemById']['join'] : [];
        $_param = isset($this->_buf['getItemById']['param']) ? $this->_buf['getItemById']['param'] : [];
        $re = $m->getItemById($id, $_field, $_link, $_join, $_param);
        if (!is_return_ok($re)) {
            return return_json($re);
        }

        $reData = get_return_data($re);

        return rjData($reData);
    }

	/**
	 * 添加
	 * 卖家出售企业表
	 * @api_name 添加卖家出售企业
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Ysss.add
	 * 
	 * order_sn					编号
	 * user_id					出售人id
	 * user_name				出售人名称
	 * product_name				商品名
	 * company_type				企业类型
	 * company_type_name		企业类型名称
	 * company_name				企业名称
	 * city						市
	 * county_id				地区id
	 * county					县
	 * phone					手机
	 * credit_code				注册号/统一社会信用代码
	 * pay_taxes				纳税类型
	 * pay_taxes_type			纳税类型id
	 * declare_tax				报税情况
	 * declare_tax_type			报税情况id
	 * recive_invoice			是否申领过发票 1否 2是
	 * internetbank				有无网银 1有 2否
	 * bank_account				银行账户
	 * bank_account_type		银行账户 1已开基本户 2未开基本户
	 * sell_price				出售金额 元
	 * qq						联系qq
	 * status					状态 1待审核 2在售中的企业 3交接中的企业 4已售出的企业 5拒绝
	 * industry_type			所属行业id
	 * industry_name			所属行业名
	 * industry_second_type		所属行业二级id
	 * industry_second_name		求购行业名二级
	 * establishment			成立日期
	 * registered_capital		注册资本
	 * contributed_capital		实缴资本
	 * business_license			营业执照图片
	 * legal_person				法人姓名
	 * business_scope			经营范围
	 * other_infomation			其他信息
	 * view_num					浏览量
	 * celection_num			收藏量
	 * publish_time				发布时间
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Yss */
		$m = $this->_model;
		$param = $this->param;
		
		$order_sn = isset($param['order_sn']) ? $param['order_sn'] : '';
		$user_id = isset($param['user_id']) ? $param['user_id'] : 0;
		$user_name = isset($param['user_name']) ? $param['user_name'] : '';
		$product_name = isset($param['product_name']) ? $param['product_name'] : '';
		$company_type = isset($param['company_type']) ? $param['company_type'] : 0;
		$company_type_name = isset($param['company_type_name']) ? $param['company_type_name'] : '';
		$company_name = isset($param['company_name']) ? $param['company_name'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$county_id = isset($param['county_id']) ? $param['county_id'] : 0;
		$county = isset($param['county']) ? $param['county'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$credit_code = isset($param['credit_code']) ? $param['credit_code'] : '';
		$pay_taxes = isset($param['pay_taxes']) ? $param['pay_taxes'] : '';
		$pay_taxes_type = isset($param['pay_taxes_type']) ? $param['pay_taxes_type'] : 0;
		$declare_tax = isset($param['declare_tax']) ? $param['declare_tax'] : '';
		$declare_tax_type = isset($param['declare_tax_type']) ? $param['declare_tax_type'] : 0;
		$recive_invoice = isset($param['recive_invoice']) ? $param['recive_invoice'] : 0;
		$internetbank = isset($param['internetbank']) ? $param['internetbank'] : 0;
		$bank_account = isset($param['bank_account']) ? $param['bank_account'] : '';
		$bank_account_type = isset($param['bank_account_type']) ? $param['bank_account_type'] : 0;
		$sell_price = isset($param['sell_price']) ? $param['sell_price'] : 0;
		$qq = isset($param['qq']) ? $param['qq'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$industry_type = isset($param['industry_type']) ? $param['industry_type'] : 0;
		$industry_name = isset($param['industry_name']) ? $param['industry_name'] : '';
		$industry_second_type = isset($param['industry_second_type']) ? $param['industry_second_type'] : 0;
		$industry_second_name = isset($param['industry_second_name']) ? $param['industry_second_name'] : '';
		$establishment = isset($param['establishment']) ? $param['establishment'] : '';
		$registered_capital = isset($param['registered_capital']) ? $param['registered_capital'] : 0;
		$contributed_capital = isset($param['contributed_capital']) ? $param['contributed_capital'] : 0;
		$business_license = isset($param['business_license']) ? $param['business_license'] : '';
		$legal_person = isset($param['legal_person']) ? $param['legal_person'] : '';
		$business_scope = isset($param['business_scope']) ? $param['business_scope'] : '';
		$other_infomation = isset($param['other_infomation']) ? $param['other_infomation'] : '';
		$view_num = isset($param['view_num']) ? $param['view_num'] : 0;
		$celection_num = isset($param['celection_num']) ? $param['celection_num'] : 0;
		$publish_time = isset($param['publish_time']) ? $param['publish_time'] : 0;
		
		$_data = [];
		$_data['order_sn'] = $order_sn;
		$_data['user_id'] = $user_id;
		$_data['user_name'] = $user_name;
		$_data['product_name'] = $product_name;
		$_data['company_type'] = $company_type;
		$_data['company_type_name'] = $company_type_name;
		$_data['company_name'] = $company_name;
		$_data['city'] = $city;
		$_data['county_id'] = $county_id;
		$_data['county'] = $county;
		$_data['phone'] = $phone;
		$_data['credit_code'] = $credit_code;
		$_data['pay_taxes'] = $pay_taxes;
		$_data['pay_taxes_type'] = $pay_taxes_type;
		$_data['declare_tax'] = $declare_tax;
		$_data['declare_tax_type'] = $declare_tax_type;
		$_data['recive_invoice'] = $recive_invoice;
		$_data['internetbank'] = $internetbank;
		$_data['bank_account'] = $bank_account;
		$_data['bank_account_type'] = $bank_account_type;
		$_data['sell_price'] = $sell_price;
		$_data['qq'] = $qq;
		$_data['status'] = $status;
		$_data['industry_type'] = $industry_type;
		$_data['industry_name'] = $industry_name;
		$_data['industry_second_type'] = $industry_second_type;
		$_data['industry_second_name'] = $industry_second_name;
		$_data['establishment'] = $establishment;
		$_data['registered_capital'] = $registered_capital;
		$_data['contributed_capital'] = $contributed_capital;
		$_data['business_license'] = $business_license;
		$_data['legal_person'] = $legal_person;
		$_data['business_scope'] = $business_scope;
		$_data['other_infomation'] = $other_infomation;
		$_data['view_num'] = $view_num;
		$_data['celection_num'] = $celection_num;
		$_data['publish_time'] = $publish_time;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 卖家出售企业表
	 * @api_name 更改卖家出售企业
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Ysss.edit
	 *
	 * id						
	 * order_sn					编号
	 * user_id					出售人id
	 * user_name				出售人名称
	 * product_name				商品名
	 * company_type				企业类型
	 * company_type_name		企业类型名称
	 * company_name				企业名称
	 * city						市
	 * county_id				地区id
	 * county					县
	 * phone					手机
	 * credit_code				注册号/统一社会信用代码
	 * pay_taxes				纳税类型
	 * pay_taxes_type			纳税类型id
	 * declare_tax				报税情况
	 * declare_tax_type			报税情况id
	 * recive_invoice			是否申领过发票 1否 2是
	 * internetbank				有无网银 1有 2否
	 * bank_account				银行账户
	 * bank_account_type		银行账户 1已开基本户 2未开基本户
	 * sell_price				出售金额 元
	 * qq						联系qq
	 * status					状态 1待审核 2在售中的企业 3交接中的企业 4已售出的企业 5拒绝
	 * industry_type			所属行业id
	 * industry_name			所属行业名
	 * industry_second_type		所属行业二级id
	 * industry_second_name		求购行业名二级
	 * establishment			成立日期
	 * registered_capital		注册资本
	 * contributed_capital		实缴资本
	 * business_license			营业执照图片
	 * legal_person				法人姓名
	 * business_scope			经营范围
	 * other_infomation			其他信息
	 * view_num					浏览量
	 * celection_num			收藏量
	 * publish_time				发布时间
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Yss */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$order_sn = isset($param['order_sn']) ? $param['order_sn'] : '';
		$user_id = isset($param['user_id']) ? $param['user_id'] : 0;
		$user_name = isset($param['user_name']) ? $param['user_name'] : '';
		$product_name = isset($param['product_name']) ? $param['product_name'] : '';
		$company_type = isset($param['company_type']) ? $param['company_type'] : 0;
		$company_type_name = isset($param['company_type_name']) ? $param['company_type_name'] : '';
		$company_name = isset($param['company_name']) ? $param['company_name'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$county_id = isset($param['county_id']) ? $param['county_id'] : 0;
		$county = isset($param['county']) ? $param['county'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$credit_code = isset($param['credit_code']) ? $param['credit_code'] : '';
		$pay_taxes = isset($param['pay_taxes']) ? $param['pay_taxes'] : '';
		$pay_taxes_type = isset($param['pay_taxes_type']) ? $param['pay_taxes_type'] : 0;
		$declare_tax = isset($param['declare_tax']) ? $param['declare_tax'] : '';
		$declare_tax_type = isset($param['declare_tax_type']) ? $param['declare_tax_type'] : 0;
		$recive_invoice = isset($param['recive_invoice']) ? $param['recive_invoice'] : 0;
		$internetbank = isset($param['internetbank']) ? $param['internetbank'] : 0;
		$bank_account = isset($param['bank_account']) ? $param['bank_account'] : '';
		$bank_account_type = isset($param['bank_account_type']) ? $param['bank_account_type'] : 0;
		$sell_price = isset($param['sell_price']) ? $param['sell_price'] : 0;
		$qq = isset($param['qq']) ? $param['qq'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$industry_type = isset($param['industry_type']) ? $param['industry_type'] : 0;
		$industry_name = isset($param['industry_name']) ? $param['industry_name'] : '';
		$industry_second_type = isset($param['industry_second_type']) ? $param['industry_second_type'] : 0;
		$industry_second_name = isset($param['industry_second_name']) ? $param['industry_second_name'] : '';
		$establishment = isset($param['establishment']) ? $param['establishment'] : '';
		$registered_capital = isset($param['registered_capital']) ? $param['registered_capital'] : 0;
		$contributed_capital = isset($param['contributed_capital']) ? $param['contributed_capital'] : 0;
		$business_license = isset($param['business_license']) ? $param['business_license'] : '';
		$legal_person = isset($param['legal_person']) ? $param['legal_person'] : '';
		$business_scope = isset($param['business_scope']) ? $param['business_scope'] : '';
		$other_infomation = isset($param['other_infomation']) ? $param['other_infomation'] : '';
		$view_num = isset($param['view_num']) ? $param['view_num'] : 0;
		$celection_num = isset($param['celection_num']) ? $param['celection_num'] : 0;
		$publish_time = isset($param['publish_time']) ? $param['publish_time'] : 0;
		
		$_data = [];
		isset($param['order_sn']) && $_data['order_sn'] = $order_sn;
		isset($param['user_id']) && $_data['user_id'] = $user_id;
		isset($param['user_name']) && $_data['user_name'] = $user_name;
		isset($param['product_name']) && $_data['product_name'] = $product_name;
		isset($param['company_type']) && $_data['company_type'] = $company_type;
		isset($param['company_type_name']) && $_data['company_type_name'] = $company_type_name;
		isset($param['company_name']) && $_data['company_name'] = $company_name;
		isset($param['city']) && $_data['city'] = $city;
		isset($param['county_id']) && $_data['county_id'] = $county_id;
		isset($param['county']) && $_data['county'] = $county;
		isset($param['phone']) && $_data['phone'] = $phone;
		isset($param['credit_code']) && $_data['credit_code'] = $credit_code;
		isset($param['pay_taxes']) && $_data['pay_taxes'] = $pay_taxes;
		isset($param['pay_taxes_type']) && $_data['pay_taxes_type'] = $pay_taxes_type;
		isset($param['declare_tax']) && $_data['declare_tax'] = $declare_tax;
		isset($param['declare_tax_type']) && $_data['declare_tax_type'] = $declare_tax_type;
		isset($param['recive_invoice']) && $_data['recive_invoice'] = $recive_invoice;
		isset($param['internetbank']) && $_data['internetbank'] = $internetbank;
		isset($param['bank_account']) && $_data['bank_account'] = $bank_account;
		isset($param['bank_account_type']) && $_data['bank_account_type'] = $bank_account_type;
		isset($param['sell_price']) && $_data['sell_price'] = $sell_price;
		isset($param['qq']) && $_data['qq'] = $qq;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['industry_type']) && $_data['industry_type'] = $industry_type;
		isset($param['industry_name']) && $_data['industry_name'] = $industry_name;
		isset($param['industry_second_type']) && $_data['industry_second_type'] = $industry_second_type;
		isset($param['industry_second_name']) && $_data['industry_second_name'] = $industry_second_name;
		isset($param['establishment']) && $_data['establishment'] = $establishment;
		isset($param['registered_capital']) && $_data['registered_capital'] = $registered_capital;
		isset($param['contributed_capital']) && $_data['contributed_capital'] = $contributed_capital;
		isset($param['business_license']) && $_data['business_license'] = $business_license;
		isset($param['legal_person']) && $_data['legal_person'] = $legal_person;
		isset($param['business_scope']) && $_data['business_scope'] = $business_scope;
		isset($param['other_infomation']) && $_data['other_infomation'] = $other_infomation;
		isset($param['view_num']) && $_data['view_num'] = $view_num;
		isset($param['celection_num']) && $_data['celection_num'] = $celection_num;
		isset($param['publish_time']) && $_data['publish_time'] = $publish_time;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 卖家出售企业表
	 * @api_name 删除卖家出售企业
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Ysss.delete
     *
     * id
     * @return \think\response\Json
     * @throws \Throwable
     * @throws \think\Exception\DbException
     */
    public function delete() {
        return parent::delete();
    }

	
	/**
	 * 更改状态
	 * 卖家出售企业表
	 * @api_name 更改卖家出售企业状态
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Ysss.setStatus
	 *
	 * id						
	 * status					状态 1待审核 2在售中的企业 3交接中的企业 4已售出的企业 5拒绝
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Yss */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $this->p('id');
		$status = $this->p('status');
		
		$_d = [];
		$_d['status'] = $status;
		$re = $m->editById($id, $_d);
		return return_json($re);
	}

}
