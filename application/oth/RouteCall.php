<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017-2020 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------

namespace app\rha;

use think\facade\Config;
use think\facade\Log;
use think\facade\Request;
use think\facade\View;
use think\helper\Str;

class RouteCall {
	private $addon = 'oth';
	private $_com = 'com';
	private $_component;
	private $_type = 'api';
	private $_ver;
    private $col;
    private $act;
    private $adParam;
    
    public function __construct() {
        $param = Request::param();
        $this->adParam = $param;
	    empty($param['addon']) && $param['addon'] = $this->addon;
	    empty($param['_com']) && $param['_com'] = 'com'; // $this->_com;
	    empty($param['_type']) && $param['_type'] = $this->_type;
	    empty($param['ver']) && $param['ver'] = 'v1';
	
        sessionOrGLOBALS('addonRule', $param);
        $this->_component = Str::studly($param['component']);
	    $this->_type = $param['_type'];
	    $this->_ver = preg_replace('/.(v\d+)/i', '$1', $param['ver']);
        $this->col = $param['col'];
        $this->act = $param['act'];
	    $this->_com = preg_replace('/_(\w+)/i', '$1', $param['_com']);
	
	    $_p               = $param;
	    $_p['addon']      = $this->addon;
	    $_p['com']        = $this->_com;
	    $_p['component']  = $this->_component;
	    $_p['type']       = $this->_type;
	    $_p['ver']        = $this->_ver;
	    $_p['col']        = $this->col;
	    $_p['act']        = $this->act;
	
	    sessionOrGLOBALS('addonParam', $_p);
	
	    sessionOrGLOBALS('route_url', "/{$_p['addon']}/{$_p['type']}/{$_p['component']}.v1.{$_p['col']}.{$_p['act']}");
    }
    /**
     * 应用调起
     * @author geeson myrhzq@qq.com
     */
    public function run(Request $request) {
    	$_error_config = [];
	    sessionOrGLOBALS('addonErrorConfig', $_error_config);
        if ($this->_component && $this->col && $this->act) { // && $this->_ver
            sessionOrGLOBALS('addonName', $this->addon);
            
            $_com_path = LIB_PATH . $this->addon . '/' . $this->_com . '/';//COM_PATH;
	        $_type_path = $_com_path . $this->_component . DS . $this->_type;
            $_ver_path = $_type_path . DS . $this->_ver;
            $_no_ver = true;
	
	        $filename = $_type_path . DS . 'controller/' . ucfirst($this->col) . '.php';
            if (!file_exists($filename)) {
	            $_no_ver = false;
	            $filename = $_ver_path . DS . 'controller/' . ucfirst($this->col) . '.php';
            }
            
	        Log::record('--- ### filename=' . $filename);
	
	        // if(file_exists($initFile = LIB_PATH . $this->addon . '/init.php')){
		    //     include_once $initFile;
	        // }
	
	        if(file_exists($initFile = LIB_PATH . 'init_loader.php')){
		        include_once $initFile;
	        }
	
	        // if(file_exists($initFile = LIB_PATH . 'init.php')){
		    //     include_once $initFile;
	        // }
            
            // if(file_exists($commonFile = $_com_path . $this->_component . '/common.php')){
            //     include_once $commonFile;
            // }
	
	        // if(file_exists($errConfigFile=ROOT_PATH.$this->addon .'/config/error_code.php')){
		    //     $_err_code = include_once $errConfigFile;
		    //     $_error_config = array_merge($_error_config, $_err_code);
	        // }
	
	        if(file_exists($errComponentConfigFile=$_com_path . $this->_component .'/config/error_code.php')){
		        $_err_code = include_once $errComponentConfigFile;
		        $_error_config[$this->_component] = $_err_code;
	        }
	
	        sessionOrGLOBALS('addonErrorConfig', $_error_config);
            
            if(!is_dir($_com_path . $this->_component)){
                abort(500, $this->_component.'应用不存在');
            }
            $viewConfig['tpl_replace_string']['__STATIC__'] = '/public/static/';
            // $viewConfig['tpl_replace_string']['__ADDONSTATIC__'] = '/' . $this->addon . '/static/';
	        // $viewConfig['tpl_replace_string']['__COMSTATIC__'] = $_com_path . $this->_component . '/' . $this->_type . '/' . $this->_ver . '/static/';
	        
	        if ($_no_ver) {
		        $viewConfig['tpl_replace_string']['__COMSTATIC__'] = $_type_path . '/static/';
	        } else {
		        $viewConfig['tpl_replace_string']['__COMSTATIC__'] = $_ver_path . '/static/';
	        }
         
	        View::config($viewConfig);
            if (file_exists($filename)) {
                // include_once $_com_path . $this->_component . DS . $this->_type . DS . $this->_ver . DS . '/controller/' . ucfirst($this->col).'.php';
                if ($_no_ver) {
	                include_once $_type_path . DS . '/controller/' . ucfirst($this->col).'.php';
	                $class = '\\' . 'lib' . '\\' . $this->addon . '\\' . $this->_com . '\\' . $this->_component . '\\' . $this->_type . '\controller\\' . ucfirst($this->col);
                } else {
	                include_once $_ver_path . DS . '/controller/' . ucfirst($this->col).'.php';
	                $class = '\\' . 'lib' . '\\' . $this->addon . '\\' . $this->_com . '\\' . $this->_component . '\\' . $this->_type . '\\' . $this->_ver . '\controller\\' . ucfirst($this->col);
                }
                
	            Log::record('--- ### class=' . $class);
                if (class_exists($class, false)) {
                    $model = new $class;
                    if (!method_exists($model, $this->act)) {
                        abort(500, $this->act.'方法不存在');
                    }
                    return call_user_func_array([$model, $this->act],[]);
                } else {
	                if ($_no_ver) {
		                $class = '\\' . $this->_com . '\\' . $this->_component . '\\' . $this->_type . '\controller\\' . ucfirst($this->col);
	                } else {
		                $class = '\\' . $this->_com . '\\' . $this->_component . '\\' . $this->_type . '\\' . $this->_ver . '\controller\\' . ucfirst($this->col);
	                }
	                    
	                Log::record('--- ### class=' . $class);
	                if (class_exists($class, false)) {
		                $model = new $class;
		                if (!method_exists($model, $this->act)) {
			                abort(500, $this->act.'方法不存在');
		                }
		                return call_user_func_array([$model, $this->act],[]);
	                } else {
		                abort(500, $class . '不存在');
	                }
                }
            } else {
                abort(500, $this->col.'控制器不存在！');
            }
        }else{
            abort(500, $this->addon.'找不到此应用');
        }
    }

}