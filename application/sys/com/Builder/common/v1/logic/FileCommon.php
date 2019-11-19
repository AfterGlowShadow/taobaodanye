<?php


namespace app\sys\com\builder\common\v1\logic;

use FileSdk\FileTools;
use FileSdk\FileUtils;

class FileCommon {
	protected static $_instance = null;
	
	/**
	 * 防止克隆
	 *
	 */
	private function __clone(){}
	
	/**
	 * Singleton instance
	 *
	 * @return Object
	 */
	public static function getInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * 构建Model
	 *
	 * @param string $package 包名或子应用名 uuStart
	 * @param string $module
	 * @param string $appType 应用类型
	 * @return mixed
	 */
	public function modelMaker($package, $module = 'common', $appType = 'lib') {
		/** @var TableCommon $tableCommon */
		$tableCommon = TableCommon::getInstance();
		$param = [];
		//$param['path'] = 'application/' . $module . '/model/table';
		//$param['package'] = $package;
		$param['module'] = $module;
		$param['appType'] = $appType;
		$param['ver'] = 'v1';
		$param['appTag'] = 'com';
		
		/** @var ConfigCommon $configCommon */
		$configCommon = ConfigCommon::getInstance();
		$configCommon->read($package, config('builder.config.default_module_name'), $module, $appType, $param['ver'], $param['appTag']);
		$param['path'] = $configCommon->_path['base_path'][$appType]['build_table_base_path'];
		$param['path_extends'] = $configCommon->_path['base_path'][$appType]['build_model_base_path'];
		
		$param['onCallBack'] = function ($reText, $text, $var, $param) {
			$_file = app()->getRootPath() . $param['path'] . DIRECTORY_SEPARATOR . $var['ClassName'] . '.php';
			if (!empty($var['ClassName']) && (!file_exists($_file) || input('rebuild') == 1)) {
				$GLOBALS['return_list'][] = "{$_file} 生成";
				FileUtils::create_dir(dirname($_file));
				FileTools::writetofile($_file, $reText);
			} elseif (file_exists($_file)) {
				$GLOBALS['return_list'][] = "{$_file} 已存在";
			}
		};
		
		$text = file_get_contents(COM_PATH . 'Builder/common/v1/template/model/default_table.t');
		$var = $tableCommon->_var;
		$re = $tableCommon->allTable2VarValue($text, $var, $param);
		if ($re === false) {
			return false;
		}
		
		// 构建继承者
		$param['onCallBack'] = function ($reText, $text, $var, $param) {
			$_file = app()->getRootPath() . $param['path_extends'] . DIRECTORY_SEPARATOR . $var['ClassName'] . '.php';
			if (!empty($var['ClassName']) && !file_exists($_file)) {
				$GLOBALS['return_list'][] = "{$_file} 生成";
				
				FileTools::writetofile($_file, $reText);
			} elseif (file_exists($_file)) {
				$GLOBALS['return_list'][] = "{$_file} 已存在";
			}
		};
		
		$text_extends = file_get_contents(COM_PATH . 'Builder/common/v1/template/model/default_extends.t');
		$re = $tableCommon->allTable2VarValue($text_extends, $var, $param);
		
		return $re;
	}
	
	/**
	 * 构建控制器
	 *
	 * @param        $package
	 * @param string $module
	 * @param string $appType
	 * @param string $modelModule
	 * @param string $ver
	 * @param string $addonAlias
	 * @return bool
	 */
	public function controllerMaker($package, $module = 'admin', $appType = 'lib', $modelModule = 'common', $ver = 'v1', $addonAlias = '') {
		/** @var ControllerCommon $controllerCommon */
		$controllerCommon = ControllerCommon::getInstance();
		$param = [];
		$param['addon_alias'] = !empty($addonAlias) ? $addonAlias : $package; // 用于生成路由url的插件别名 有时为了规避冲突包名和路由不一样
		$param['package'] = $package;
		$param['module'] = $module;
		$param['appType'] = $appType;
		$param['modelModule'] = $modelModule;
		$param['ver'] = $ver;
		$param['appTag'] = 'com';
		
		/** @var ConfigCommon $configCommon */
		$configCommon = ConfigCommon::getInstance();
		
		switch ($module) {
			case 'admin':
			case 'api':
				$configCommon->read($package, config('builder.config.default_module_name'), $module, $appType, $ver, $param['appTag']);
				$param['path'] = $configCommon->_path['base_path'][$appType]['build_logic_base_path'];
				$param['path_extends'] = $configCommon->_path['base_path'][$appType]['build_controller_base_path'];
			
				$configCommon->init_path();
				$configCommon->read($package, config('builder.config.default_module_name'), $modelModule, $appType, $ver, $param['appTag']);
				$param['model_table_path'] = $configCommon->_path['base_path'][$appType]['build_table_base_path'];
				$param['model_path'] = $configCommon->_path['base_path'][$appType]['build_model_base_path'];
				$text = file_get_contents(COM_PATH . 'Builder/common/v1/template/controller/' . $module . '/default_logic.t');
				$text_extends = file_get_contents(COM_PATH . 'Builder/common/v1/template/controller/' . $module . '/default_extends.t');
				break;
			
			default:
				echo "未知模块 {$module}";
				break;
		}
		
		$param['onCallBack'] = function ($reText, $text, $var, $param) {
			$_file = app()->getRootPath() . $param['path'] . DIRECTORY_SEPARATOR . $var['ClassName'] . '.php';
			if (!empty($var['ClassName']) && (!file_exists($_file) || input('rebuild') == 1)) {
				$GLOBALS['return_list'][] = "{$_file} 生成";
				FileUtils::create_dir(dirname($_file));
				FileTools::writetofile($_file, $reText);
			} elseif (file_exists($_file)) {
				$GLOBALS['return_list'][] = "{$_file} 已存在";
			}
		};
		
		$var = $controllerCommon->_var;
		$re = $controllerCommon->allTable2VarValue($text, $var, $param);
		if ($re === false) {
			return false;
		}
		
		// 构建继承者
		$param['onCallBack'] = function ($reText, $text, $var, $param) {
			$_file = app()->getRootPath() . $param['path_extends'] . DIRECTORY_SEPARATOR . $var['ClassName'] . '.php';
			if (!empty($var['ClassName']) && !file_exists($_file)) {
				$GLOBALS['return_list'][] = "{$_file} 生成";
				
				FileTools::writetofile($_file, $reText);
			} elseif (file_exists($_file)) {
				$GLOBALS['return_list'][] = "{$_file} 已存在";
			}
		};
		
		$re = $controllerCommon->allTable2VarValue($text_extends, $var, $param);
		
		return $re;
	}
	
	public function validateMaker($package, $module = 'common', $appType = 'lib') {
		/** @var ValidateCommon $validateCommon */
		$validateCommon = ValidateCommon::getInstance();
		$param = [];
		$param['package'] = $package;
		$param['module'] = $module;
		$param['appType'] = $appType;
		$param['ver'] = 'v1';
		$param['appTag'] = 'com';
		
		/** @var ConfigCommon $configCommon */
		$configCommon = ConfigCommon::getInstance();
		$configCommon->read($package, config('builder.config.default_module_name'), $module, $appType, $param['ver'], $param['appTag']);
		$param['path'] = $configCommon->_path['base_path'][$appType]['build_vbase_base_path'];
		
		$param['onCallBack'] = function ($reText, $text, $var, $param) {
			$_file = app()->getRootPath() . $param['path'] . DIRECTORY_SEPARATOR . $var['ClassName'] . '.php';
			if (!empty($var['ClassName']) && (!file_exists($_file) || input('rebuild') == 1)) {
				$GLOBALS['return_list'][] = "{$_file} 生成";
				FileUtils::create_dir(dirname($_file));
				FileTools::writetofile($_file, $reText);
			} elseif (file_exists($_file)) {
				$GLOBALS['return_list'][] = "{$_file} 已存在";
			}
		};
		
		$text = file_get_contents(COM_PATH . 'Builder/common/v1/template/validate/default_vbase.t');
		$var = $validateCommon->_var;
		$re = $validateCommon->allTable2VarValue($text, $var, $param);
		return $re;
	}
	
	public function commentMaker($package, $module = 'admin', $appType = 'lib', $modelModule = 'common', $ver = 'v1', $addonAlias = '') {
		/** @var CommentCommon $commentCommon */
		$commentCommon = CommentCommon::getInstance();
		$param = [];
		$param['addon_alias'] = !empty($addonAlias) ? $addonAlias : $package; // 用于生成路由url的插件别名 有时为了规避冲突包名和路由不一样
		$param['package'] = $package;
		$param['module'] = $module;
		$param['appType'] = $appType;
		$param['modelModule'] = $modelModule;
		$param['ver'] = $ver;
		$param['appTag'] = 'com';
		
		/** @var ConfigCommon $configCommon */
		$configCommon = ConfigCommon::getInstance();
		
		switch ($module) {
			case 'admin':
			case 'api':
				$configCommon->read($package, config('builder.config.default_module_name'), $module, $appType, $ver, $param['appTag']);
				$param['path'] = $configCommon->_path['base_path'][$appType]['build_logic_base_path'];
				$param['path_extends'] = $configCommon->_path['base_path'][$appType]['build_controller_base_path'];
				
				$configCommon->init_path();
				$configCommon->read($package, config('builder.config.default_module_name'), $modelModule, $appType, $ver, $param['appTag']);
				$param['model_table_path'] = $configCommon->_path['base_path'][$appType]['build_table_base_path'];
				$param['model_path'] = $configCommon->_path['base_path'][$appType]['build_model_base_path'];
				//$text = file_get_contents(COM_PATH . 'builder/common/v1/template/controller/' . $module . '/default_logic.t');
				//$text_extends = file_get_contents(COM_PATH . 'builder/common/v1/template/controller/' . $module . '/default_extends.t');
				$text = '';
				$text_extends = '';
				break;
			
			default:
				echo "未知模块 {$module}";
				break;
		}
		
		$param['onCallBack'] = function ($reData, $text, $var, $param) use ($commentCommon) {
			$_file = app()->getRootPath() . $param['path'] . DIRECTORY_SEPARATOR . $var['ClassName'] . '.php';
			// if (!empty($var['ClassName']) && (!file_exists($_file) || input('rebuild') == 1)) {
			// 	echo "{$_file} 生成</br>";
			// 	FileUtils::create_dir(dirname($_file));
			// 	FileTools::writetofile($_file, $reText);
			// } elseif (file_exists($_file)) {
			// 	echo "{$_file} 已存在</br>";
			// }
			
			if (!isset($reData['class']['type']) || !in_array($reData['class']['type'], [2])) {
				return;
			}
			
			if (!isset($reData['class']['is_def_name']) || $reData['class']['is_def_name'] == 1) {
				return;
			}
			
			// 写数据库
			/** @var CommentCommon $commentCommon */
			//$re = $commentCommon->makeDb($text, $var, $param);
			
			//echo json_encode_u($reData) . "</br>";
			foreach ($reData['func'] as $item) {
				echo $item['name'] . "</br>";
			}
		};
		
		$var = $commentCommon->_var;
		$re = $commentCommon->allTable2VarValue($text, $var, $param);
		if ($re === false) {
			return false;
		}
		
		// 写数据库
		$re = $commentCommon->makeDb($text, $var, $param);
		
		return $re;
	}
	
}