<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\api\controller\logic;

use app\app\yss\Yss\common\model\Industry;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Industrys
 * 工商服务表
 * @api_name 工商服务
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\api\controller\logic
 */
class Industrys extends ControllerCommon {
    protected $_route_url = '/app/api/Yss.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Industry();

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
	 * 工商服务表
	 * @api_name 获取工商服务列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Industrys.getList
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

		$cat_id = isset($param['cat_id']) ? $param['cat_id'] : 0;
		$cat_second_id = isset($param['cat_second_id']) ? $param['cat_second_id'] : 0;
		$title = isset($param['title']) ? $param['title'] : '';
		$title_desc = isset($param['title_desc']) ? $param['title_desc'] : '';
		$shop_price = isset($param['shop_price']) ? $param['shop_price'] : 0;
		$price = isset($param['price']) ? $param['price'] : 0;
		$service_type = isset($param['service_type']) ? $param['service_type'] : 0;
		$service_name = isset($param['service_name']) ? $param['service_name'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$view_num = isset($param['view_num']) ? $param['view_num'] : 0;
		$collection_num = isset($param['collection_num']) ? $param['collection_num'] : 0;
		$address_id = isset($param['address_id']) ? $param['address_id'] : 0;
		$address = isset($param['address']) ? $param['address'] : '';
		$meal_name = isset($param['meal_name']) ? $param['meal_name'] : '';
		$meal_ids = isset($param['meal_ids']) ? $param['meal_ids'] : 0;
		$company_type = isset($param['company_type']) ? $param['company_type'] : 0;
		$company_name = isset($param['company_name']) ? $param['company_name'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$attribute_info = isset($param['attribute_info']) ? $param['attribute_info'] : '';

        /** @var $m Industry */
        $m = $this->_model;
        $_where = [];
		isset($param['cat_id']) && $_where[] = ['cat_id', '=', $cat_id];
		isset($param['cat_second_id']) && $_where[] = ['cat_second_id', '=', $cat_second_id];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['title_desc']) && $_where[] = ['title_desc', '=', $title_desc];
		isset($param['shop_price']) && $_where[] = ['shop_price', '=', $shop_price];
		isset($param['price']) && $_where[] = ['price', '=', $price];
		isset($param['service_type']) && $_where[] = ['service_type', '=', $service_type];
		isset($param['service_name']) && $_where[] = ['service_name', '=', $service_name];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['view_num']) && $_where[] = ['view_num', '=', $view_num];
		isset($param['collection_num']) && $_where[] = ['collection_num', '=', $collection_num];
		isset($param['address_id']) && $_where[] = ['address_id', '=', $address_id];
		isset($param['address']) && $_where[] = ['address', '=', $address];
		isset($param['meal_name']) && $_where[] = ['meal_name', '=', $meal_name];
		isset($param['meal_ids']) && $_where[] = ['meal_ids', '=', $meal_ids];
		isset($param['company_type']) && $_where[] = ['company_type', '=', $company_type];
		isset($param['company_name']) && $_where[] = ['company_name', '=', $company_name];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['attribute_info']) && $_where[] = ['attribute_info', '=', $attribute_info];

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
	 * 工商服务表
	 * @api_name 获取工商服务详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Industrys.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Industry */
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
	 * 工商服务表
	 * @api_name 添加工商服务
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Industrys.add
	 * 
	 * cat_id				所属分类id
	 * cat_second_id		二级id
	 * title				标题
	 * title_desc			标题描述
	 * shop_price			市场价
	 * price				价格
	 * service_type			服务行业
	 * service_name			服务行业名
	 * type					1工商服务 2财税服务
	 * view_num				浏览量
	 * collection_num		收藏量
	 * address_id			地区id
	 * address				地区
	 * meal_name			套餐名称
	 * meal_ids				服务套餐
	 * company_type			企业类型
	 * company_name			企业类型名
	 * attribute_info		属性加价
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Industry */
		$m = $this->_model;
		$param = $this->param;
		
		$cat_id = isset($param['cat_id']) ? $param['cat_id'] : 0;
		$cat_second_id = isset($param['cat_second_id']) ? $param['cat_second_id'] : 0;
		$title = isset($param['title']) ? $param['title'] : '';
		$title_desc = isset($param['title_desc']) ? $param['title_desc'] : '';
		$shop_price = isset($param['shop_price']) ? $param['shop_price'] : 0;
		$price = isset($param['price']) ? $param['price'] : 0;
		$service_type = isset($param['service_type']) ? $param['service_type'] : 0;
		$service_name = isset($param['service_name']) ? $param['service_name'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$view_num = isset($param['view_num']) ? $param['view_num'] : 0;
		$collection_num = isset($param['collection_num']) ? $param['collection_num'] : 0;
		$address_id = isset($param['address_id']) ? $param['address_id'] : 0;
		$address = isset($param['address']) ? $param['address'] : '';
		$meal_name = isset($param['meal_name']) ? $param['meal_name'] : '';
		$meal_ids = isset($param['meal_ids']) ? $param['meal_ids'] : 0;
		$company_type = isset($param['company_type']) ? $param['company_type'] : 0;
		$company_name = isset($param['company_name']) ? $param['company_name'] : '';
		$attribute_info = isset($param['attribute_info']) ? $param['attribute_info'] : '';
		
		$_data = [];
		$_data['cat_id'] = $cat_id;
		$_data['cat_second_id'] = $cat_second_id;
		$_data['title'] = $title;
		$_data['title_desc'] = $title_desc;
		$_data['shop_price'] = $shop_price;
		$_data['price'] = $price;
		$_data['service_type'] = $service_type;
		$_data['service_name'] = $service_name;
		$_data['type'] = $type;
		$_data['view_num'] = $view_num;
		$_data['collection_num'] = $collection_num;
		$_data['address_id'] = $address_id;
		$_data['address'] = $address;
		$_data['meal_name'] = $meal_name;
		$_data['meal_ids'] = $meal_ids;
		$_data['company_type'] = $company_type;
		$_data['company_name'] = $company_name;
		$_data['attribute_info'] = $attribute_info;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 工商服务表
	 * @api_name 更改工商服务
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Industrys.edit
	 *
	 * id					
	 * cat_id				所属分类id
	 * cat_second_id		二级id
	 * title				标题
	 * title_desc			标题描述
	 * shop_price			市场价
	 * price				价格
	 * service_type			服务行业
	 * service_name			服务行业名
	 * type					1工商服务 2财税服务
	 * view_num				浏览量
	 * collection_num		收藏量
	 * address_id			地区id
	 * address				地区
	 * meal_name			套餐名称
	 * meal_ids				服务套餐
	 * company_type			企业类型
	 * company_name			企业类型名
	 * attribute_info		属性加价
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Industry */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$cat_id = isset($param['cat_id']) ? $param['cat_id'] : 0;
		$cat_second_id = isset($param['cat_second_id']) ? $param['cat_second_id'] : 0;
		$title = isset($param['title']) ? $param['title'] : '';
		$title_desc = isset($param['title_desc']) ? $param['title_desc'] : '';
		$shop_price = isset($param['shop_price']) ? $param['shop_price'] : 0;
		$price = isset($param['price']) ? $param['price'] : 0;
		$service_type = isset($param['service_type']) ? $param['service_type'] : 0;
		$service_name = isset($param['service_name']) ? $param['service_name'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$view_num = isset($param['view_num']) ? $param['view_num'] : 0;
		$collection_num = isset($param['collection_num']) ? $param['collection_num'] : 0;
		$address_id = isset($param['address_id']) ? $param['address_id'] : 0;
		$address = isset($param['address']) ? $param['address'] : '';
		$meal_name = isset($param['meal_name']) ? $param['meal_name'] : '';
		$meal_ids = isset($param['meal_ids']) ? $param['meal_ids'] : 0;
		$company_type = isset($param['company_type']) ? $param['company_type'] : 0;
		$company_name = isset($param['company_name']) ? $param['company_name'] : '';
		$attribute_info = isset($param['attribute_info']) ? $param['attribute_info'] : '';
		
		$_data = [];
		isset($param['cat_id']) && $_data['cat_id'] = $cat_id;
		isset($param['cat_second_id']) && $_data['cat_second_id'] = $cat_second_id;
		isset($param['title']) && $_data['title'] = $title;
		isset($param['title_desc']) && $_data['title_desc'] = $title_desc;
		isset($param['shop_price']) && $_data['shop_price'] = $shop_price;
		isset($param['price']) && $_data['price'] = $price;
		isset($param['service_type']) && $_data['service_type'] = $service_type;
		isset($param['service_name']) && $_data['service_name'] = $service_name;
		isset($param['type']) && $_data['type'] = $type;
		isset($param['view_num']) && $_data['view_num'] = $view_num;
		isset($param['collection_num']) && $_data['collection_num'] = $collection_num;
		isset($param['address_id']) && $_data['address_id'] = $address_id;
		isset($param['address']) && $_data['address'] = $address;
		isset($param['meal_name']) && $_data['meal_name'] = $meal_name;
		isset($param['meal_ids']) && $_data['meal_ids'] = $meal_ids;
		isset($param['company_type']) && $_data['company_type'] = $company_type;
		isset($param['company_name']) && $_data['company_name'] = $company_name;
		isset($param['attribute_info']) && $_data['attribute_info'] = $attribute_info;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 工商服务表
	 * @api_name 删除工商服务
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Yss.v1.Industrys.delete
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
