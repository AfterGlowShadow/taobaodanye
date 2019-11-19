<?php


namespace app\sys\com\builder\common\v1\logic;


use think\helper\Str;

class ControllerCommon extends Base {
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
	 *  model_path
	 *  namespace
	 *  namespace_extends
	 *  appType
	 *  addon_alias
	 *
	 *
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return mixed
	 */
	public function setVarValue($text, &$var, $param) {
		// 要处理的表名
		$_table = $param['table'];
		$_table_comments = $param['table'];
		
		// 解析拆分的组件化相关
		$_module_infos = $param['module_infos'];
		
		// 要处理的字段列表
		$_field_list = $param['fields'];
		
		// 路径
		// $_path = $param['path'];
		// $_path_extends = $param['path_extends'];
		$_model_path = $param['_model_path'];
		// 命名空间
		$_namespace = $param['namespace'];
		$_namespace_extends = $param['namespace_extends'];
		
		$_model_namespace = str_replace('/', '\\', $_model_path);
		$_model_namespace = str_replace('application', 'app', $_model_namespace);
		
		$var['Namespace'] = $_namespace;
		$var['NamespaceExtends'] = $_namespace_extends;
		$var['ModelNamespace'] = $_model_namespace . '\\' . $_module_infos['Model'];
		
		// 应用类型
		// $var['appType'] = $param['appType'];
		// $var['appTypeDir'] = $param['appType'] == 'mp' ? 'addons' : $param['appType'];
		$var['appTypeDir'] = 'app';
		$var['appTag'] = $param['appTag'];
			// switch ($param['appType']) {
		// 	case 'mp':
		// 		$var['static_addon_type'] = 'static::$_ADDON_TYPE[\'mp\']';
		// 		$param['module'] == 'admin' && $var['module_addon_type'] = 'admin_mp';
		// 		break;
		// 	case 'miniapp':
		// 		$var['static_addon_type'] = 'static::$_ADDON_TYPE[\'ma\']';
		// 		$param['module'] == 'admin' && $var['module_addon_type'] = 'admin_miniapp';
		// 		break;
		// 	default:
		// 		$var['static_addon_type'] = 1;
		// }
		
		// 路由地址中插件名别名
		$var['addon_alias'] = $param['addon_alias'];
		$var['addon_url'] = $var['addon_alias'];
		
		if ($_module_infos['is_component']) {
			if ($_module_infos['is_sys']) {
				$var['addon_url'] = $param['package'];
			}
			
			if ($_module_infos['is_app']) {
				$var['addon_url'] = $param['package'];
			}
		} else {
			$var['addon_url'] = $param['package'];
		}
		
		// 包名
		$var['package'] = $param['package'];
		// 类名
		$var['ClassName'] = $_module_infos['Model'] . 's';
		// 组件
		$var['component'] = $_module_infos['module'];
		$var['_component'] = strtolower($_module_infos['module']);
		// 模块
		$var['module'] = $param['module'];
		// 版本
		$var['_ver'] = $param['ver'];
		
		// 模块名称
		$var['ModelName'] = $_module_infos['Model'];
		
		// extends ControllerCommon
		$var['ControllerCommon'] = 'ControllerCommon';
		if (in_array($param['module'], ['api']) && $_module_infos['Model'] == 'User') {
			$var['ControllerCommon'] = 'LoginCommon';
		}
		
		$var['FileDescription'] = isset($param['FileDescription']) ? $param['FileDescription'] : '';
		
		// ListParamVars
		$var['ListParamVars'] = $this->makeListParamVars($text, $var, $param);
		// ListParamWheres
		$var['ListParamWheres'] = $this->makeListParamWheres($text, $var, $param);
		// ListOrder
		$var['ListOrder'] = $this->makeListOrder($text, $var, $param);
		
		// class_comment
		$_class_comment = $this->makeClassComment($text, $var, $param);
		$var['class_comment'] = $_class_comment['class_comment'];
		$var['class_comment_extends'] = $_class_comment['class_comment_extends'];
		
		// func_comment
		$_func_comment = $this->makeFuncComment($text, $var, $param);
		$var['getList_comment'] = "\n" . $_func_comment['getList_comment'];
		$var['getItemById_comment'] = "\n" . $_func_comment['getItemById_comment'];
		$var['add_comment'] = $_func_comment['add_comment'];
		$var['edit_comment'] = $_func_comment['edit_comment'];
		$var['delete_comment'] = "\n" . $_func_comment['delete_comment'];
		$var['set_status_comment'] = '';
		if (in_array('status', $_field_list)) {
			$var['set_status_comment'] = $_func_comment['set_status_comment'];
		}
		
		// add
		$var['AddFunc'] = $this->makeAddFunc($text, $var, $param);
		// edit
		$var['EditFunc'] = $this->makeEditFunc($text, $var, $param);
		// setStatus
		$var['SetStatusFunc'] = '';
		if (in_array('status', $_field_list)) {
			$var['SetStatusFunc'] = $this->makeSetStatusFunc($text, $var, $param);
		}
		
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
		$re = $tableCommon->getTableList();
		if (isErr($re)) {
			return false;
		}
		
		$_tables = gData($re);
		
		$_namespace = str_replace('/', '\\', $param['path']);
		$_namespace_extends = str_replace('/', '\\', $param['path_extends']);
		
		$_namespace = str_replace('application', 'app', $_namespace);
		$_namespace_extends = str_replace('application', 'app', $_namespace_extends);
		
		$param['namespace'] = $_namespace;
		$param['namespace_extends'] = $_namespace_extends;
		
		/** @var ConfigCommon $configCommon */
		$configCommon = ConfigCommon::getInstance();
		
		$_param = $param;
		
		foreach ($_tables as $row) {
			$param = $_param;
			
			$param['table'] = $row['table_name'];
			$param['table_comments'] = parseTableComment($row['table_comment']);
			
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
			
			switch ($param['module']) {
				case 'admin':
				case 'api':
					$configCommon->init_path();
					$configCommon->read($param['package'], $_module_infos['module'], $param['module'], $param['appType'], $param['ver'], $param['appTag']);
					$param['path'] = $configCommon->_path['base_path'][$param['appType']]['build_logic_base_path'];
					$param['path_extends'] = $configCommon->_path['base_path'][$param['appType']]['build_controller_base_path'];
				
					$configCommon->init_path();
					$configCommon->read($param['package'], $_module_infos['module'], $param['modelModule'], $param['appType'], $param['ver'], $param['appTag']);
					$param['model_table_path'] = $configCommon->_path['base_path'][$param['appType']]['build_table_base_path'];
					$param['model_path'] = $configCommon->_path['base_path'][$param['appType']]['build_model_base_path'];
				
					$_namespace = str_replace('/', '\\', $param['path']);
					$_namespace_extends = str_replace('/', '\\', $param['path_extends']);
				
					$_namespace = str_replace('application', 'app', $_namespace);
					$_namespace_extends = str_replace('application', 'app', $_namespace_extends);
					
					$param['namespace'] = $_namespace;
					$param['namespace_extends'] = $_namespace_extends;
					break;
				
				default:
					//echo "未知模块 {$module}";
					return false;
					break;
			}
			
			// 字段列表
			$_fields = array_keys($tableCommon->getFieldList(getPrefixValue($row['table_name'])));
			$param['fields'] = $_fields;
			$_pk = $tableCommon->getPrimaryKey(getPrefixValue($row['table_name']));
			$param['pk'] = $_pk;
			
			$param['field_infos'] = $this->getFieldInfos($text, $var, $param);
			
			// 查找model是否存在 如果存在就优先加载model 不存在才加载table
			$_model_table_file = app()->getRootPath() . $param['model_table_path'] . DIRECTORY_SEPARATOR .
			                     $_module_infos['Model'] . '.php';
			$_model_file = app()->getRootPath() . $param['model_path'] . DIRECTORY_SEPARATOR .
			               $_module_infos['Model'] . '.php';
			$param['model_exist'] = file_exists($_model_file);
			$param['_model_path'] = $param['model_exist'] ? $param['model_path'] : $param['model_table_path'];
			
			$reText = $this->setVarValue($text, $var, $param);
			if (isset($param['onCallBack']) && $param['onCallBack'] instanceof \Closure) {
				call_user_func_array($param['onCallBack'], [$reText, $text, $var, $param]);
			}
		}
		
		return true;
	}
	
	public function getFieldInfos($text, $var, $param) {
		// 要处理的表名
		$_table = $param['table'];
		// 字段列表
		$_fields = $param['fields'];
		
		$_s_fields = [];
		$_FieldInfos = [];
		$_field_star = [];
		
		// $_comments = get_db_column_comment(getPrefixValue($_table));
		$_columns = get_db_column(getPrefixValue($_table));
		
		$_pre = '';
		$_pk = $param['pk'];
		if (!empty(getPrefix($_pk))) {
			$_pre = getPrefix($_pk);
		}
		
		foreach ($_fields as $row) {
			$_f = $row;
			// $_pre = '';
			// if (strpos($_f,"_") !== false) {
			// 	$_pre = substr($_f,0, strpos($_f,"_") + 1);
			// }
			
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
		
		$result = [
			's_fields' => $_s_fields,
			'FieldInfos' => $_FieldInfos,
			'field_star' => $_field_star,
		];
		
		return $result;
	}
	
	/**
	 * 构建 getList 中 param
	 * $title = isset($param['title']) ? $param['title'] : '';
	 *
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return string
	 */
	public function makeListParamVars($text, $var, $param) {
		// 要处理的表名
		$_table = $param['table'];
		// 字段列表
		$_fields = $param['fields'];
		
		$_field_infos = $param['field_infos'];
		$_s_fields = $_field_infos['s_fields'];
		$_FieldInfos = $_field_infos['FieldInfos'];
		$_field_star = $_field_infos['field_star'];
		
		$s = [];
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$_comment = $row['comment'];
			$_type = $row['type'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'id'])) {
				continue;
			}
			
			$_def_value = in_array($_type, ['int', 'tinyint', 'decimal']) ? 0 : "''";
			$s[] = "\t\t\${$_sf} = isset(\$param['{$_sf}']) ? \$param['{$_sf}'] : {$_def_value};";
		}
		
		return join("\n", $s);
	}
	
	/**
	 * 构建 getList 中 where
	 * isset($param['title']) && $_where[] = ['ni_title', '=', $title];
	 *
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return string
	 */
	public function makeListParamWheres($text, $var, $param) {
		// 要处理的表名
		$_table = $param['table'];
		// 字段列表
		$_fields = $param['fields'];
		
		$_field_infos = $param['field_infos'];
		$_s_fields = $_field_infos['s_fields'];
		$_FieldInfos = $_field_infos['FieldInfos'];
		$_field_star = $_field_infos['field_star'];
		
		$s = [];
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$_comment = $row['comment'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'id'])) {
				continue;
			}
			
			$s[] = "\t\tisset(\$param['{$_sf}']) && \$_where[] = ['{$_f}', '=', \${$_sf}];";
		}
		
		return join("\n", $s);
	}
	
	/**
	 * 构建 getList 中 order
	 * $_order = ['ni_create_time' => 'DESC'];
	 *
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return string
	 */
	public function makeListOrder($text, $var, $param) {
		// 要处理的表名
		$_table = $param['table'];
		// 字段列表
		$_fields = $param['fields'];
		
		$_field_infos = $param['field_infos'];
		$_s_fields = $_field_infos['s_fields'];
		$_FieldInfos = $_field_infos['FieldInfos'];
		$_field_star = $_field_infos['field_star'];
		
		$s = [];
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$_comment = $row['comment'];
			
			if (!in_array($_sf, ['create_time'])) {
				continue;
			}
			
			$s[] = "\t\t\$_order = ['{$_f}' => 'DESC'];";
		}
		
		empty($s) && $s[] = "\t\t\$_order = [];";
		
		return join("\n", $s);
	}
	
	/**
	 * 构建出add方法
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return string
	 */
	public function makeAddFunc($text, $var, $param) {
		// 要处理的表名
		$_table = $param['table'];
		// 字段列表
		$_fields = $param['fields'];
		
		// 解析拆分的组件化相关
		$_module_infos = $param['module_infos'];
		
		$_field_infos = $param['field_infos'];
		$_s_fields = $_field_infos['s_fields'];
		$_FieldInfos = $_field_infos['FieldInfos'];
		$_field_star = $_field_infos['field_star'];
		
		$add_comment = $var['add_comment'];
		
		// 计算制表符个数
		$_max_charlength = arr_max_charlength($_field_star);
		$tabSize = 4;
		foreach ($_FieldInfos as &$item) {
			$item['end_tab_len'] = char_end_tab_size(' * ' . $item['sf'], $_max_charlength + $tabSize * 2, $tabSize);
		}
		
		$s = [];
		
		// add
		$s[] = "\t/**";
		$s[] = "\t * 添加";
		
		if (!empty($add_comment)) {
			$s[] = $add_comment;
		}
		
		$s[] = "\t * ";
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$_comment = $row['comment'];
			$_end_tab_len = $row['end_tab_len'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'delete_time', 'id'])) {
				continue;
			}
			
			$s[] = "\t * " . $_sf . str_repeat("\t", $_end_tab_len) . $_comment;
		}
		
		$s[] = "\t * @return mixed|string";
		$s[] = "\t */";
		
		$s[] = "\tpublic function add() {";
		$s[] = "\t\t/** @var \$m " . $_module_infos['Model'] . " */";
		$s[] = "\t\t\$m = \$this->_model;";
		$s[] = "\t\t\$param = \$this->param;";
		$s[] = "\t\t";
		
		foreach ($_FieldInfos as $row) {
			$_sf = $row['sf'];
			$__sf = $row['_sf'];
			$_type = $row['type'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'delete_time', 'id'])) {
				continue;
			}
			
			// $s[] = "\t\t\$" . $__sf . " = \$param['" . $_sf . "'];";
			$_def_value = in_array($_type, ['int', 'tinyint', 'decimal']) ? 0 : "''";
			$s[] = "\t\t\$" . $__sf . " = isset(\$param['" . $_sf . "']) ? \$param['" . $_sf . "'] : {$_def_value};";
		}
		
		$s[] = "\t\t";
		$s[] = "\t\t\$_data = [];";
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$__sf = $row['_sf'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'delete_time', 'id'])) {
				continue;
			}
			
			$s[] = "\t\t\$_data['" . $_f . "'] = \$" . $__sf . ";";
		}
		
		$s[] = "\t\t\$re = \$m->add(\$_data);";
		$s[] = "\t\tif (!is_return_ok(\$re)) {";
		$s[] = "\t\t\treturn return_json(\$re);";
		$s[] = "\t\t}";
		$s[] = "\t\treturn return_json(\$re);";
		$s[] = "\t}";
		
		return join("\n", $s);
	}
	
	/**
	 * 构建出edit方法
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return string
	 */
	public function makeEditFunc($text, $var, $param) {
		// 要处理的表名
		$_table = $param['table'];
		// 字段列表
		$_fields = $param['fields'];
		
		// 解析拆分的组件化相关
		$_module_infos = $param['module_infos'];
		
		$_field_infos = $param['field_infos'];
		$_s_fields = $_field_infos['s_fields'];
		$_FieldInfos = $_field_infos['FieldInfos'];
		$_field_star = $_field_infos['field_star'];
		
		$edit_comment = $var['edit_comment'];
		
		// 计算制表符个数
		$_max_charlength = arr_max_charlength($_field_star);
		$tabSize = 4;
		foreach ($_FieldInfos as &$item) {
			$item['end_tab_len'] = char_end_tab_size(' * ' . $item['sf'], $_max_charlength + $tabSize * 2, $tabSize);
		}
		
		$s = [];
		
		/********************************
		 * edit
		 ********************************/
		$s[] = "\t";
		$s[] = "\t/**";
		$s[] = "\t * 更改";
		
		if (!empty($edit_comment)) {
			$s[] = $edit_comment;
		}
		
		$s[] = "\t *";
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$_comment = $row['comment'];
			$_end_tab_len = $row['end_tab_len'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'delete_time'])) {
				continue;
			}
			
			$s[] = "\t * " . $_sf . str_repeat("\t", $_end_tab_len) . $_comment;
		}
		
		$s[] = "\t * @return mixed|string";
		$s[] = "\t */";
		
		$s[] = "\tpublic function edit() {";
		$s[] = "\t\t/** @var \$m " . $_module_infos['Model'] . " */";
		$s[] = "\t\t\$m = \$this->_model;";
		$s[] = "\t\t\$param = \$this->param;";
		$s[] = "\t\t";
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$__sf = $row['_sf'];
			$_type = $row['type'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'delete_time'])) {
				continue;
			}
			
			if (in_array($_sf, ['id'])) {
				$s[] = "\t\t\$" . $__sf . " = \$param['" . $_sf . "'];";
			} else {
				$_def_value = in_array($_type, ['int', 'tinyint', 'decimal']) ? 0 : "''";
				$s[] = "\t\t\$" . $__sf . " = isset(\$param['" . $_sf . "']) ? \$param['" . $_sf . "'] : {$_def_value};";
			}
		}
		
		$s[] = "\t\t";
		$s[] = "\t\t\$_data = [];";
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$__sf = $row['_sf'];
			
			if (in_array($_sf, ['create_time', 'update_time', 'delete_time', 'id'])) {
				continue;
			}
			
			$s[] = "\t\tisset(\$param['" . $_sf . "']) && " . "\$_data['" . $_f . "'] = \$" . $__sf . ";";
		}
		
		$s[] = "\t\t\$re = \$m->editById(\$id, \$_data);";
		$s[] = "\t\tif (!is_return_ok(\$re)) {";
		$s[] = "\t\t\treturn return_json(\$re);";
		$s[] = "\t\t}";
		$s[] = "\t\treturn rjOk();";
		$s[] = "\t}";
		
		return join("\n", $s);
	}
	
	/**
	 * 构建出setStatus方法
	 * @param $text
	 * @param $var
	 * @param $param
	 * @return string
	 */
	public function makeSetStatusFunc($text, $var, $param) {
		// 要处理的表名
		$_table = $param['table'];
		// 字段列表
		$_fields = $param['fields'];
		
		// 解析拆分的组件化相关
		$_module_infos = $param['module_infos'];
		
		$_field_infos = $param['field_infos'];
		$_s_fields = $_field_infos['s_fields'];
		$_FieldInfos = $_field_infos['FieldInfos'];
		$_field_star = $_field_infos['field_star'];
		
		$set_status_comment = $var['set_status_comment'];
		
		// 计算制表符个数
		$_max_charlength = arr_max_charlength($_field_star);
		$tabSize = 4;
		foreach ($_FieldInfos as &$item) {
			$item['end_tab_len'] = char_end_tab_size(' * ' . $item['sf'], $_max_charlength + $tabSize * 2, $tabSize);
		}
		
		$s = [];
		
		/********************************
		 * setStatus
		 ********************************/
		$s[] = "\t";
		$s[] = "\t/**";
		$s[] = "\t * 更改状态";
		
		if (!empty($set_status_comment)) {
			$s[] = $set_status_comment;
		}
		
		$s[] = "\t *";
		
		foreach ($_FieldInfos as $row) {
			$_f = $row['f'];
			$_pre = $row['pre'];
			$_sf = $row['sf'];
			$_comment = $row['comment'];
			$_end_tab_len = $row['end_tab_len'];
			
			if (!in_array($_sf, ['id', 'status'])) {
				continue;
			}
			
			$s[] = "\t * " . $_sf . str_repeat("\t", $_end_tab_len) . $_comment;
		}
		
		$s[] = "\t * @return mixed|string";
		$s[] = "\t */";
		
		$s[] = "\tpublic function setStatus() {";
		$s[] = "\t\t/** @var \$m " . $_module_infos['Model'] . " */";
		$s[] = "\t\t\$m = \$this->_model;";
		$s[] = "\t\t\$param = \$this->param;";
		$s[] = "\t\t";
		
		$s[] = "\t\t\$id = \$this->p('id');";
		$s[] = "\t\t\$status = \$this->p('status');";
		$s[] = "\t\t";
		$s[] = "\t\t\$_d = [];";
		$s[] = "\t\t\$_d['status'] = \$status;";
		$s[] = "\t\t\$re = \$m->editById(\$id, \$_d);";
		$s[] = "\t\treturn return_json(\$re);";
		
		$s[] = "\t}";
		
		return join("\n", $s);
	}
	
	public function makeClassComment($text, $var, $param) {
		$_api_tag = [
			'name' => '',
			'title' => '',
			'icon' => '',
			'intro' => '',
			'url' => '',
			'type' => 2,
			'is_auth' => 1,
			'is_menu' => 0,
			'is_api' => 1,
			'is_show' => 0,
			'is_maker' => 1,
			'remark' => '',
		];
		
		$_table_comments = $param['table_comments'];
		
		// 解析拆分的组件化相关
		$_module_infos = $param['module_infos'];
		// 类名
		$_className = $var['ClassName'];
		$_namespace = $var['Namespace'];
		$_namespace_extends = $var['NamespaceExtends'];
		
		$_api_tag['name'] = $_className;
		$_is_def_name = true; // 初始化标记为默认生成（指数据表没有注解语法 由生成器默认指定类名为api名 在权限系统中不会生成权限规则）
		
		switch ($var['module']) {
			case 'admin':
				$_api_tag['type'] = 2;
				break;
			case 'api':
				$_api_tag['type'] = 3;
				break;
		}
		
		// switch ($param['appType']) {
		// 	case 'mp':
		// 		$_api_tag['addon_type'] = 1;
		// 		break;
		// 	case 'miniapp':
		// 		$_api_tag['addon_type'] = 2;
		// 		break;
		// }
		
		$result = [
			'class_comment' => '',
			'class_comment_extends' => '',
		];
		
		foreach ($result as $k => $v) {
			$s = [];
			
			$s[] = "/**";
			$s[] = " * Class {$_className}";
			
			// class注释
			if (!empty($_table_comments['comments'])) {
				foreach ($_table_comments['comments'] as $item) {
					$s[] = " * {$item}";
				}
			}
			
			// api注解语法
			if (!empty($_table_comments['vars'])) {
				$item = $_table_comments['vars'];
				
				// name
				isset($item['name']) && $_api_tag['name'] = $item['name'];
				isset($item['name']) && $_is_def_name = false; // 存在注解语法 不再是默认命名
				
				// type
				isset($item['type']) && $_api_tag['type'] = $item['type'];
				
				// addon_type
				//isset($item['addon_type']) && $_api_tag['addon_type'] = $item['addon_type'];
				
				// is_menu
				isset($item['is_menu']) && $_api_tag['is_menu'] = $item['is_menu'];
				
				// is_show
				isset($item['is_show']) && $_api_tag['is_show'] = $item['is_show'];
			}
			
			$s[] = " * @api_name {$_api_tag['name']}";
			$s[] = " * @api_type {$_api_tag['type']}";
			//$s[] = " * @api_addon_type {$_api_tag['addon_type']}";
			$s[] = " * @api_is_menu {$_api_tag['is_menu']}";
			$s[] = " * @api_is_maker {$_api_tag['is_maker']}";
			$s[] = " * @api_is_show {$_api_tag['is_show']}";
			$s[] = " * @api_is_def_name " . ($_is_def_name ? 1 : 0);
			
			// $_route_url = "/{{$addon_alias}}/admin/{{$_component}}.{{$_ver}}.{{$col}}.{{$act}}";
			// $s[] = "\t * @api_url ";
			
			switch ($k) {
				case 'class_comment':
					$s[] = " * @package {$_namespace}";
					break;
				case 'class_comment_extends':
					$s[] = " * @package {$_namespace_extends}";
					break;
			}
			
			$s[] = " */";
			
			$result[$k] = join(PHP_EOL, $s);
		}
		
		return $result;
	}
	
	public function makeFuncComment($text, $var, $param) {
		$_api_tag = [
			'name' => '',
			'title' => '',
			'icon' => '',
			'intro' => '',
			'url' => '',
			'type' => 2,
			'is_auth' => 1,
			'is_menu' => 0,
			'is_api' => 1,
			'is_show' => 0,
			'is_maker' => 1,
			'remark' => '',
		];
		
		$_table_comments = $param['table_comments'];
		
		// 解析拆分的组件化相关
		$_module_infos = $param['module_infos'];
		// 类名
		$_className = $var['ClassName'];
		$_namespace = $var['Namespace'];
		$_namespace_extends = $var['NamespaceExtends'];
		
		$_api_tag['name'] = $_className;
		$_is_def_name = true; // 初始化标记为默认生成（指数据表没有注解语法 由生成器默认指定类名为api名 在权限系统中不会生成权限规则）
		
		switch ($var['module']) {
			case 'admin':
				$_api_tag['type'] = 2;
				//$_api_tag['is_menu'] = 1;
				break;
			case 'api':
				$_api_tag['type'] = 3;
				//$_api_tag['is_menu'] = 0;
				break;
		}
		
		// switch ($param['appType']) {
		// 	case 'mp':
		// 		$_api_tag['addon_type'] = 1;
		// 		break;
		// 	case 'miniapp':
		// 		$_api_tag['addon_type'] = 2;
		// 		break;
		// }
		
		$result = [
			'getList_comment' => '',
			'getItemById_comment' => '',
			'add_comment' => '',
			'edit_comment' => '',
			'delete_comment' => '',
			'set_status_comment' => '',
		];
		
		foreach ($result as $k => $v) {
			switch ($k) {
				case 'getList_comment':
					$act = 'getList';
					break;
				case 'getItemById_comment':
					$act = 'getItemById';
					break;
				case 'add_comment':
					$act = 'add';
					break;
				case 'edit_comment':
					$act = 'edit';
					break;
				case 'delete_comment':
					$act = 'delete';
					break;
				case 'set_status_comment':
					$act = 'setStatus';
					break;
			}
			
			$s = [];
			
			//$s[] = "\t * Class {$_className}";
			
			// class注释
			if (!empty($_table_comments['comments'])) {
				foreach ($_table_comments['comments'] as $item) {
					$s[] = "\t * {$item}";
				}
			}
			
			// api注解语法
			if (!empty($_table_comments['vars'])) {
				$item = $_table_comments['vars'];
				
				// name
				isset($item['name']) && $_api_tag['name'] = $item['name'];
				isset($item['name']) && $_is_def_name = false; // 存在注解语法 不再是默认命名
				
				// type
				isset($item['type']) && $_api_tag['type'] = $item['type'];
				
				// addon_type
				//isset($item['addon_type']) && $_api_tag['addon_type'] = $item['addon_type'];
				
				// is_menu
				isset($item['is_menu']) && $_api_tag['is_menu'] = $item['is_menu'];
				
				// is_show
				isset($item['is_show']) && $_api_tag['is_show'] = $item['is_show'];
			}
			
			//$col = strtolower($var['ClassName']);
			$col = $var['ClassName'];
			$_component = Str::studly($var['_component']);
			
			$_api_tag['url'] = "/{$var['addon_url']}/{$var['module']}/{$_component}.{$var['_ver']}.{$col}.{$act}";
			
			switch ($k) {
				case 'getList_comment':
					$s[] = "\t * @api_name 获取{$_api_tag['name']}列表";
					break;
				case 'getItemById_comment':
					$s[] = "\t * @api_name 获取{$_api_tag['name']}详情";
					break;
				case 'add_comment':
					$s[] = "\t * @api_name 添加{$_api_tag['name']}";
					break;
				case 'edit_comment':
					$s[] = "\t * @api_name 更改{$_api_tag['name']}";
					break;
				case 'delete_comment':
					$s[] = "\t * @api_name 删除{$_api_tag['name']}";
					break;
				case 'set_status_comment':
					$s[] = "\t * @api_name 更改{$_api_tag['name']}状态";
					break;
			}
			
			$s[] = "\t * @api_type {$_api_tag['type']}";
			//$s[] = "\t * @api_addon_type {$_api_tag['addon_type']}";
			$s[] = "\t * @api_is_menu {$_api_tag['is_menu']}";
			$s[] = "\t * @api_is_maker {$_api_tag['is_maker']}";
			$s[] = "\t * @api_is_show {$_api_tag['is_show']}";
			$s[] = "\t * @api_is_def_name " . ($_is_def_name ? 1 : 0);
			$s[] = "\t * @api_url {$_api_tag['url']}";
			
			//$s[] = "\t */";
			
			$result[$k] = join(PHP_EOL, $s);
		}
		
		return $result;
	}
}