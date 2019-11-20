<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\api\controller\logic;

use app\app\tb\Attribute\common\model\Goodspecis;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Goodspeciss
 * 货物规格中间表
 * @api_name 货物规格
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Attribute\api\controller\logic
 */
class Goodspeciss extends ControllerCommon {
    protected $_route_url = '/app/api/Attribute.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Goodspecis();

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
	 * 货物规格中间表
	 * @api_name 获取货物规格列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Attribute.v1.Goodspeciss.getList
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
		$specsidl = isset($param['specsidl']) ? $param['specsidl'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$zprice = isset($param['zprice']) ? $param['zprice'] : 0;
		$img = isset($param['img']) ? $param['img'] : '';
		$pricetype = isset($param['pricetype']) ? $param['pricetype'] : 0;

        /** @var $m Goodspecis */
        $m = $this->_model;
        $_where = [];
		isset($param['goodsid']) && $_where[] = ['goodsid', '=', $goodsid];
		isset($param['specsidl']) && $_where[] = ['specsidl', '=', $specsidl];
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
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Attribute.v1.Goodspeciss.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Goodspecis */
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
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Attribute.v1.Goodspeciss.add
	 * 
	 * goodsid			商品id
	 * specsidl			规格id列表
	 * price			真实价格
	 * zprice			折扣价格
	 * img				图片地址
	 * pricetype		折扣还是不折扣(0为不折扣1为折扣)
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Goodspecis */
		$m = $this->_model;
		$param = $this->param;
		
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		$specsidl = isset($param['specsidl']) ? $param['specsidl'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$zprice = isset($param['zprice']) ? $param['zprice'] : 0;
		$img = isset($param['img']) ? $param['img'] : '';
		$pricetype = isset($param['pricetype']) ? $param['pricetype'] : 0;
		
		$_data = [];
		$_data['goodsid'] = $goodsid;
		$_data['specsidl'] = $specsidl;
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
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Attribute.v1.Goodspeciss.edit
	 *
	 * id				
	 * goodsid			商品id
	 * specsidl			规格id列表
	 * price			真实价格
	 * zprice			折扣价格
	 * img				图片地址
	 * pricetype		折扣还是不折扣(0为不折扣1为折扣)
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Goodspecis */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		$specsidl = isset($param['specsidl']) ? $param['specsidl'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$zprice = isset($param['zprice']) ? $param['zprice'] : 0;
		$img = isset($param['img']) ? $param['img'] : '';
		$pricetype = isset($param['pricetype']) ? $param['pricetype'] : 0;
		
		$_data = [];
		isset($param['goodsid']) && $_data['goodsid'] = $goodsid;
		isset($param['specsidl']) && $_data['specsidl'] = $specsidl;
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
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Attribute.v1.Goodspeciss.delete
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
