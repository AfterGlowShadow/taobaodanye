<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\admin\controller\logic;

use app\app\tb\Attribute\common\model\Goodattr;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Goodattrs
 * 货物规格中间表
 * @api_name 货物规格
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Attribute\admin\controller\logic
 */
class Goodattrs extends ControllerCommon {
    protected $_route_url = '/app/admin/Attribute.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Goodattr();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 货物规格中间表
	 * @api_name 获取货物规格列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Attribute.v1.Goodattrs.getList
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

		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		$attribute = isset($param['attribute']) ? $param['attribute'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$zprice = isset($param['zprice']) ? $param['zprice'] : 0;
		$img = isset($param['img']) ? $param['img'] : '';
		$pricetype = isset($param['pricetype']) ? $param['pricetype'] : 0;

        /** @var $m Goodattr */
        $m = $this->_model;
        $_where = [];
		isset($param['goodsid']) && $_where[] = ['goodsid', '=', $goodsid];
		isset($param['attribute']) && $_where[] = ['attribute', '=', $attribute];
		isset($param['price']) && $_where[] = ['price', '=', $price];
		isset($param['zprice']) && $_where[] = ['zprice', '=', $zprice];
		isset($param['img']) && $_where[] = ['img', '=', $img];
		isset($param['pricetype']) && $_where[] = ['pricetype', '=', $pricetype];

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
	 * 货物规格中间表
	 * @api_name 获取货物规格详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Attribute.v1.Goodattrs.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Goodattr */
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
	 * 货物规格中间表
	 * @api_name 添加货物规格
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Attribute.v1.Goodattrs.add
	 * 
	 * goodsid			商品id
	 * attribute		规格id列表
	 * price			真实价格
	 * zprice			折扣价格
	 * img				图片地址
	 * pricetype		折扣还是不折扣(0为不折扣1为折扣)
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Goodattr */
		$m = $this->_model;
		$param = $this->param;
		
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		$attribute = isset($param['attribute']) ? $param['attribute'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$zprice = isset($param['zprice']) ? $param['zprice'] : 0;
		$img = isset($param['img']) ? $param['img'] : '';
		$pricetype = isset($param['pricetype']) ? $param['pricetype'] : 0;
		
		$_data = [];
		$_data['goodsid'] = $goodsid;
		$_data['attribute'] = $attribute;
		$_data['price'] = $price;
		$_data['zprice'] = $zprice;
		$_data['img'] = $img;
		$_data['pricetype'] = $pricetype;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 货物规格中间表
	 * @api_name 更改货物规格
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Attribute.v1.Goodattrs.edit
	 *
	 * id				
	 * goodsid			商品id
	 * attribute		规格id列表
	 * price			真实价格
	 * zprice			折扣价格
	 * img				图片地址
	 * pricetype		折扣还是不折扣(0为不折扣1为折扣)
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Goodattr */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		$attribute = isset($param['attribute']) ? $param['attribute'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$zprice = isset($param['zprice']) ? $param['zprice'] : 0;
		$img = isset($param['img']) ? $param['img'] : '';
		$pricetype = isset($param['pricetype']) ? $param['pricetype'] : 0;
		
		$_data = [];
		isset($param['goodsid']) && $_data['goodsid'] = $goodsid;
		isset($param['attribute']) && $_data['attribute'] = $attribute;
		isset($param['price']) && $_data['price'] = $price;
		isset($param['zprice']) && $_data['zprice'] = $zprice;
		isset($param['img']) && $_data['img'] = $img;
		isset($param['pricetype']) && $_data['pricetype'] = $pricetype;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 货物规格中间表
	 * @api_name 删除货物规格
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/admin/Attribute.v1.Goodattrs.delete
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
