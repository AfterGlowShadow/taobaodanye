<?php


namespace app\sys\com\builder\common\v1\logic;


use think\helper\Str;

class ValidateCommon extends Base {
	protected static $_instance = null;
	
	/**
	 * 防止克隆
	 *
	 */
	private function __clone() {
	}
	
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
	 *  model_path
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
		
		$_module_infos = $param['module_infos'];
		
		// 路径
		$_path = $param['path'];
		// 命名空间
		$_namespace = $param['namespace'];
		
		$var['appTag'] = $param['appTag'];
		
		$var['Namespace'] = $_namespace;
		// $var['ClassName'] = Str::studly(getPrefixValue($_table)) . 's';
		$var['ClassName'] = $_module_infos['Model'];
		
		$var['FileDescription'] = isset($param['FileDescription']) ? $param['FileDescription'] : '';
		
		// validate
		$var = array_merge($var, $this->makeValidateFunc($text, $var, $param));
		
		$result = $this->var2value($text, $var);
		return $result;
	}
	
	/**
	 * 所有表替换
	 *  module   api或admin
	 *  path 控制器的路径
	 *  model_path 模块的路径
	 *
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return bool
	 */
	public function allTable2VarValue($text, $var, $param) {
		/** @var TableCommon $tableCommon */
		$tableCommon = TableCommon::getInstance();
		$re          = $tableCommon->getTableList();
		if (isErr($re)) {
			return false;
		}
		
		$_tables = gData($re);
		
		$_namespace = str_replace('/', '\\', $param['path']);
		
		$_namespace = str_replace('application', 'app', $_namespace);
		
		$param['namespace'] = $_namespace;
		
		/** @var ConfigCommon $configCommon */
		$configCommon = ConfigCommon::getInstance();
		
		$_param = $param;
		
		foreach ($_tables as $row) {
			$param = $_param;
			
			$param['table'] = $row['table_name'];
			
			// 解出组件名
			// $_module_infos = getTableModuleModel($row, config('builder.config.table_module_name'), config('builder.config.default_module_name'));
			// $param['module_infos'] = $_module_infos;
			//
			// $param['_appType'] = $param['appType'];
			// if ($_module_infos['is_component'] && $_module_infos['is_sys']) {
			// 	$param['appType'] = config('builder.config.sys_app_type');
			// 	$param['package'] = config('builder.config.sys_package');
			// }
			
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
			$param['path'] = $configCommon->_path['base_path'][$param['appType']]['build_vbase_base_path'];
			
			$_namespace = str_replace('/', '\\', $param['path']);
			$_namespace = str_replace('application', 'app', $_namespace);
			$param['namespace'] = $_namespace;
			
			// 字段列表
			$_fields         = array_keys($tableCommon->getFieldList(getPrefixValue($row['table_name'])));
			$param['fields'] = $_fields;
			$_pk             = $tableCommon->getPrimaryKey(getPrefixValue($row['table_name']));
			$param['pk']     = $_pk;
			
			$reText = $this->setVarValue($text, $var, $param);
			if (isset($param['onCallBack']) && $param['onCallBack'] instanceof \Closure) {
				call_user_func_array($param['onCallBack'], [$reText, $text, $var, $param]);
			}
		}
		
		return true;
	}
	
	public function makeValidateFunc($text, $var, $param) {
		$result = [
			'ruleList' => '',
			'messageList' => '',
			'sceneAddList' => '',
			'sceneEditList' => '',
		];
		
		// 要处理的表名
		$_table = $param['table'];
		// 字段列表
		$_fields = $param['fields'];
		
		$_s_fields = [];
		$_FieldInfos = [];
		$_field_star = [];
		
		// $_columns = get_db_column_comment(getPrefixValue($_table));
		$_columns = get_db_column(getPrefixValue($_table));
		
		$_pre = '';
		$_pk = $param['pk'];
		if (!empty(getPrefix($_pk))) {
			$_pre = getPrefix($_pk);
		}
		
		foreach ($_fields as $row) {
			$_f = $row;
			$_sf = str_replace($_pre, '', $_f);
			
			$_s_fields[] = $_sf;
			$_field_star[] = ' * ' . $_sf;
			
			$_FieldInfos[] = [
				'f' => $_f,
				'pre' => $_pre,
				'sf' => $_sf,
				'_sf' => in_array($_sf, ['param']) ? '_' . $_sf : $_sf,
				'comment' => isset($_columns[$_f]['comment']) ? $_columns[$_f]['comment'] : '',
				'type' => isset($_columns[$_f]['type']) ? $_columns[$_f]['type'] : '',
			];
		}
		
		// 计算制表符个数
		$_max_charlength = arr_max_charlength($_field_star);
		$tabSize = 4;
		foreach ($_FieldInfos as &$item) {
			$item['end_tab_len'] = char_end_tab_size(' * ' . $item['sf'], $_max_charlength + $tabSize * 2, $tabSize);
		}
		
		$s = '';
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'delete_time', 'id'])) {
				continue;
			}
			
			if (in_array($_sf, ['name'])) {
				$s .= "\t\t'" . $_f . "' => '" . "require|unique:" . getPrefixValue($_table) . "," . $_f . "',\n";
			} elseif (in_array($_sf, ['email'])) {
				$s .= "\t\t'" . $_f . "' => '" . "require|email|unique:" . getPrefixValue($_table) . "," . $_f . "',\n";
			} else {
				$s .= "\t\t'" . $_f . "' => '" . "require" . "',\n";
			}
		}
		
		$result['ruleList'] = $s;
		
		$s = '';
		
		foreach ($_FieldInfos as $row) {
			$_f       = $row['f'];
			$_pre     = $row['pre'];
			$_sf      = $row['sf'];
			$_comment = $row['comment'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'delete_time', 'id'])) {
				continue;
			}
			
			if (in_array($_sf, ['name'])) {
				$s .= "\t\t'" . $_f . ".require' => '“" . $_comment . "”必须填写',\n";
				$s .= "\t\t'" . $_f . ".unique' => '“" . $_comment . "”已存在',\n";
			} elseif (in_array($_sf, ['email'])) {
				$s .= "\t\t'" . $_f . ".require' => '“" . $_comment . "”必须填写',\n";
				$s .= "\t\t'" . $_f . ".email' => '“" . $_comment . "”邮箱格式不正确',\n";
				$s .= "\t\t'" . $_f . ".unique' => '“" . $_comment . "”已存在',\n";
			} else {
				$s .= "\t\t'" . $_f . ".require' => '“" . $_comment . "”必须填写',\n";
			}
		}
		
		$result['messageList'] = $s;
		
		$_arr_fields = [];
		foreach ($_FieldInfos as $row) {
			$_f   = $row['f'];
			$_pre = $row['pre'];
			$_sf  = $row['sf'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'delete_time', 'id', 'remarks', 'sort'])) {
				continue;
			}
			
			$_arr_fields[] = $_f;
		}
		
		$result['sceneAddList'] = '"' . implode('", "', $_arr_fields) . '"';
		$result['sceneEditList'] = '"' . implode('", "', $_arr_fields) . '"';
		
		return $result;
	}
	
	
}