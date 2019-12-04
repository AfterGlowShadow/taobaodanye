<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\api\controller\logic;

use app\app\tb\Tb\common\model\Model;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Models
 * 宣传页模型
 * @api_name 宣传页模板
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\api\controller\logic
 */
class Models extends ControllerCommon {
    protected $_route_url = '/app/api/Tb.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Model();

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
	 * 宣传页模型
	 * @api_name 获取宣传页模板列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Models.getList
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
		$url = isset($param['url']) ? $param['url'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$field = isset($param['field']) ? $param['field'] : '';
		$config = isset($param['config']) ? $param['config'] : '';
		$function = isset($param['function']) ? $param['function'] : '';

        /** @var $m Model */
        $m = $this->_model;
        $_where = [];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['url']) && $_where[] = ['url', '=', $url];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['field']) && $_where[] = ['field', '=', $field];
		isset($param['config']) && $_where[] = ['config', '=', $config];
		isset($param['function']) && $_where[] = ['function', '=', $function];

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
	 * 宣传页模型
	 * @api_name 获取宣传页模板详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Models.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Model */
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
	 * 宣传页模型
	 * @api_name 添加宣传页模板
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Models.add
	 * 
	 * name				
	 * url				
	 * field			所用商品表字段
	 * config			配置信息
	 * function			请求方法
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Model */
		$m = $this->_model;
		$param = $this->param;
		
		$name = isset($param['name']) ? $param['name'] : '';
		$url = isset($param['url']) ? $param['url'] : '';
		$field = isset($param['field']) ? $param['field'] : '';
		$config = isset($param['config']) ? $param['config'] : '';
		$function = isset($param['function']) ? $param['function'] : '';
		
		$_data = [];
		$_data['name'] = $name;
		$_data['url'] = $url;
		$_data['field'] = $field;
		$_data['config'] = $config;
		$_data['function'] = $function;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 宣传页模型
	 * @api_name 更改宣传页模板
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Models.edit
	 *
	 * id				
	 * name				
	 * url				
	 * field			所用商品表字段
	 * config			配置信息
	 * function			请求方法
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Model */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$name = isset($param['name']) ? $param['name'] : '';
		$url = isset($param['url']) ? $param['url'] : '';
		$field = isset($param['field']) ? $param['field'] : '';
		$config = isset($param['config']) ? $param['config'] : '';
		$function = isset($param['function']) ? $param['function'] : '';
		
		$_data = [];
		isset($param['name']) && $_data['name'] = $name;
		isset($param['url']) && $_data['url'] = $url;
		isset($param['field']) && $_data['field'] = $field;
		isset($param['config']) && $_data['config'] = $config;
		isset($param['function']) && $_data['function'] = $function;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 宣传页模型
	 * @api_name 删除宣传页模板
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Models.delete
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
