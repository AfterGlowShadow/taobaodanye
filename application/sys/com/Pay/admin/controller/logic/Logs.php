<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Pay\admin\controller\logic;

use app\sys\com\Pay\common\model\Log;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Logs
 * 支付表
 * @api_name 支付记录
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Pay\admin\controller\logic
 */
class Logs extends ControllerCommon {
    protected $_route_url = '/sys/admin/Pay.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Log();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 支付表
	 * @api_name 获取支付记录列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Pay.v1.Logs.getList
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

		$title = isset($param['title']) ? $param['title'] : '';
		$order_number = isset($param['order_number']) ? $param['order_number'] : '';
		$out_trade_no = isset($param['out_trade_no']) ? $param['out_trade_no'] : '';
		$realname = isset($param['realname']) ? $param['realname'] : '';
		$identity_number = isset($param['identity_number']) ? $param['identity_number'] : '';
		$money = isset($param['money']) ? $param['money'] : 0;
		$openid = isset($param['openid']) ? $param['openid'] : '';
		$pay_type = isset($param['pay_type']) ? $param['pay_type'] : 0;
		$reason = isset($param['reason']) ? $param['reason'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$tag = isset($param['tag']) ? $param['tag'] : '';
		$attach = isset($param['attach']) ? $param['attach'] : '';
		$notify_info = isset($param['notify_info']) ? $param['notify_info'] : '';
		$pay_time = isset($param['pay_time']) ? $param['pay_time'] : 0;
		$refund_time = isset($param['refund_time']) ? $param['refund_time'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Log */
        $m = $this->_model;
        $_where = [];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['order_number']) && $_where[] = ['order_number', '=', $order_number];
		isset($param['out_trade_no']) && $_where[] = ['out_trade_no', '=', $out_trade_no];
		isset($param['realname']) && $_where[] = ['realname', '=', $realname];
		isset($param['identity_number']) && $_where[] = ['identity_number', '=', $identity_number];
		isset($param['money']) && $_where[] = ['money', '=', $money];
		isset($param['openid']) && $_where[] = ['openid', '=', $openid];
		isset($param['pay_type']) && $_where[] = ['pay_type', '=', $pay_type];
		isset($param['reason']) && $_where[] = ['reason', '=', $reason];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['remark']) && $_where[] = ['remark', '=', $remark];
		isset($param['tag']) && $_where[] = ['tag', '=', $tag];
		isset($param['attach']) && $_where[] = ['attach', '=', $attach];
		isset($param['notify_info']) && $_where[] = ['notify_info', '=', $notify_info];
		isset($param['pay_time']) && $_where[] = ['pay_time', '=', $pay_time];
		isset($param['refund_time']) && $_where[] = ['refund_time', '=', $refund_time];
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
	 * 支付表
	 * @api_name 获取支付记录详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Pay.v1.Logs.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Log */
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
	 * 支付表
	 * @api_name 添加支付记录
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Pay.v1.Logs.add
	 * 
	 * title				标题（body subject）
	 * order_number			订单号
	 * out_trade_no			外部订单号
	 * realname				姓名
	 * identity_number		身份证号
	 * money				金额（total_amount total_fee）
	 * openid				微信openid 支付宝用不到
	 * pay_type				支付类型（0-未知 1-支付宝 2-微信 3-银行卡）
	 * reason				退款原因
	 * status				状态（0-未知 1-支付中 2-支付完成 3-支付失败 4-支付取消 5-退款中 6-退款完成 7-退款失败 8-退款取消）
	 * remark				备注
	 * tag					应用标记（区分不同支付）
	 * attach				附加数据json
	 * notify_info			回调返回内容信息
	 * pay_time				回调支付成功时间
	 * refund_time			退款成功时间
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Log */
		$m = $this->_model;
		$param = $this->param;
		
		$title = isset($param['title']) ? $param['title'] : '';
		$order_number = isset($param['order_number']) ? $param['order_number'] : '';
		$out_trade_no = isset($param['out_trade_no']) ? $param['out_trade_no'] : '';
		$realname = isset($param['realname']) ? $param['realname'] : '';
		$identity_number = isset($param['identity_number']) ? $param['identity_number'] : '';
		$money = isset($param['money']) ? $param['money'] : 0;
		$openid = isset($param['openid']) ? $param['openid'] : '';
		$pay_type = isset($param['pay_type']) ? $param['pay_type'] : 0;
		$reason = isset($param['reason']) ? $param['reason'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$tag = isset($param['tag']) ? $param['tag'] : '';
		$attach = isset($param['attach']) ? $param['attach'] : '';
		$notify_info = isset($param['notify_info']) ? $param['notify_info'] : '';
		$pay_time = isset($param['pay_time']) ? $param['pay_time'] : 0;
		$refund_time = isset($param['refund_time']) ? $param['refund_time'] : 0;
		
		$_data = [];
		$_data['title'] = $title;
		$_data['order_number'] = $order_number;
		$_data['out_trade_no'] = $out_trade_no;
		$_data['realname'] = $realname;
		$_data['identity_number'] = $identity_number;
		$_data['money'] = $money;
		$_data['openid'] = $openid;
		$_data['pay_type'] = $pay_type;
		$_data['reason'] = $reason;
		$_data['status'] = $status;
		$_data['remark'] = $remark;
		$_data['tag'] = $tag;
		$_data['attach'] = $attach;
		$_data['notify_info'] = $notify_info;
		$_data['pay_time'] = $pay_time;
		$_data['refund_time'] = $refund_time;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 支付表
	 * @api_name 更改支付记录
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Pay.v1.Logs.edit
	 *
	 * id					
	 * title				标题（body subject）
	 * order_number			订单号
	 * out_trade_no			外部订单号
	 * realname				姓名
	 * identity_number		身份证号
	 * money				金额（total_amount total_fee）
	 * openid				微信openid 支付宝用不到
	 * pay_type				支付类型（0-未知 1-支付宝 2-微信 3-银行卡）
	 * reason				退款原因
	 * status				状态（0-未知 1-支付中 2-支付完成 3-支付失败 4-支付取消 5-退款中 6-退款完成 7-退款失败 8-退款取消）
	 * remark				备注
	 * tag					应用标记（区分不同支付）
	 * attach				附加数据json
	 * notify_info			回调返回内容信息
	 * pay_time				回调支付成功时间
	 * refund_time			退款成功时间
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Log */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$title = isset($param['title']) ? $param['title'] : '';
		$order_number = isset($param['order_number']) ? $param['order_number'] : '';
		$out_trade_no = isset($param['out_trade_no']) ? $param['out_trade_no'] : '';
		$realname = isset($param['realname']) ? $param['realname'] : '';
		$identity_number = isset($param['identity_number']) ? $param['identity_number'] : '';
		$money = isset($param['money']) ? $param['money'] : 0;
		$openid = isset($param['openid']) ? $param['openid'] : '';
		$pay_type = isset($param['pay_type']) ? $param['pay_type'] : 0;
		$reason = isset($param['reason']) ? $param['reason'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$tag = isset($param['tag']) ? $param['tag'] : '';
		$attach = isset($param['attach']) ? $param['attach'] : '';
		$notify_info = isset($param['notify_info']) ? $param['notify_info'] : '';
		$pay_time = isset($param['pay_time']) ? $param['pay_time'] : 0;
		$refund_time = isset($param['refund_time']) ? $param['refund_time'] : 0;
		
		$_data = [];
		isset($param['title']) && $_data['title'] = $title;
		isset($param['order_number']) && $_data['order_number'] = $order_number;
		isset($param['out_trade_no']) && $_data['out_trade_no'] = $out_trade_no;
		isset($param['realname']) && $_data['realname'] = $realname;
		isset($param['identity_number']) && $_data['identity_number'] = $identity_number;
		isset($param['money']) && $_data['money'] = $money;
		isset($param['openid']) && $_data['openid'] = $openid;
		isset($param['pay_type']) && $_data['pay_type'] = $pay_type;
		isset($param['reason']) && $_data['reason'] = $reason;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['remark']) && $_data['remark'] = $remark;
		isset($param['tag']) && $_data['tag'] = $tag;
		isset($param['attach']) && $_data['attach'] = $attach;
		isset($param['notify_info']) && $_data['notify_info'] = $notify_info;
		isset($param['pay_time']) && $_data['pay_time'] = $pay_time;
		isset($param['refund_time']) && $_data['refund_time'] = $refund_time;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 支付表
	 * @api_name 删除支付记录
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Pay.v1.Logs.delete
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
