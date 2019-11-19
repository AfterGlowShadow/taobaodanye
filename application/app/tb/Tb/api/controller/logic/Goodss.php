<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\api\controller\logic;

use app\app\tb\Tb\common\model\Goods;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Goodss
 * 商品
 * @api_name 商品
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\api\controller\logic
 */
class Goodss extends ControllerCommon {
    protected $_route_url = '/app/api/Tb.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Goods();

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
	 * 商品
	 * @api_name 获取商品列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Goodss.getList
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

		$goodsname = isset($param['goodsname']) ? $param['goodsname'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$title = isset($param['title']) ? $param['title'] : '';
		$description = isset($param['description']) ? $param['description'] : '';
		$content = isset($param['content']) ? $param['content'] : '';
		$modelid = isset($param['modelid']) ? $param['modelid'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$classify = isset($param['classify']) ? $param['classify'] : 0;

        /** @var $m Goods */
        $m = $this->_model;
        $_where = [];
		isset($param['goodsname']) && $_where[] = ['goodsname', '=', $goodsname];
		isset($param['price']) && $_where[] = ['price', '=', $price];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['description']) && $_where[] = ['description', '=', $description];
		isset($param['content']) && $_where[] = ['content', '=', $content];
		isset($param['modelid']) && $_where[] = ['modelid', '=', $modelid];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['classify']) && $_where[] = ['classify', '=', $classify];

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
	 * 商品
	 * @api_name 获取商品详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Goodss.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Goods */
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
	 * 商品
	 * @api_name 添加商品
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Goodss.add
	 * 
	 * goodsname		商品名称
	 * price			价格
	 * title			标题
	 * description		描述
	 * content			详情
	 * modelid			宣传模型id
	 * classify			商品分类id
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Goods */
		$m = $this->_model;
		$param = $this->param;
		
		$goodsname = isset($param['goodsname']) ? $param['goodsname'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$title = isset($param['title']) ? $param['title'] : '';
		$description = isset($param['description']) ? $param['description'] : '';
		$content = isset($param['content']) ? $param['content'] : '';
		$modelid = isset($param['modelid']) ? $param['modelid'] : '';
		$classify = isset($param['classify']) ? $param['classify'] : 0;
		
		$_data = [];
		$_data['goodsname'] = $goodsname;
		$_data['price'] = $price;
		$_data['title'] = $title;
		$_data['description'] = $description;
		$_data['content'] = $content;
		$_data['modelid'] = $modelid;
		$_data['classify'] = $classify;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 商品
	 * @api_name 更改商品
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Goodss.edit
	 *
	 * id				
	 * goodsname		商品名称
	 * price			价格
	 * title			标题
	 * description		描述
	 * content			详情
	 * modelid			宣传模型id
	 * classify			商品分类id
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Goods */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$goodsname = isset($param['goodsname']) ? $param['goodsname'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$title = isset($param['title']) ? $param['title'] : '';
		$description = isset($param['description']) ? $param['description'] : '';
		$content = isset($param['content']) ? $param['content'] : '';
		$modelid = isset($param['modelid']) ? $param['modelid'] : '';
		$classify = isset($param['classify']) ? $param['classify'] : 0;
		
		$_data = [];
		isset($param['goodsname']) && $_data['goodsname'] = $goodsname;
		isset($param['price']) && $_data['price'] = $price;
		isset($param['title']) && $_data['title'] = $title;
		isset($param['description']) && $_data['description'] = $description;
		isset($param['content']) && $_data['content'] = $content;
		isset($param['modelid']) && $_data['modelid'] = $modelid;
		isset($param['classify']) && $_data['classify'] = $classify;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 商品
	 * @api_name 删除商品
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Goodss.delete
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
