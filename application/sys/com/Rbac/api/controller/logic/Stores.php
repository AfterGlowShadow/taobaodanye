<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\api\controller\logic;

use app\sys\com\Rbac\common\model\Store;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Stores
 * 店面表
 * @api_name 店面
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Rbac\api\controller\logic
 */
class Stores extends ControllerCommon {
    protected $_route_url = '/sys/api/Rbac.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Store();

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
	 * 店面表
	 * @api_name 获取店面列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Stores.getList
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

		$name = isset($param['name']) ? $param['name'] : '';
		$province = isset($param['province']) ? $param['province'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$area = isset($param['area']) ? $param['area'] : '';
		$address = isset($param['address']) ? $param['address'] : '';
		$storekeeper_name = isset($param['storekeeper_name']) ? $param['storekeeper_name'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Store */
        $m = $this->_model;
        $_where = [];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['province']) && $_where[] = ['province', '=', $province];
		isset($param['city']) && $_where[] = ['city', '=', $city];
		isset($param['area']) && $_where[] = ['area', '=', $area];
		isset($param['address']) && $_where[] = ['address', '=', $address];
		isset($param['storekeeper_name']) && $_where[] = ['storekeeper_name', '=', $storekeeper_name];
		isset($param['mobile']) && $_where[] = ['mobile', '=', $mobile];
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
	 * 店面表
	 * @api_name 获取店面详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Stores.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Store */
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
	 * 店面表
	 * @api_name 添加店面
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Stores.add
	 * 
	 * name					店面名称
	 * province				省
	 * city					市
	 * area					区
	 * address				详细地址
	 * storekeeper_name		店主
	 * mobile				电话
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Store */
		$m = $this->_model;
		$param = $this->param;
		
		$name = isset($param['name']) ? $param['name'] : '';
		$province = isset($param['province']) ? $param['province'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$area = isset($param['area']) ? $param['area'] : '';
		$address = isset($param['address']) ? $param['address'] : '';
		$storekeeper_name = isset($param['storekeeper_name']) ? $param['storekeeper_name'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		
		$_data = [];
		$_data['name'] = $name;
		$_data['province'] = $province;
		$_data['city'] = $city;
		$_data['area'] = $area;
		$_data['address'] = $address;
		$_data['storekeeper_name'] = $storekeeper_name;
		$_data['mobile'] = $mobile;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 店面表
	 * @api_name 更改店面
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Stores.edit
	 *
	 * id					
	 * name					店面名称
	 * province				省
	 * city					市
	 * area					区
	 * address				详细地址
	 * storekeeper_name		店主
	 * mobile				电话
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Store */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$name = isset($param['name']) ? $param['name'] : '';
		$province = isset($param['province']) ? $param['province'] : '';
		$city = isset($param['city']) ? $param['city'] : '';
		$area = isset($param['area']) ? $param['area'] : '';
		$address = isset($param['address']) ? $param['address'] : '';
		$storekeeper_name = isset($param['storekeeper_name']) ? $param['storekeeper_name'] : '';
		$mobile = isset($param['mobile']) ? $param['mobile'] : '';
		
		$_data = [];
		isset($param['name']) && $_data['name'] = $name;
		isset($param['province']) && $_data['province'] = $province;
		isset($param['city']) && $_data['city'] = $city;
		isset($param['area']) && $_data['area'] = $area;
		isset($param['address']) && $_data['address'] = $address;
		isset($param['storekeeper_name']) && $_data['storekeeper_name'] = $storekeeper_name;
		isset($param['mobile']) && $_data['mobile'] = $mobile;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 店面表
	 * @api_name 删除店面
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/api/Rbac.v1.Stores.delete
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
