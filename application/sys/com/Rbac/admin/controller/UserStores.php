<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\admin\controller;

use app\sys\com\Rbac\common\model\UserStore;
use think\Db;

/**
 * Class UserStores
 * 管理员店面关联表
 * @api_name 管理员店面关联
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Rbac\admin\controller
 */
class UserStores extends \app\sys\com\Rbac\admin\controller\logic\UserStores {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 获取管理员关联的店面ID列表
	 * 管理员店面关联表
	 * @api_name 获取管理员店面关联列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userstores.getStoreIDsList
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function getStoreIDsList() {
		/** @var $m UserStore */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['aid'];
		
		$re = $m->getStoreIDsList($uid);
		return return_json($re);
	}
	
	/**
	 * 获取管理员关联的店面列表
	 * 管理员店面关联表
	 * @api_name 获取管理员关联的店面列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userstores.getStoreList
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 */
	public function getStoreList() {
		/** @var $m UserStore */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['aid'];
		
		$re = $m->getStoreList($uid);
		return return_json($re);
	}
	
	/**
	 * 添加更改管理员对应店面列表（批量）
	 * 管理员店面关联表
	 * @api_name 添加更改管理员对应店面列表（批量）
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userstores.setStores
	 *
	 * @return array|mixed|\Services_JSON_Error|string
	 * @throws \Throwable
	 */
	public function setStores() {
		/** @var $m UserStore */
		$m = $this->_model;
		$param = $this->param;
		
		$uid = $param['aid'];
		$stores = isset($param['stores']) ? json_decode($param['stores'], true) : [];
		
		$re = $this->transaction(function () use ($m, $uid, $stores) {
			$re = $m->setStores($uid, $stores);
			return $re;
		});
		
		return return_json($re);
	}
	
	/**
	 * 获取店长列表
	 * 管理员店面关联表
	 * @api_name 获取店长列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userstores.getStoreManager
	 *
	 * store_id
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getStoreManager() {
		$this->param['identity_type'] = UserStore::$_IDENTITY_TYPE['manager'];
		
		return parent::getList();
	}
	
	/**
	 * 获取店员列表
	 * 管理员店面关联表
	 * @api_name 获取店员列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Rbac.v1.Userstores.getStoreClerk
	 *
	 * store_id
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getStoreClerk() {
		$this->param['identity_type'] = UserStore::$_IDENTITY_TYPE['clerk'];
		
		$this->_buf['getList'] = [
			'link' => ['h_user'],
		];
		
		return parent::getList();
	}
	
}
