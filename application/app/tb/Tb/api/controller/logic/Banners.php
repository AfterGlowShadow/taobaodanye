<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\api\controller\logic;

use app\app\tb\Tb\common\model\Banner;
use app\sys\com\base\common\v1\controller\api\ControllerCommon;
use Exception;

/**
 * Class Banners
 * 轮播图
 * @api_name 轮播图
 * @api_type 3
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\api\controller\logic
 */
class Banners extends ControllerCommon {
    protected $_route_url = '/app/api/Tb.v1.{{$col}}.{{$act}}';

    public function initialize() {
        $this->init_before();

        parent::initialize();

        $this->init_after();
    }

    public function init_before() {
        $this->_model = new Banner();

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
	 * 轮播图
	 * @api_name 获取轮播图列表
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Banners.getList
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

		$url = isset($param['url']) ? $param['url'] : '';
		$delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		$img = isset($param['img']) ? $param['img'] : '';
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$intro = isset($param['intro']) ? $param['intro'] : '';

        /** @var $m Banner */
        $m = $this->_model;
        $_where = [];
		isset($param['url']) && $_where[] = ['url', '=', $url];
		isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
		isset($param['goodsid']) && $_where[] = ['goodsid', '=', $goodsid];
		isset($param['img']) && $_where[] = ['img', '=', $img];
		isset($param['remark']) && $_where[] = ['remark', '=', $remark];
		isset($param['title']) && $_where[] = ['title', '=', $title];
		isset($param['status']) && $_where[] = ['status', '=', $status];
		isset($param['intro']) && $_where[] = ['intro', '=', $intro];

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
	 * 轮播图
	 * @api_name 获取轮播图详情
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Banners.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemById() {
        /** @var $m Banner */
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
	 * 轮播图
	 * @api_name 添加轮播图
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Banners.add
	 * 
	 * url				轮播图地址(外网)
	 * goodsid			商品id
	 * img				图片地址
	 * remark			备注
	 * title			标题
	 * status			状态（0-未知 1-启用 2-禁用）
	 * intro			简介
	 * @return mixed|string
	 */
	public function add() {
		/** @var $m Banner */
		$m = $this->_model;
		$param = $this->param;
		
		$url = isset($param['url']) ? $param['url'] : '';
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		$img = isset($param['img']) ? $param['img'] : '';
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$intro = isset($param['intro']) ? $param['intro'] : '';
		
		$_data = [];
		$_data['url'] = $url;
		$_data['goodsid'] = $goodsid;
		$_data['img'] = $img;
		$_data['remark'] = $remark;
		$_data['title'] = $title;
		$_data['status'] = $status;
		$_data['intro'] = $intro;
		$re = $m->add($_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return return_json($re);
	}

	
	/**
	 * 更改
	 * 轮播图
	 * @api_name 更改轮播图
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Banners.edit
	 *
	 * id				
	 * url				轮播图地址(外网)
	 * goodsid			商品id
	 * img				图片地址
	 * remark			备注
	 * title			标题
	 * status			状态（0-未知 1-启用 2-禁用）
	 * intro			简介
	 * @return mixed|string
	 */
	public function edit() {
		/** @var $m Banner */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $param['id'];
		$url = isset($param['url']) ? $param['url'] : '';
		$goodsid = isset($param['goodsid']) ? $param['goodsid'] : 0;
		$img = isset($param['img']) ? $param['img'] : '';
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$title = isset($param['title']) ? $param['title'] : '';
		$status = isset($param['status']) ? $param['status'] : 0;
		$intro = isset($param['intro']) ? $param['intro'] : '';
		
		$_data = [];
		isset($param['url']) && $_data['url'] = $url;
		isset($param['goodsid']) && $_data['goodsid'] = $goodsid;
		isset($param['img']) && $_data['img'] = $img;
		isset($param['remark']) && $_data['remark'] = $remark;
		isset($param['title']) && $_data['title'] = $title;
		isset($param['status']) && $_data['status'] = $status;
		isset($param['intro']) && $_data['intro'] = $intro;
		$re = $m->editById($id, $_data);
		if (!is_return_ok($re)) {
			return return_json($re);
		}
		return rjOk();
	}

    /**
     * 删除
	 * 轮播图
	 * @api_name 删除轮播图
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Banners.delete
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
	 * 轮播图
	 * @api_name 更改轮播图状态
	 * @api_type 3
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /app/api/Tb.v1.Banners.setStatus
	 *
	 * id				
	 * status			状态（0-未知 1-启用 2-禁用）
	 * @return mixed|string
	 */
	public function setStatus() {
		/** @var $m Banner */
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
