<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller\logic;

use app\app\yss\Yss\common\model\OrderDetail;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class OrderDetails
 * @api_name OrderDetails
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\yss\Yss\admin\controller\logic
 */
class OrderDetails extends ControllerCommon {
    protected $_route_url = '/app/admin/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new OrderDetail();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * @api_name 获取OrderDetails列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.OrderDetails.getList
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

		$order_id = isset($param['order_id']) ? $param['order_id'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$company_type = isset($param['company_type']) ? $param['company_type'] : '';
		$industry_type = isset($param['industry_type']) ? $param['industry_type'] : '';
		$meal_type = isset($param['meal_type']) ? $param['meal_type'] : '';
		$address = isset($param['address']) ? $param['address'] : '';
		$pay_taxes_type = isset($param['pay_taxes_type']) ? $param['pay_taxes_type'] : '';
		$operating_time = isset($param['operating_time']) ? $param['operating_time'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m OrderDetail */
        $m = $this->_model;
        $_where = [];
		isset($param['order_id']) && $_where[] = ['order_id', '=', $order_id];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['company_type']) && $_where[] = ['company_type', '=', $company_type];
		isset($param['industry_type']) && $_where[] = ['industry_type', '=', $industry_type];
		isset($param['meal_type']) && $_where[] = ['meal_type', '=', $meal_type];
		isset($param['address']) && $_where[] = ['address', '=', $address];
		isset($param['pay_taxes_type']) && $_where[] = ['pay_taxes_type', '=', $pay_taxes_type];
		isset($param['operating_time']) && $_where[] = ['operating_time', '=', $operating_time];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];

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
	 * @api_name 获取OrderDetails详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.OrderDetails.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m OrderDetail */
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
	 * @api_name 添加OrderDetails
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.OrderDetails.add
	 * 
	 * order_id				订单id
	 * type					类型
	 * company_type			企业类型
	 * industry_type		行业类别
	 * meal_type			套餐
	 * address				地区
	 * pay_taxes_type		纳税类型
	 * operating_time		经营时间
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m OrderDetail */
		$m = $this->_model;
		$param = $this->param;
		
		$order_id = isset($param['order_id']) ? $param['order_id'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$company_type = isset($param['company_type']) ? $param['company_type'] : '';
		$industry_type = isset($param['industry_type']) ? $param['industry_type'] : '';
		$meal_type = isset($param['meal_type']) ? $param['meal_type'] : '';
		$address = isset($param['address']) ? $param['address'] : '';
		$pay_taxes_type = isset($param['pay_taxes_type']) ? $param['pay_taxes_type'] : '';
		$operating_time = isset($param['operating_time']) ? $param['operating_time'] : 0;
		
		$_data = [];
		$_data['order_id'] = $order_id;
		$_data['type'] = $type;
		$_data['company_type'] = $company_type;
		$_data['industry_type'] = $industry_type;
		$_data['meal_type'] = $meal_type;
		$_data['address'] = $address;
		$_data['pay_taxes_type'] = $pay_taxes_type;
		$_data['operating_time'] = $operating_time;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * @api_name 更改OrderDetails
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.OrderDetails.edit
	 *
	 * id					
	 * order_id				订单id
	 * type					类型
	 * company_type			企业类型
	 * industry_type		行业类别
	 * meal_type			套餐
	 * address				地区
	 * pay_taxes_type		纳税类型
	 * operating_time		经营时间
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m OrderDetail */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$order_id = isset($param['order_id']) ? $param['order_id'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$company_type = isset($param['company_type']) ? $param['company_type'] : '';
		$industry_type = isset($param['industry_type']) ? $param['industry_type'] : '';
		$meal_type = isset($param['meal_type']) ? $param['meal_type'] : '';
		$address = isset($param['address']) ? $param['address'] : '';
		$pay_taxes_type = isset($param['pay_taxes_type']) ? $param['pay_taxes_type'] : '';
		$operating_time = isset($param['operating_time']) ? $param['operating_time'] : 0;
		
		$_data = [];
		isset($param['order_id']) && $_data['order_id'] = $order_id;
		isset($param['type']) && $_data['type'] = $type;
		isset($param['company_type']) && $_data['company_type'] = $company_type;
		isset($param['industry_type']) && $_data['industry_type'] = $industry_type;
		isset($param['meal_type']) && $_data['meal_type'] = $meal_type;
		isset($param['address']) && $_data['address'] = $address;
		isset($param['pay_taxes_type']) && $_data['pay_taxes_type'] = $pay_taxes_type;
		isset($param['operating_time']) && $_data['operating_time'] = $operating_time;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * @api_name 删除OrderDetails
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Yss.v1.OrderDetails.delete
     *
     * id
     * @return \think\response\Json
     * @throws \Throwable
     * @throws \think\Exception\DbException
     */
    public function delete() {
        return parent::delete();
    }



}
