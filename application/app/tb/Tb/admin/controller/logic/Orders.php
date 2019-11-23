<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\admin\controller\logic;

use app\app\tb\Tb\common\model\Order;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Orders
 * 订单
 * @api_name 订单
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\admin\controller\logic
 */
class Orders extends ControllerCommon {
    protected $_route_url = '/app/admin/Tb.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Order();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 订单
	 * @api_name 获取订单列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Tb.v1.Orders.getList
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

		$phone = isset($param['phone']) ? $param['phone'] : 0;
		$address = isset($param['address']) ? $param['address'] : '';
		$productid = isset($param['productid']) ? $param['productid'] : 0;
		$price = isset($param['price']) ? $param['price'] : 0;
		$pay_time = isset($param['pay_time']) ? $param['pay_time'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$ordersn = isset($param['ordersn']) ? $param['ordersn'] : '';
		$orderoutsn = isset($param['orderoutsn']) ? $param['orderoutsn'] : '';
		$number = isset($param['number']) ? $param['number'] : 0;
		$typeid = isset($param['typeid']) ? $param['typeid'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Order */
        $m = $this->_model;
        $_where = [];
		isset($param['phone']) && $_where[] = ['phone', '=', $phone];
		isset($param['address']) && $_where[] = ['address', '=', $address];
		isset($param['productid']) && $_where[] = ['productid', '=', $productid];
		isset($param['price']) && $_where[] = ['price', '=', $price];
		isset($param['pay_time']) && $_where[] = ['pay_time', '=', $pay_time];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['ordersn']) && $_where[] = ['ordersn', '=', $ordersn];
		isset($param['orderoutsn']) && $_where[] = ['orderoutsn', '=', $orderoutsn];
		isset($param['number']) && $_where[] = ['number', '=', $number];
		isset($param['typeid']) && $_where[] = ['typeid', '=', $typeid];
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
	 * 订单
	 * @api_name 获取订单详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Tb.v1.Orders.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Order */
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
	 * 订单
	 * @api_name 添加订单
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Tb.v1.Orders.add
	 * 
	 * phone			收件人手机号
	 * address			寄货地址
	 * productid		商品id
	 * price			价格
	 * pay_time			支付时间
	 * status			支付状态0未支付 1支付成功 2支付中 3待审核 4支付失败
	 * ordersn			订单编号
	 * orderoutsn		外部订单编号
	 * number			购买产品数量
	 * typeid			产品类型id
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Order */
		$m = $this->_model;
		$param = $this->param;
		$phone = isset($param['phone']) ? $param['phone'] : 0;
		$address = isset($param['address']) ? $param['address'] : '';
		$productid = isset($param['productid']) ? $param['productid'] : 0;
		$price = isset($param['price']) ? $param['price'] : 0;
		$pay_time = isset($param['pay_time']) ? $param['pay_time'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$ordersn = isset($param['ordersn']) ? $param['ordersn'] : '';
		$orderoutsn = isset($param['orderoutsn']) ? $param['orderoutsn'] : '';
		$number = isset($param['number']) ? $param['number'] : 0;
		$typeid = isset($param['typeid']) ? $param['typeid'] : 0;
		$goodattrid = isset($param['goodattrid']) ? $param['goodattrid'] : 0;

		$_data = [];
		$_data['phone'] = $phone;
		$_data['address'] = $address;
		$_data['productid'] = $productid;
		$_data['price'] = $price;
		$_data['pay_time'] = $pay_time;
		$_data['status'] = $status;
		$_data['ordersn'] = $ordersn;
		$_data['orderoutsn'] = $orderoutsn;
		$_data['number'] = $number;
		$_data['typeid'] = $typeid;
        $_data['goodattrid']=$goodattrid;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 订单
	 * @api_name 更改订单
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Tb.v1.Orders.edit
	 *
	 * id				
	 * phone			收件人手机号
	 * address			寄货地址
	 * productid		商品id
	 * price			价格
	 * pay_time			支付时间
	 * status			支付状态0未支付 1支付成功 2支付中 3待审核 4支付失败
	 * ordersn			订单编号
	 * orderoutsn		外部订单编号
	 * number			购买产品数量
	 * typeid			产品类型id
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Order */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$phone = isset($param['phone']) ? $param['phone'] : 0;
		$address = isset($param['address']) ? $param['address'] : '';
		$productid = isset($param['productid']) ? $param['productid'] : 0;
		$price = isset($param['price']) ? $param['price'] : 0;
		$pay_time = isset($param['pay_time']) ? $param['pay_time'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$ordersn = isset($param['ordersn']) ? $param['ordersn'] : '';
		$orderoutsn = isset($param['orderoutsn']) ? $param['orderoutsn'] : '';
		$number = isset($param['number']) ? $param['number'] : 0;
		$typeid = isset($param['typeid']) ? $param['typeid'] : 0;
		
		$_data = [];
		isset($param['phone']) && $_data['phone'] = $phone;
		isset($param['address']) && $_data['address'] = $address;
		isset($param['productid']) && $_data['productid'] = $productid;
		isset($param['price']) && $_data['price'] = $price;
		isset($param['pay_time']) && $_data['pay_time'] = $pay_time;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['ordersn']) && $_data['ordersn'] = $ordersn;
		isset($param['orderoutsn']) && $_data['orderoutsn'] = $orderoutsn;
		isset($param['number']) && $_data['number'] = $number;
		isset($param['typeid']) && $_data['typeid'] = $typeid;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 订单
	 * @api_name 删除订单
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Tb.v1.Orders.delete
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
	 * 订单
	 * @api_name 更改订单状态
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Tb.v1.Orders.setStatus
	 *
	 * id				
	 * status			支付状态0未支付 1支付成功 2支付中 3待审核 4支付失败 5退款
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Order */
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
