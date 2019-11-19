<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Update\admin\controller\logic;

use app\sys\com\Update\common\model\Picture;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Pictures
 * 上传图片信息表
 * @api_name 上传图片
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 0
 * @package app\sys\com\Update\admin\controller\logic
 */
class Pictures extends ControllerCommon {
    protected $_route_url = '/sys/admin/Update.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Picture();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 上传图片信息表
	 * @api_name 获取上传图片列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Update.v1.Pictures.getList
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
		$thumb = isset($param['thumb']) ? $param['thumb'] : '';
		$picture = isset($param['picture']) ? $param['picture'] : '';
		$reduce = isset($param['reduce']) ? $param['reduce'] : '';

        /** @var $m Picture */
        $m = $this->_model;
        $_where = [];
		isset($param['name']) && $_where[] = ['name', '=', $name];
		isset($param['thumb']) && $_where[] = ['thumb', '=', $thumb];
		isset($param['picture']) && $_where[] = ['picture', '=', $picture];
		isset($param['reduce']) && $_where[] = ['reduce', '=', $reduce];

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
	 * 上传图片信息表
	 * @api_name 获取上传图片详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Update.v1.Pictures.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Picture */
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
	 * 上传图片信息表
	 * @api_name 添加上传图片
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Update.v1.Pictures.add
	 * 
	 * name				文件名称
	 * thumb			缩略图
	 * picture			原图
	 * reduce			质量缩小正方图
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Picture */
		$m = $this->_model;
		$param = $this->param;
		
		$name = isset($param['name']) ? $param['name'] : '';
		$thumb = isset($param['thumb']) ? $param['thumb'] : '';
		$picture = isset($param['picture']) ? $param['picture'] : '';
		$reduce = isset($param['reduce']) ? $param['reduce'] : '';
		
		$_data = [];
		$_data['name'] = $name;
		$_data['thumb'] = $thumb;
		$_data['picture'] = $picture;
		$_data['reduce'] = $reduce;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 上传图片信息表
	 * @api_name 更改上传图片
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Update.v1.Pictures.edit
	 *
	 * id				
	 * name				文件名称
	 * thumb			缩略图
	 * picture			原图
	 * reduce			质量缩小正方图
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Picture */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$name = isset($param['name']) ? $param['name'] : '';
		$thumb = isset($param['thumb']) ? $param['thumb'] : '';
		$picture = isset($param['picture']) ? $param['picture'] : '';
		$reduce = isset($param['reduce']) ? $param['reduce'] : '';
		
		$_data = [];
		isset($param['name']) && $_data['name'] = $name;
		isset($param['thumb']) && $_data['thumb'] = $thumb;
		isset($param['picture']) && $_data['picture'] = $picture;
		isset($param['reduce']) && $_data['reduce'] = $reduce;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 上传图片信息表
	 * @api_name 删除上传图片
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Update.v1.Pictures.delete
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
