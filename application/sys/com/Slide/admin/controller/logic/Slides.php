<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Slide\admin\controller\logic;

use app\sys\com\Slide\common\model\Slide;
use app\sys\com\base\common\v1\controller\admin\ControllerCommon;
use Exception;

/**
 * Class Slides
 * 轮播图表
 * @api_name 轮播图
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Slide\admin\controller\logic
 */
class Slides extends ControllerCommon {
    protected $_route_url = '/sys/admin/Slide.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function construct_after($app) {
        $this->_model = new Slide();
    }

    public function init_before() {

    }

    public function init_after() {

    }

    public function index() {

    }

    /**
     * 获取列表
	 * 轮播图表
	 * @api_name 获取轮播图列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Slide.v1.Slides.getList
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
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$img = isset($param['img']) ? $param['img'] : '';
		$url = isset($param['url']) ? $param['url'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$addon_name = isset($param['addon_name']) ? $param['addon_name'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;

        /** @var $m Slide */
        $m = $this->_model;
        $_where = [];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['intro']) && $_where[] = ['intro', '=', $intro];
		isset($param['img']) && $_where[] = ['img', '=', $img];
		isset($param['url']) && $_where[] = ['url', '=', $url];
		isset($param['type']) && $_where[] = ['type', '=', $type];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['remark']) && $_where[] = ['remark', '=', $remark];
		isset($param['addon_name']) && $_where[] = ['addon_name', '=', $addon_name];
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
	 * 轮播图表
	 * @api_name 获取轮播图详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Slide.v1.Slides.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Slide */
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
	 * 轮播图表
	 * @api_name 添加轮播图
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Slide.v1.Slides.add
	 * 
	 * title			标题
	 * intro			简介
	 * img				图片
	 * url				链接
	 * type				类型（0-未知 1-首页）
	 * status			状态（0-未知 1-启用 2-禁用）
	 * remark			备注
	 * addon_name		应用名称
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Slide */
		$m = $this->_model;
		$param = $this->param;
		
		$title = isset($param['title']) ? $param['title'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$img = isset($param['img']) ? $param['img'] : '';
		$url = isset($param['url']) ? $param['url'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$addon_name = isset($param['addon_name']) ? $param['addon_name'] : '';
		
		$_data = [];
		$_data['title'] = $title;
		$_data['intro'] = $intro;
		$_data['img'] = $img;
		$_data['url'] = $url;
		$_data['type'] = $type;
		$_data['status'] = $status;
		$_data['remark'] = $remark;
		$_data['addon_name'] = $addon_name;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 轮播图表
	 * @api_name 更改轮播图
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Slide.v1.Slides.edit
	 *
	 * id				
	 * title			标题
	 * intro			简介
	 * img				图片
	 * url				链接
	 * type				类型（0-未知 1-首页）
	 * status			状态（0-未知 1-启用 2-禁用）
	 * remark			备注
	 * addon_name		应用名称
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Slide */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$title = isset($param['title']) ? $param['title'] : '';
		$intro = isset($param['intro']) ? $param['intro'] : '';
		$img = isset($param['img']) ? $param['img'] : '';
		$url = isset($param['url']) ? $param['url'] : '';
		$type = isset($param['type']) ? $param['type'] : 0;
		$status = isset($param['status']) ? $param['status'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$addon_name = isset($param['addon_name']) ? $param['addon_name'] : '';
		
		$_data = [];
		isset($param['title']) && $_data['title'] = $title;
		isset($param['intro']) && $_data['intro'] = $intro;
		isset($param['img']) && $_data['img'] = $img;
		isset($param['url']) && $_data['url'] = $url;
		isset($param['type']) && $_data['type'] = $type;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['remark']) && $_data['remark'] = $remark;
		isset($param['addon_name']) && $_data['addon_name'] = $addon_name;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 轮播图表
	 * @api_name 删除轮播图
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Slide.v1.Slides.delete
     *
     * id
     * @return \think\response\Json
     * @throws \Throwable
     * @throws \think\Exception\DbException
     */
    public function delete() {
        return parent::delete();
    }

	
	/**
	 * 更改状态
	 * 轮播图表
	 * @api_name 更改轮播图状态
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Slide.v1.Slides.setStatus
	 *
	 * id				
	 * status			状态（0-未知 1-启用 2-禁用）
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Slide */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $this->p('id');
		$status = $this->p('status');
		
		$_d = [];
		$_d['status'] = $status;
		$re = $m->editById($id, $_d);
		return return_json($re);
	}

}
