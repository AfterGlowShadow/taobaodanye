<?php
// +----------------------------------------------------------------------
// | Description: Api基础类，验证权限
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\admin;

use app\sys\com\base\event\Event;
use think\App;
use think\Db;
// use app\admin\adapter\AuthAdapter;
// use app\admin\controller\Common;
use think\facade\Request;


class ApiCommon extends Common {
	public $checkLogin = true;
	
	// public $userInfo;
	// public $authList;
	public $aid = 0;
	
	protected $beforeActionList = [
		'checkLogin' => ['except'=>'login'],
	];
	
	public function __construct(App $app = null) {
		parent::__construct($app);
		
		$this->construct_after($app);
	}
	
	public function construct_after($app) {
	
	}
	
	public function initialize() {
        parent::initialize();
        /*获取头部信息*/
//        $header = Request::instance()->header();
	    //$header = Request::header();
		
    }
    
	public function checkLogin() {
    	if (!$this->checkLogin || defined('BUILDER_CALL')) {
    		return true;
	    }
    	
		$value = [];
		$value['addonParam'] = $this->_addon_param;
		
		try {
			$re = Event::t('checkLoginAdmin', $value);
			
			if (isErr($re)) {
				// exit(json_encode_u(return_status_err('请先登录', 11001)));
				exit(json_encode_u($re));
			}
			
			$reData = gData($re);
			$this->aid = $reData['aid'];
			
			// $addonParam = sessionOrGLOBALS('addonParam');
			// empty($this->_addon_param['addon_type']) && $this->_addon_param['addon_type'] = $addonParam['addon_type'];
			
			return true;
		} catch (\Exception $e) {
			exit(json_encode_u(return_status_err($e->getMessage(), 11007)));
		}
	}
	
}
