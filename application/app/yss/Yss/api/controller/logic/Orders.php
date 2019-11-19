<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller\logic;

use app\app\yss\Yss\common\model\Order;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Orders
 * 企业转让订单表
 * @api_name 企业转让订单
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\api\controller\logic
 */
class Orders extends ControllerCommon {
    protected $_route_url = '/app/api/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Order();

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
	 * 企业转让订单表
	 * @api_name 获取企业转让订单列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Orders.getList
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
		$realname = isset($param['realname']) ? $param['realname'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$product_number = isset($param['product_number']) ? $param['product_number'] : '';
		$order_number = isset($param['order_number']) ? $param['order_number'] : '';
		$company_sn = isset($param['company_sn']) ? $param['company_sn'] : '';
		$explor_id = isset($param['explor_id']) ? $param['explor_id'] : 0;
		$explor_name = isset($param['explor_name']) ? $param['explor_name'] : '';
		$explor_phone = isset($param['explor_phone']) ? $param['explor_phone'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$customer_id = isset($param['customer_id']) ? $param['customer_id'] : 0;
		$customer_name = isset($param['customer_name']) ? $param['customer_name'] : '';
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$real_price = isset($param['real_price']) ? $param['real_price'] : 0;
		$pay_price = isset($param['pay_price']) ? $param['pay_price'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$pay_time = isset($param['pay_time']) ? $param['pay_time'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Order */
        $m = $this->_model;
        $_where = [];
		isset($param['uid']) && $_where[] = ['uid', '=', $uid];
		isset($param['realname']) && $_where[] = ['realname', '=', $realname];
		isset($param['mobile']) && $_where[] = ['mobile', '=', $mobile];
		isset($param['product_number']) && $_where[] = ['product_number', '=', $product_number];
		isset($param['order_number']) && $_where[] = ['order_number', '=', $order_number];
		isset($param['company_sn']) && $_where[] = ['company_sn', '=', $company_sn];
		isset($param['explor_id']) && $_where[] = ['explor_id', '=', $explor_id];
		isset($param['explor_name']) && $_where[] = ['explor_name', '=', $explor_name];
		isset($param['explor_phone']) && $_where[] = ['explor_phone', '=', $explor_phone];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['price']) && $_where[] = ['price', '=', $price];
		isset($param['customer_id']) && $_where[] = ['customer_id', '=', $customer_id];
		isset($param['customer_name']) && $_where[] = ['customer_name', '=', $customer_name];
		isset($param['remark']) && $_where[] = ['remark', '=', $remark];
		isset($param['real_price']) && $_where[] = ['real_price', '=', $real_price];
		isset($param['pay_price']) && $_where[] = ['pay_price', '=', $pay_price];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['pay_time']) && $_where[] = ['pay_time', '=', $pay_time];
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
	 * 企业转让订单表
	 * @api_name 获取企业转让订单详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Orders.getItemById
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
	 * 企业转让订单表
	 * @api_name 添加企业转让订单
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Orders.add
	 * 
	 * uid					购买人id
	 * realname				购买人姓名
	 * mobile				购买人手机号手机号
	 * product_number		数量
	 * order_number			订单号
	 * company_sn			企业编号
	 * explor_id			出售企业人id
	 * explor_name			出售人姓名
	 * explor_phone			出售人手机号
	 * title				标题
	 * price				价格
	 * customer_id			客服id
	 * customer_name		客服名
	 * remark				备注
	 * real_price			真实价格（确认后的价格）
	 * pay_price			支付价格
	 * status				状态（0-未知 1-未付款 2-交接中 3-已完成）
	 * type					类型 1企业注册 2工商变更 3财税服务 4购买企业
	 * pay_time				支付时间
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Order */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$realname = isset($param['realname']) ? $param['realname'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$product_number = isset($param['product_number']) ? $param['product_number'] : '';
		$order_number = isset($param['order_number']) ? $param['order_number'] : '';
		$company_sn = isset($param['company_sn']) ? $param['company_sn'] : '';
		$explor_id = isset($param['explor_id']) ? $param['explor_id'] : 0;
		$explor_name = isset($param['explor_name']) ? $param['explor_name'] : '';
		$explor_phone = isset($param['explor_phone']) ? $param['explor_phone'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$customer_id = isset($param['customer_id']) ? $param['customer_id'] : 0;
		$customer_name = isset($param['customer_name']) ? $param['customer_name'] : '';
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$real_price = isset($param['real_price']) ? $param['real_price'] : 0;
		$pay_price = isset($param['pay_price']) ? $param['pay_price'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$pay_time = isset($param['pay_time']) ? $param['pay_time'] : 0;
		
		$_data = [];
		$_data['uid'] = $uid;
		$_data['realname'] = $realname;
		$_data['mobile'] = $mobile;
		$_data['product_number'] = $product_number;
		$_data['order_number'] = $order_number;
		$_data['company_sn'] = $company_sn;
		$_data['explor_id'] = $explor_id;
		$_data['explor_name'] = $explor_name;
		$_data['explor_phone'] = $explor_phone;
		$_data['title'] = $title;
		$_data['price'] = $price;
		$_data['customer_id'] = $customer_id;
		$_data['customer_name'] = $customer_name;
		$_data['remark'] = $remark;
		$_data['real_price'] = $real_price;
		$_data['pay_price'] = $pay_price;
		$_data['status'] = $status;
		$_data['type'] = $type;
		$_data['pay_time'] = $pay_time;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 企业转让订单表
	 * @api_name 更改企业转让订单
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Orders.edit
	 *
	 * id					
	 * uid					购买人id
	 * realname				购买人姓名
	 * mobile				购买人手机号手机号
	 * product_number		数量
	 * order_number			订单号
	 * company_sn			企业编号
	 * explor_id			出售企业人id
	 * explor_name			出售人姓名
	 * explor_phone			出售人手机号
	 * title				标题
	 * price				价格
	 * customer_id			客服id
	 * customer_name		客服名
	 * remark				备注
	 * real_price			真实价格（确认后的价格）
	 * pay_price			支付价格
	 * status				状态（0-未知 1-未付款 2-交接中 3-已完成）
	 * type					类型 1企业注册 2工商变更 3财税服务 4购买企业
	 * pay_time				支付时间
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Order */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$uid = isset($param['uid']) ? $param['uid'] : 0;
		$realname = isset($param['realname']) ? $param['realname'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$product_number = isset($param['product_number']) ? $param['product_number'] : '';
		$order_number = isset($param['order_number']) ? $param['order_number'] : '';
		$company_sn = isset($param['company_sn']) ? $param['company_sn'] : '';
		$explor_id = isset($param['explor_id']) ? $param['explor_id'] : 0;
		$explor_name = isset($param['explor_name']) ? $param['explor_name'] : '';
		$explor_phone = isset($param['explor_phone']) ? $param['explor_phone'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$customer_id = isset($param['customer_id']) ? $param['customer_id'] : 0;
		$customer_name = isset($param['customer_name']) ? $param['customer_name'] : '';
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$real_price = isset($param['real_price']) ? $param['real_price'] : 0;
		$pay_price = isset($param['pay_price']) ? $param['pay_price'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$type = isset($param['type']) ? $param['type'] : 0;
		$pay_time = isset($param['pay_time']) ? $param['pay_time'] : 0;
		
		$_data = [];
		isset($param['uid']) && $_data['uid'] = $uid;
		isset($param['realname']) && $_data['realname'] = $realname;
		isset($param['mobile']) && $_data['mobile'] = $mobile;
		isset($param['product_number']) && $_data['product_number'] = $product_number;
		isset($param['order_number']) && $_data['order_number'] = $order_number;
		isset($param['company_sn']) && $_data['company_sn'] = $company_sn;
		isset($param['explor_id']) && $_data['explor_id'] = $explor_id;
		isset($param['explor_name']) && $_data['explor_name'] = $explor_name;
		isset($param['explor_phone']) && $_data['explor_phone'] = $explor_phone;
		isset($param['title']) && $_data['title'] = $title;
		isset($param['price']) && $_data['price'] = $price;
		isset($param['customer_id']) && $_data['customer_id'] = $customer_id;
		isset($param['customer_name']) && $_data['customer_name'] = $customer_name;
		isset($param['remark']) && $_data['remark'] = $remark;
		isset($param['real_price']) && $_data['real_price'] = $real_price;
		isset($param['pay_price']) && $_data['pay_price'] = $pay_price;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['type']) && $_data['type'] = $type;
		isset($param['pay_time']) && $_data['pay_time'] = $pay_time;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 企业转让订单表
	 * @api_name 删除企业转让订单
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Orders.delete
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
	 * 企业转让订单表
	 * @api_name 更改企业转让订单状态
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Orders.setStatus
	 *
	 * id					
	 * status				状态（0-未知 1-未付款 2-交接中 3-已完成）
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
