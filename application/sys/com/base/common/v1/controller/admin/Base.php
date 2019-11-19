<?php
// +----------------------------------------------------------------------
// | Description: 基础类，无需验证权限。
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\admin;

use app\admin\model\SystemConfig;
use app\common\model\SysLog;
use com\verify\HonrayVerify;
use think\exception\PDOException;
use Think\Model;
use think\Request;

class Base extends Common
{

    public function login()
    {   
        $userModel = model('AdminUser');
        $param = $this->param;
        log_record(" --- #### login param=" . json_encode_u($param));
        $username = $param['username'];
        $password = $param['password'];
        $verifyCode = !empty($param['verifyCode'])? $param['verifyCode']: '';
        $isRemember = !empty($param['isRemember'])? $param['isRemember']: '';
        $data = $userModel->login($username, $password, $verifyCode, $isRemember);
        if (!$data) {
            return rjErr($userModel->getError());
        }
        
        // 写入登录日志
	    $sysLogModel = new SysLog();
        $_data = [];
	    $_data['sl_aid'] = $data['aid'];
	    $_data['sl_title'] = '登录';
	    $_data['sl_caption'] = '登录';
	    $_data['sl_remark'] = '';
	    $_data['sl_type'] = 'login';
	    $re = $sysLogModel->add($_data);
	    if (isErr($re)) {
	    	return $re;
	    }
        
        return rjData($data);
    }

    public function relogin()
    {
        $userModel = model('AdminUser');
        $param = $this->param;
        $data = decrypt($param['rememberKey']);
        $username = $data['username'];
        $password = $data['password'];

        $data = $userModel->login($username, $password, '', true, true);
        if (!$data) {
	        return rjErr($userModel->getError());
        }
	    return rjData($data);
    }

    public function logout()
    {
        $param = $this->param;
        $aid = 0;
        if (isset($param['authkey'])) {
	        $cache = cache('login:Auth_' . $param['authkey']);
	        if (!empty($cache) && !empty($cache['userInfo'])) {
		        $aid = $cache['userInfo']['id'];
	        }
        	
	        cache('login:Auth_'.$param['authkey'], null);
        }
	
	    // 写入登录日志
	    $sysLogModel = new SysLog();
	    $_data = [];
	    $_data['sl_aid'] = $aid;
	    $_data['sl_title'] = '退出';
	    $_data['sl_caption'] = '退出';
	    $_data['sl_remark'] = '';
	    $_data['sl_type'] = 'logout';
	    $re = $sysLogModel->add($_data);
	    if (isErr($re)) {
		    return $re;
	    }

        return return_json_ok('退出成功');
    }

    public function getConfigs()
    {
//         $systemConfig = cache('DB_CONFIG_DATA');
// //	    $systemConfig = null;
//         if (!$systemConfig) {
//             //获取所有系统配置
//             $systemConfig = model('admin/SystemConfig')->getDataList();
//             cache('DB_CONFIG_DATA', null);
//             cache('DB_CONFIG_DATA', $systemConfig, 36000); //缓存配置
//         }
	    $systemConfigModel = new SystemConfig();
	    $re = $systemConfigModel->getDataCache();
//        Log::record("--- #### getConfigs systemConfig=" . json_encode_u($systemConfig));
        //return resultArray(['data' => $systemConfig]);
	    return return_json($re);
    }

    public function getVerify()
    {
    	$config = config('sys_config.captcha');
    	if (empty($config)) {
    		$config = [];
	    }
        $captcha = new HonrayVerify($config);
        return $captcha->entry();
    }

    public function setInfo()
    {
        $userModel = model('AdminUser');
        $param = $this->param;
        $old_pwd = $param['old_pwd'];
        $new_pwd = $param['new_pwd'];
        $auth_key = $param['auth_key'];
        $data = $userModel->setInfo($auth_key, $old_pwd, $new_pwd);
        if (!$data) {
	        return rjErr($userModel->getError());
        }
	    return rjData($data);
    }

    // miss 路由：处理没有匹配到的路由规则
    public function miss()
    {
        if (Request::instance()->isOptions()) {
            return ;
        } else {
            echo 'hello';
        }
    }
}
 