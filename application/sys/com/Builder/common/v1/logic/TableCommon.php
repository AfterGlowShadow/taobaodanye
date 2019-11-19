<?php
// +----------------------------------------------------------------------
// | Description: 产品技术参数
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\builder\common\v1\logic;

use FileSdk\FileUtils;
use Think\Db;
use think\helper\Str;

class TableCommon extends Base {
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
	 * 替换字符的变量为值
	 *  调用者需要提供：
	 *  table
	 *  field_list
	 *  path
	 *  namespace
	 *
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return mixed
	 */
	public function setVarValue($text, &$var, $param) {
		// 要处理的表名
		$_table = $param['table'];
		
		// $_module_infos = getTableModuleModel($_table, 'uu', 'index');
		$_module_infos = $param['module_infos'];
		
		// 要处理的字段列表
		$_field_list = $param['field_list'];
		// 路径
		// $_path = $param['path'];
		// $_path_extends = $param['path_extends'];
		// 命名空间
		$_namespace = $param['namespace'];
		$_namespace_extends = $param['namespace_extends'];
		
		if (empty($_field_list)) {
			$_field_list = array_keys($this->getFieldList(getPrefixValue($_table)));
		}
		
		$var['Namespace'] = $_namespace;
		$var['NamespaceExtends'] = $_namespace_extends;
		// $var['ClassName'] = Str::studly(getPrefixValue($_table));
		
		// 应用类型
		// $var['appType'] = $param['_appType'];
		// $var['appTypeDir'] = $param['_appType'] == 'mp' ? 'addons' : $param['appType'];
		
		$var['appTypeDir'] = 'app';
		$var['appTag'] = $param['appTag'];
		
		// 包名
		$var['package'] = $param['package'];
		// 类名
		$var['ClassName'] = $_module_infos['Model'];
		// 组件
		$var['component'] = $_module_infos['module'];
		// 模块
		$var['module'] = $param['module'];
		// 检测字段前缀
		$var['FieldPrefix'] = getPrefix($_field_list[0]);
		// 查找是否存在主键
		$_pk = $this->getPrimaryKey(getPrefixValue($_table));
		$var['PK'] = !empty($_pk) ? getPrefixValue($_pk) : '';
		
		// $var['mpid'] = '';
		// $var['maid'] = '';
		
		// if (in_array($var['FieldPrefix'] . 'mpid', $_field_list)) {
		// 	$var['mpid'] = $var['FieldPrefix'] . 'mpid';
		// } elseif (in_array('mpid', $_field_list)) {
		// 	$var['mpid'] = 'mpid';
		// }
		//
		// if (in_array($var['FieldPrefix'] . 'maid', $_field_list)) {
		// 	$var['maid'] = $var['FieldPrefix'] . 'maid';
		// } elseif (in_array('maid', $_field_list)) {
		// 	$var['maid'] = 'maid';
		// }
		
		$var['FileDescription'] = '';
		// $var['TableName'] = getPrefixValue($_table);
		$var['TableName'] = $_module_infos['table_name'];
		$var['CreateTime'] = in_array($var['FieldPrefix'] . 'create_time', $_field_list) ? "'create_time'" : 'false';
		$var['UpdateTime'] = in_array($var['FieldPrefix'] . 'update_time', $_field_list) ? "'update_time'" : 'false';
		$var['AutoWriteTimestamp'] = ($var['CreateTime'] == 'false' && $var['UpdateTime'] == 'false') ? 'false' : 'true';
		
		$var['DeleteTime'] = in_array($var['FieldPrefix'] . 'delete_time', $_field_list) ? "'delete_time'" : 'false';
		$var['UseSoftDeleteNamespace'] = in_array($var['FieldPrefix'] . 'delete_time', $_field_list) ? 'use think\model\concern\SoftDelete;' : '';
		$var['UseSoftDelete'] = in_array($var['FieldPrefix'] . 'delete_time', $_field_list) ? 'use SoftDelete;' : '';
		
		$result = $this->var2value($text, $var);
		return $result;
	}
	
	/**
	 * 所有表替换
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return bool
	 */
	public function allTable2VarValue($text, $var, $param) {
		$re = $this->getTableList();
		if (isErr($re)) {
			return false;
		}
		
		$_tables = gData($re);
		$_fields = [];
		
		/** @var ConfigCommon $configCommon */
		$configCommon = ConfigCommon::getInstance();
		
		$_param = $param;
		
		foreach ($_tables as $row) {
			$param = $_param;
			
			$param['table'] = $row['table_name'];
			
			$_p = [];
			$_p['table_module_name'] = config('builder.config.table_module_name');
			$_p['default_module_name'] = config('builder.config.default_module_name');
			$_p['sys_table_module_name'] = config('builder.config.sys_table_module_name');
			$_p['sys_default_module_name'] = config('builder.config.sys_default_module_name');
			$_p['app_table_module_name'] = config('builder.config.app_table_module_name');
			$_p['app_default_module_name'] = config('builder.config.app_default_module_name');
			
			// 解出组件名
			$_module_infos = getTableModuleModel($row['table_name'], $_p);
			
			$param['module_infos'] = $_module_infos;
			
			$param['appTag'] = 'com';
			$param['_appType'] = $param['appType'];
			if ($_module_infos['is_component']) {
				if ($_module_infos['is_sys']) {
					$param['appType'] = config('builder.config.sys_app_type');
					$param['package'] = config('builder.config.sys_package');
				}
				
				if ($_module_infos['is_app']) {
					$param['appType'] = config('builder.config.app_app_type');
					$param['package'] = config('builder.config.app_package');
					$param['appTag'] = APP_TAG;
				}
			} else {
				$param['appType'] = config('builder.config.rha_app_type');
				$param['package'] = config('builder.config.rha_package');
			}
			
			// path
			$configCommon->init_path();
			$configCommon->read($param['package'], $_module_infos['module'], $param['module'], $param['appType'], $param['ver'], $param['appTag']);
			$param['path'] = $configCommon->_path['base_path'][$param['appType']]['build_table_base_path'];
			$param['path_extends'] = $configCommon->_path['base_path'][$param['appType']]['build_model_base_path'];
			
			$_namespace = str_replace('/', '\\', $param['path']);
			$_namespace_extends = str_replace('/', '\\', $param['path_extends']);
			
			$_namespace = str_replace('application', 'app', $_namespace);
			$_namespace_extends = str_replace('application', 'app', $_namespace_extends);
			
			$param['namespace'] = $_namespace;
			$param['namespace_extends'] = $_namespace_extends;
			$_fields = array_keys($this->getFieldList(getPrefixValue($param['table'])));
			$param['field_list'] = $_fields;
			
			$reText = $this->setVarValue($text, $var, $param);
			if (isset($param['onCallBack']) && $param['onCallBack'] instanceof \Closure) {
				call_user_func_array($param['onCallBack'], [$reText, $text, $var, $param]);
			}
		}
		
		return true;
	}
	
	// public function test() {
	// 	$d = $this->getDir();
	// 	$s = FileUtils::rela_pos(ROOT_PATH, $d);
	// 	return $s;
	// }
	
	public function getTableList($database = '') {
		empty($database) && $database = config('database.database');
		$database_name = $database;
		// !startwith($table_name, config('database.prefix')) && $table_name = config('database.prefix') . $table;
		
		try {
			$re = Db::table('information_schema.tables')
				->field('table_name, table_comment')
				->where('table_schema', '=', $database_name)
				->select();
				// ->where('table_type', '=', 'base table')
				//     ->column('table_name');//Db::query("select table_name from information_schema.tables where table_schema='csdb' and table_type='base table'");
			
			if ($re === false) {
				return rsErr(1000);
			}
			
			return rsData($re);
		} catch (\Exception $e) {
			return rsErr($e->getMessage());
		}
	}
	
	public function getFieldList($table = '', $database = '') {
		$fields = get_db_column_comment($table, true, $database);
		
		return $fields;
	}
	
	public function getPrimaryKey($table = '') {
		$key = get_db_primary_key($table);
		
		return $key;
	}
}
