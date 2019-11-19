<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\api\controller\logic;

use app\app\tb\Attribute\common\model\Goodsspecsid;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Goodsspecsids
 * @api_name Goodsspecsids
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\tb\Attribute\api\controller\logic
 */
class Goodsspecsids extends ControllerCommon {
    protected $_route_url = '/app/api/Attribute.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Goodsspecsid();

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
	 * @api_name 获取Goodsspecsids列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/api/Attribute.v1.Goodsspecsids.getList
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

		$goods = isset($param['goods']) ? $param['goods'] : 0;
		$specsid = isset($param['specsid']) ? $param['specsid'] : 0;

        /** @var $m Goodsspecsid */
        $m = $this->_model;
        $_where = [];
		isset($param['goods']) && $_where[] = ['goods', '=', $goods];
		isset($param['specsid']) && $_where[] = ['specsid', '=', $specsid];

		$_order = [];

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
	 * @api_name 获取Goodsspecsids详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/api/Attribute.v1.Goodsspecsids.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Goodsspecsid */
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
	 * @api_name 添加Goodsspecsids
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/api/Attribute.v1.Goodsspecsids.add
	 * 
	 * goods		商品id
	 * specsid		规格id
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Goodsspecsid */
		$m = $this->_model;
		$param = $this->param;
		
		$goods = isset($param['goods']) ? $param['goods'] : 0;
		$specsid = isset($param['specsid']) ? $param['specsid'] : 0;
		
		$_data = [];
		$_data['goods'] = $goods;
		$_data['specsid'] = $specsid;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * @api_name 更改Goodsspecsids
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/api/Attribute.v1.Goodsspecsids.edit
	 *
	 * id			
	 * goods		商品id
	 * specsid		规格id
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Goodsspecsid */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$goods = isset($param['goods']) ? $param['goods'] : 0;
		$specsid = isset($param['specsid']) ? $param['specsid'] : 0;
		
		$_data = [];
		isset($param['goods']) && $_data['goods'] = $goods;
		isset($param['specsid']) && $_data['specsid'] = $specsid;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * @api_name 删除Goodsspecsids
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/api/Attribute.v1.Goodsspecsids.delete
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
