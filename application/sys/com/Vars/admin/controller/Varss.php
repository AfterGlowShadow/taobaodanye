<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Vars\admin\controller;

use app\sys\com\Vars\common\model\Vars;
use think\Db;

/**
 * Class Varss
 * 系统变量表
 * @api_name Varss
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 0
 * @api_is_def_name 1
 * @package app\sys\com\Vars\admin\controller
 */
class Varss extends \app\sys\com\Vars\admin\controller\logic\Varss {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 获取变量值
	 * 系统变量表
	 * @api_name        获取变量值
	 * @api_type        2
	 * @api_is_menu     0
	 * @api_is_maker    1
	 * @api_is_show     0
	 * @api_is_def_name 1
	 * @api_url         /sys/admin/vars.v1.varss.getVar
	 *
	 * var
	 * @param $var
	 * @return void
	 */
	public function getVar() {
		/** @var $m Vars */
		$m = $this->_model;
		$param = $this->param;
		
		$var = $this->p('var');
		
		$re = $m->getItemByVar($var);
		
		return return_json($re);
	}
	
	/**
	 * 设置变量值
	 * 系统变量表
	 * @api_name        设置变量值
	 * @api_type        2
	 * @api_is_menu     0
	 * @api_is_maker    1
	 * @api_is_show     0
	 * @api_is_def_name 1
	 * @api_url         /sys/admin/vars.v1.varss.setVar
	 *
	 * var
	 * @param $var
	 * @return void
	 */
	public function setVar() {
		/** @var $m Vars */
		$m = $this->_model;
		$param = $this->param;
		
		$var = $this->p('var');
		
		$re = $m->setItemByVar($var, $param);
		
		return return_json($re);
	}

}
