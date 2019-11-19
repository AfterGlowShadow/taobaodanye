<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller\logic;

use app\app\yss\Yss\common\model\Sell;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Sells
 * 买家求购企业表
 * @api_name 买家求购企业
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\admin\controller\logic
 */
class Sells extends ControllerCommon {
    protected $_route_url = '/app/admin/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Sell();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 买家求购企业表
	 * @api_name 获取买家求购企业列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Sells.getList
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

		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$user_name = isset($param['user_name']) ? $param['user_name'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$order_sn = isset($param['order_sn']) ? $param['order_sn'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$country = isset($param['country']) ? $param['country'] : '';
		$industry_type = isset($param['industry_type']) ? $param['industry_type'] : 0;
		$industry_name = isset($param['industry_name']) ? $param['industry_name'] : '';
		$industry_second_type = isset($param['industry_second_type']) ? $param['industry_second_type'] : 0;
		$industry_second_name = isset($param['industry_second_name']) ? $param['industry_second_name'] : '';
		$investor_type = isset($param['investor_type']) ? $param['investor_type'] : 0;
		$investor_name = isset($param['investor_name']) ? $param['investor_name'] : '';
		$tax_types = isset($param['tax_types']) ? $param['tax_types'] : 0;
		$tax_types_name = isset($param['tax_types_name']) ? $param['tax_types_name'] : '';
		$intangible_assets = isset($param['intangible_assets']) ? $param['intangible_assets'] : 0;
		$intangible_assets_name = isset($param['intangible_assets_name']) ? $param['intangible_assets_name'] : '';
		$wechat_pay = isset($param['wechat_pay']) ? $param['wechat_pay'] : 0;
		$registered_capital = isset($param['registered_capital']) ? $param['registered_capital'] : 0;
		$registered_capital_name = isset($param['registered_capital_name']) ? $param['registered_capital_name'] : '';
		$years = isset($param['years']) ? $param['years'] : '';
		$psychological_price = isset($param['psychological_price']) ? $param['psychological_price'] : 0;
		$demand = isset($param['demand']) ? $param['demand'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;

        /** @var $m Sell */
        $m = $this->_model;
        $_where = [];
		isset($param['uid']) && $_where[] = ['uid', '=', $uid];
		isset($param['user_name']) && $_where[] = ['user_name', '=', $user_name];
		isset($param['phone']) && $_where[] = ['phone', '=', $phone];
		isset($param['order_sn']) && $_where[] = ['order_sn', '=', $order_sn];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['city']) && $_where[] = ['city', '=', $city];
		isset($param['country']) && $_where[] = ['country', '=', $country];
		isset($param['industry_type']) && $_where[] = ['industry_type', '=', $industry_type];
		isset($param['industry_name']) && $_where[] = ['industry_name', '=', $industry_name];
		isset($param['industry_second_type']) && $_where[] = ['industry_second_type', '=', $industry_second_type];
		isset($param['industry_second_name']) && $_where[] = ['industry_second_name', '=', $industry_second_name];
		isset($param['investor_type']) && $_where[] = ['investor_type', '=', $investor_type];
		isset($param['investor_name']) && $_where[] = ['investor_name', '=', $investor_name];
		isset($param['tax_types']) && $_where[] = ['tax_types', '=', $tax_types];
		isset($param['tax_types_name']) && $_where[] = ['tax_types_name', '=', $tax_types_name];
		isset($param['intangible_assets']) && $_where[] = ['intangible_assets', '=', $intangible_assets];
		isset($param['intangible_assets_name']) && $_where[] = ['intangible_assets_name', '=', $intangible_assets_name];
		isset($param['wechat_pay']) && $_where[] = ['wechat_pay', '=', $wechat_pay];
		isset($param['registered_capital']) && $_where[] = ['registered_capital', '=', $registered_capital];
		isset($param['registered_capital_name']) && $_where[] = ['registered_capital_name', '=', $registered_capital_name];
		isset($param['years']) && $_where[] = ['years', '=', $years];
		isset($param['psychological_price']) && $_where[] = ['psychological_price', '=', $psychological_price];
		isset($param['demand']) && $_where[] = ['demand', '=', $demand];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['status']) && $_where[] = ['status', '=', $status];

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
	 * 买家求购企业表
	 * @api_name 获取买家求购企业详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Sells.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Sell */
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
	 * 买家求购企业表
	 * @api_name 添加买家求购企业
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Sells.add
	 * 
	 * uid							用户id
	 * user_name					申请人名
	 * phone						手机号
	 * order_sn						编号
	 * title						求购标题
	 * city							市
	 * country						县
	 * industry_type				求购行业id一级
	 * industry_name				求购行业名一级
	 * industry_second_type			求购行业id二级
	 * industry_second_name			求购行业名二级
	 * investor_type				投资主体
	 * investor_name				投资主体字
	 * tax_types					纳税类型
	 * tax_types_name				纳税类型名
	 * intangible_assets			无形资产
	 * intangible_assets_name		无形资产名
	 * wechat_pay					微信支付 1否 2是
	 * registered_capital			注册资金
	 * registered_capital_name		注册资金名
	 * years						成立年限
	 * psychological_price			心理价位
	 * demand						求购需求
	 * status						1提交待查看 2已查看
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Sell */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$user_name = isset($param['user_name']) ? $param['user_name'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$order_sn = isset($param['order_sn']) ? $param['order_sn'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$country = isset($param['country']) ? $param['country'] : '';
		$industry_type = isset($param['industry_type']) ? $param['industry_type'] : 0;
		$industry_name = isset($param['industry_name']) ? $param['industry_name'] : '';
		$industry_second_type = isset($param['industry_second_type']) ? $param['industry_second_type'] : 0;
		$industry_second_name = isset($param['industry_second_name']) ? $param['industry_second_name'] : '';
		$investor_type = isset($param['investor_type']) ? $param['investor_type'] : 0;
		$investor_name = isset($param['investor_name']) ? $param['investor_name'] : '';
		$tax_types = isset($param['tax_types']) ? $param['tax_types'] : 0;
		$tax_types_name = isset($param['tax_types_name']) ? $param['tax_types_name'] : '';
		$intangible_assets = isset($param['intangible_assets']) ? $param['intangible_assets'] : 0;
		$intangible_assets_name = isset($param['intangible_assets_name']) ? $param['intangible_assets_name'] : '';
		$wechat_pay = isset($param['wechat_pay']) ? $param['wechat_pay'] : 0;
		$registered_capital = isset($param['registered_capital']) ? $param['registered_capital'] : 0;
		$registered_capital_name = isset($param['registered_capital_name']) ? $param['registered_capital_name'] : '';
		$years = isset($param['years']) ? $param['years'] : '';
		$psychological_price = isset($param['psychological_price']) ? $param['psychological_price'] : 0;
		$demand = isset($param['demand']) ? $param['demand'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		
		$_data = [];
		$_data['uid'] = $uid;
		$_data['user_name'] = $user_name;
		$_data['phone'] = $phone;
		$_data['order_sn'] = $order_sn;
		$_data['title'] = $title;
		$_data['city'] = $city;
		$_data['country'] = $country;
		$_data['industry_type'] = $industry_type;
		$_data['industry_name'] = $industry_name;
		$_data['industry_second_type'] = $industry_second_type;
		$_data['industry_second_name'] = $industry_second_name;
		$_data['investor_type'] = $investor_type;
		$_data['investor_name'] = $investor_name;
		$_data['tax_types'] = $tax_types;
		$_data['tax_types_name'] = $tax_types_name;
		$_data['intangible_assets'] = $intangible_assets;
		$_data['intangible_assets_name'] = $intangible_assets_name;
		$_data['wechat_pay'] = $wechat_pay;
		$_data['registered_capital'] = $registered_capital;
		$_data['registered_capital_name'] = $registered_capital_name;
		$_data['years'] = $years;
		$_data['psychological_price'] = $psychological_price;
		$_data['demand'] = $demand;
		$_data['status'] = $status;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 买家求购企业表
	 * @api_name 更改买家求购企业
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Sells.edit
	 *
	 * id							
	 * uid							用户id
	 * user_name					申请人名
	 * phone						手机号
	 * order_sn						编号
	 * title						求购标题
	 * city							市
	 * country						县
	 * industry_type				求购行业id一级
	 * industry_name				求购行业名一级
	 * industry_second_type			求购行业id二级
	 * industry_second_name			求购行业名二级
	 * investor_type				投资主体
	 * investor_name				投资主体字
	 * tax_types					纳税类型
	 * tax_types_name				纳税类型名
	 * intangible_assets			无形资产
	 * intangible_assets_name		无形资产名
	 * wechat_pay					微信支付 1否 2是
	 * registered_capital			注册资金
	 * registered_capital_name		注册资金名
	 * years						成立年限
	 * psychological_price			心理价位
	 * demand						求购需求
	 * status						1提交待查看 2已查看
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Sell */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$user_name = isset($param['user_name']) ? $param['user_name'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$order_sn = isset($param['order_sn']) ? $param['order_sn'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$country = isset($param['country']) ? $param['country'] : '';
		$industry_type = isset($param['industry_type']) ? $param['industry_type'] : 0;
		$industry_name = isset($param['industry_name']) ? $param['industry_name'] : '';
		$industry_second_type = isset($param['industry_second_type']) ? $param['industry_second_type'] : 0;
		$industry_second_name = isset($param['industry_second_name']) ? $param['industry_second_name'] : '';
		$investor_type = isset($param['investor_type']) ? $param['investor_type'] : 0;
		$investor_name = isset($param['investor_name']) ? $param['investor_name'] : '';
		$tax_types = isset($param['tax_types']) ? $param['tax_types'] : 0;
		$tax_types_name = isset($param['tax_types_name']) ? $param['tax_types_name'] : '';
		$intangible_assets = isset($param['intangible_assets']) ? $param['intangible_assets'] : 0;
		$intangible_assets_name = isset($param['intangible_assets_name']) ? $param['intangible_assets_name'] : '';
		$wechat_pay = isset($param['wechat_pay']) ? $param['wechat_pay'] : 0;
		$registered_capital = isset($param['registered_capital']) ? $param['registered_capital'] : 0;
		$registered_capital_name = isset($param['registered_capital_name']) ? $param['registered_capital_name'] : '';
		$years = isset($param['years']) ? $param['years'] : '';
		$psychological_price = isset($param['psychological_price']) ? $param['psychological_price'] : 0;
		$demand = isset($param['demand']) ? $param['demand'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		
		$_data = [];
		isset($param['uid']) && $_data['uid'] = $uid;
		isset($param['user_name']) && $_data['user_name'] = $user_name;
		isset($param['phone']) && $_data['phone'] = $phone;
		isset($param['order_sn']) && $_data['order_sn'] = $order_sn;
		isset($param['title']) && $_data['title'] = $title;
		isset($param['city']) && $_data['city'] = $city;
		isset($param['country']) && $_data['country'] = $country;
		isset($param['industry_type']) && $_data['industry_type'] = $industry_type;
		isset($param['industry_name']) && $_data['industry_name'] = $industry_name;
		isset($param['industry_second_type']) && $_data['industry_second_type'] = $industry_second_type;
		isset($param['industry_second_name']) && $_data['industry_second_name'] = $industry_second_name;
		isset($param['investor_type']) && $_data['investor_type'] = $investor_type;
		isset($param['investor_name']) && $_data['investor_name'] = $investor_name;
		isset($param['tax_types']) && $_data['tax_types'] = $tax_types;
		isset($param['tax_types_name']) && $_data['tax_types_name'] = $tax_types_name;
		isset($param['intangible_assets']) && $_data['intangible_assets'] = $intangible_assets;
		isset($param['intangible_assets_name']) && $_data['intangible_assets_name'] = $intangible_assets_name;
		isset($param['wechat_pay']) && $_data['wechat_pay'] = $wechat_pay;
		isset($param['registered_capital']) && $_data['registered_capital'] = $registered_capital;
		isset($param['registered_capital_name']) && $_data['registered_capital_name'] = $registered_capital_name;
		isset($param['years']) && $_data['years'] = $years;
		isset($param['psychological_price']) && $_data['psychological_price'] = $psychological_price;
		isset($param['demand']) && $_data['demand'] = $demand;
		isset($param['status']) && $_data['status'] = $status;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 买家求购企业表
	 * @api_name 删除买家求购企业
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Sells.delete
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
	 * 买家求购企业表
	 * @api_name 更改买家求购企业状态
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Yss.v1.Sells.setStatus
	 *
	 * id							
	 * status						1提交待查看 2已查看
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Sell */
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
