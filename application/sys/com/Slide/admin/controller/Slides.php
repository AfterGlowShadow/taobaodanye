<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Slide\admin\controller;

use app\sys\com\Slide\common\model\Slide;
use think\Db;

/**
 * Class Slides
 * 轮播图表
 * @api_name 轮播图
 * @api_type 2
 * @api_is_menu 1
 * @api_is_maker 1
 * @api_is_def_name 0
 * @package app\sys\com\Slide\admin\controller
 */
class Slides extends \app\sys\com\Slide\admin\controller\logic\Slides {

    public function init_before() {
        parent::init_before();


    }

	public function add() {
		!isset($this->param['type']) && $this->param['type'] = Slide::$_TYPE['homepage'];
		$this->param['status'] = Slide::$_STATUS['enabled'];
    	
		return parent::add();
	}
	
}
