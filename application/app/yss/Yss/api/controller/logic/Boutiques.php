<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller\logic;

use app\app\yss\Yss\common\model\Boutique;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Boutiques
 * 精选服务表
 * @api_name 精选服务
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\api\controller\logic
 */
class Boutiques extends ControllerCommon {
    protected $_route_url = '/app/api/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Boutique();

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
	 * 精选服务表
	 * @api_name 获取精选服务列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Boutiques.getList
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
		$title_desc = isset($param['title_desc']) ? $param['title_desc'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$icon = isset($param['icon']) ? $param['icon'] : '';
		$is_hot = isset($param['is_hot']) ? $param['is_hot'] : 0;
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$url = isset($param['url']) ? $param['url'] : '';

        /** @var $m Boutique */
        $m = $this->_model;
        $_where = [];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['title_desc']) && $_where[] = ['title_desc', '=', $title_desc];
		isset($param['price']) && $_where[] = ['price', '=', $price];
		isset($param['icon']) && $_where[] = ['icon', '=', $icon];
		isset($param['is_hot']) && $_where[] = ['is_hot', '=', $is_hot];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['url']) && $_where[] = ['url', '=', $url];

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
	 * 精选服务表
	 * @api_name 获取精选服务详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Boutiques.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Boutique */
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
	 * 精选服务表
	 * @api_name 添加精选服务
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Boutiques.add
	 * 
	 * title			标题
	 * title_desc		描述
	 * price			价格
	 * icon				图标
	 * is_hot			是否热销
	 * url				链接
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Boutique */
		$m = $this->_model;
		$param = $this->param;
		
		$title = isset($param['title']) ? $param['title'] : '';
		$title_desc = isset($param['title_desc']) ? $param['title_desc'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$icon = isset($param['icon']) ? $param['icon'] : '';
		$is_hot = isset($param['is_hot']) ? $param['is_hot'] : 0;
		$url = isset($param['url']) ? $param['url'] : '';
		
		$_data = [];
		$_data['title'] = $title;
		$_data['title_desc'] = $title_desc;
		$_data['price'] = $price;
		$_data['icon'] = $icon;
		$_data['is_hot'] = $is_hot;
		$_data['url'] = $url;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 精选服务表
	 * @api_name 更改精选服务
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Boutiques.edit
	 *
	 * id				
	 * title			标题
	 * title_desc		描述
	 * price			价格
	 * icon				图标
	 * is_hot			是否热销
	 * url				链接
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Boutique */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$title = isset($param['title']) ? $param['title'] : '';
		$title_desc = isset($param['title_desc']) ? $param['title_desc'] : '';
		$price = isset($param['price']) ? $param['price'] : 0;
		$icon = isset($param['icon']) ? $param['icon'] : '';
		$is_hot = isset($param['is_hot']) ? $param['is_hot'] : 0;
		$url = isset($param['url']) ? $param['url'] : '';
		
		$_data = [];
		isset($param['title']) && $_data['title'] = $title;
		isset($param['title_desc']) && $_data['title_desc'] = $title_desc;
		isset($param['price']) && $_data['price'] = $price;
		isset($param['icon']) && $_data['icon'] = $icon;
		isset($param['is_hot']) && $_data['is_hot'] = $is_hot;
		isset($param['url']) && $_data['url'] = $url;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 精选服务表
	 * @api_name 删除精选服务
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Boutiques.delete
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
