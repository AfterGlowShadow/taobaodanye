<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\admin\controller\logic;

use app\app\tb\Attribute\common\model\Classgood;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Classgoods
 * @api_name Classgoods
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\app\tb\Attribute\admin\controller\logic
 */
class Classgoods extends ControllerCommon {
    protected $_route_url = '/app/admin/Attribute.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Classgood();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * @api_name 获取Classgoods列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Attribute.v1.Classgoods.getList
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

		$classify = isset($param['classify']) ? $param['classify'] : 0;
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Classgood */
        $m = $this->_model;
        $_where = [];
		isset($param['classify']) && $_where[] = ['classify', '=', $classify];
		isset($param['goodsid']) && $_where[] = ['goodsid', '=', $goodsid];
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
	 * @api_name 获取Classgoods详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Attribute.v1.Classgoods.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Classgood */
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
	 * @api_name 添加Classgoods
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Attribute.v1.Classgoods.add
	 * 
	 * classify			分类id
	 * goodsid			商品id
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Classgood */
		$m = $this->_model;
		$param = $this->param;
		
		$classify = isset($param['classify']) ? $param['classify'] : 0;
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		
		$_data = [];
		$_data['classify'] = $classify;
		$_data['goodsid'] = $goodsid;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * @api_name 更改Classgoods
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Attribute.v1.Classgoods.edit
	 *
	 * id				
	 * classify			分类id
	 * goodsid			商品id
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Classgood */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$classify = isset($param['classify']) ? $param['classify'] : 0;
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		
		$_data = [];
		isset($param['classify']) && $_data['classify'] = $classify;
		isset($param['goodsid']) && $_data['goodsid'] = $goodsid;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * @api_name 删除Classgoods
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 1
	 * @api_url /app/admin/Attribute.v1.Classgoods.delete
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
