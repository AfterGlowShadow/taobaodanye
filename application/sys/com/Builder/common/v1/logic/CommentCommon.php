<?php


namespace app\sys\com\builder\common\v1\logic;


use app\sys\com\Rbac\common\model\Rule;
use think\helper\Str;

class CommentCommon extends Base {
	protected static $_instance = null;
	
	public static $_ADMIN_ROOT_NODE_ID = 200;
	
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
		//$_field_list = $param['field_list'];
		
		// 路径
		// $_path = $param['path'];
		// $_path_extends = $param['path_extends'];
		$_model_path = $param['_model_path'];
		// 命名空间
		$_namespace = $param['namespace'];
		$_namespace_extends = $param['namespace_extends'];
		
		$_model_namespace = str_replace('/', '\\', $_model_path);
		
		$var['Namespace'] = $_namespace;
		$var['NamespaceExtends'] = $_namespace_extends;
		$var['ModelNamespace'] = $_model_namespace . '\\' . $_module_infos['Model'];
		
		// 应用类型
		// $var['appType'] = $param['_appType'];
		// $var['appTypeDir'] = $var['appType'] == 'mp' ? 'addons' : $var['appType'];
		$var['appTypeDir'] = 'app';
		$var['appTag'] = $param['appTag'];
			// switch ($var['appType']) {
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
		
		$var['maker_tag'] = $_namespace_extends . '\\' . $var['ClassName'];
		
		$result = $this->makeComment($text, $var, $param);
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
	public function allTable2VarValue($text, &$var, &$param) {
		/** @var TableCommon $tableCommon */
		$tableCommon = TableCommon::getInstance();
		$re = $tableCommon->getTableList();
		if (isErr($re)) {
			return false;
		}
		
		$_tables = gData($re);
		
		$_namespace = str_replace('/', '\\', $param['path']);
		$_namespace_extends = str_replace('/', '\\', $param['path_extends']);
		
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
			
			
			// 查找model是否存在 如果存在就优先加载model 不存在才加载table
			$_model_table_file = app()->getRootPath() . $param['model_table_path'] . DIRECTORY_SEPARATOR .
			                     $_module_infos['Model'] . '.php';
			$_model_file = app()->getRootPath() . $param['model_path'] . DIRECTORY_SEPARATOR .
			               $_module_infos['Model'] . '.php';
			$param['model_exist'] = file_exists($_model_file);
			$param['_model_path'] = $param['model_exist'] ? $param['model_path'] : $param['model_table_path'];
			
			$re = $this->setVarValue($text, $var, $param);
			if (isOk($re) && isset($param['onCallBack']) && $param['onCallBack'] instanceof \Closure) {
				$reData = gData($re);
				call_user_func_array($param['onCallBack'], [$reData, $text, $var, $param]);
			}
		}
		
		return true;
	}
	
	public function makeComment($text, &$var, $param) {
		$result = [
			'templete' => [
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
				'is_def_name' => 1,
				'tag' => '',
				'remark' => '',
			],
			'class' => [
			
			],
			'func' => [
				// 数组
			]
		];
		
		// 解析拆分的组件化相关
		//$_module_infos = $param['module_infos'];
		
		$class = '\\' . $var['NamespaceExtends'] . '\\' . $var['ClassName'];
		
		try {
			$reClass = new \ReflectionClass($class);
			
			// Class注解解析
			$_comment = $reClass->getDocComment();
			if ($_comment !== false) {
				$_class_comment = parseApiComment($_comment, '@api_');
				$_class_arr = $_class_comment['vars'];
				
				if (!empty($_class_arr)) {
					$result['class'] = $result['templete'];
					
					foreach ($_class_arr as $k => $v) {
						$result['class'][$k] = $v;
					}
				}
				
				$result['class']['tag'] = $var['maker_tag'];
			}
			
			// Func方法注解解析
			if (!empty($result['class'])) {
				$mc = $reClass->getMethods();
				foreach ($mc as $item) {
					if ($item->isPublic()) {
						$_comment = $item->getDocComment();
						if ($_comment !== false) {
							$_func_comment = parseApiComment($_comment, '@api_');
							$_func_arr     = $_func_comment['vars'];
							
							if (!empty($_func_arr)) {
								$tmp = $result['templete'];
								
								foreach ($_func_arr as $k => $v) {
									$tmp[$k] = $v;
								}
								
								$tmp['tag'] = $var['maker_tag'] . '@' . $item->getName();
								
								$result['func'][] = $tmp;
							}
						}
					}
				}
			}
			
			!isset($var['comment_result']) && $var['comment_result'] = [];
			$var['comment_result'][] = $result;
			
			return rsData($result);
		} catch (\ReflectionException $e) {
			$this->error = empty($e->getMessage()) ? '反射失败 ' . $e->getMessage() : $e->getMessage();
			return $this->return_error();
		}
	}
	
	public function makeDb($text, &$var, $param) {
		if (empty($var['comment_result'])) {
			return rsErr('注解解析为空', 10010);
		}
		
		$comment_result = $var['comment_result'];
		
		$ruleModel = new Rule();
		
		// 清空旧的规则（由生成器生成的规则）
		$re = $this->makeDb_clear_maker($ruleModel);
		if (isErr($re)) {
			return rsErr('清空旧规则失败', 10010);
		}
		
		// 创建后台父节点
		$re = $this->makeDb_admin_root_node([], $var, $param, $ruleModel);
		if (isErr($re)) {
			return rsErr('创建后台父节点失败', 10010);
		}
		
		$_inc_id = 1000;
		// $_comment_arr = [];
		foreach ($comment_result as $item) {
			if (empty($item['class']) || empty($item['class']['name'])) {
				continue;
			}
			
			if (!isset($item['class']['type']) || !in_array($item['class']['type'], [2])) {
				continue;
			}
			
			if (!isset($item['class']['is_def_name']) || $item['class']['is_def_name'] == 1 ) {
				continue;
			}
			
			// if (!isset($item['class']['is_show']) || $item['class']['is_show'] == 0 ) {
			// 	continue;
			// }
			
			if (isset($item['class']['is_rule_db']) && $item['class']['is_rule_db'] == 0 ) {
				continue;
			}
			
			$_class = $item['class'];
			
			$title = !empty($_class['title']) ? $_class['title'] : $_class['name'];
			
			$item['class']['title'] = $title;
			// $item['title_list'] = explode('|', $title);
			
			// !isset($_comment_arr[$title]) && $_comment_arr[$title] = [];
			// $_comment_arr[$title][] = $item;
			
			$item['class']['id'] = $_inc_id;
			$item['class']['pid'] = self::$_ADMIN_ROOT_NODE_ID;
			
			// 添加class的数据
			$re = $this->makeDb_class($item['class'], $var, $param, $ruleModel);
			if (isErr($re)) {
				continue;
			}
			
			//$_func = $item['func'];
			foreach ($item['func'] as $func_key => $func_value) {
				$title = !empty($item['func'][$func_key]['title']) ? $item['func'][$func_key]['title'] : $item['func'][$func_key]['name'];
				
				$item['func'][$func_key]['title'] = $title;
			}
			
			// 添加func的数据
			$re = $this->makeDb_Func($item['class'], $item['func'], $var, $param, $ruleModel);
			if (isErr($re)) {
				continue;
			}
			
			$_inc_id += 100;
		}
		
		return rsOk();
	}
	
	/**
	 * 清空由生成器生成的规则项
	 */
	public function makeDb_clear_maker($ruleModel) {
		/** @var Rule $ruleModel */
		
		$where = [];
		$where['is_maker'] = 1;
		$re = $ruleModel->where($where)->delete(true);
		if ($re === false) {
			return rsErr($ruleModel->getError());
		}
		
		return rsOk();
	}
	
	/**
	 * 构建后台父节点
	 * @param $comment
	 * @param $var
	 * @param $param
	 * @param $ruleModel
	 * @return array
	 */
	public function makeDb_admin_root_node($comment, $var, $param, $ruleModel) {
		/** @var Rule $ruleModel */
		
		$id = self::$_ADMIN_ROOT_NODE_ID;
		$re = $ruleModel->getItemById($id);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		
		$_dt = [];
		$_dt['id'] = $id;
		$_dt['pid'] = 0;
		$_dt['name'] = '后台系统管理';
		$_dt['title'] = '后台系统管理';
		$_dt['icon'] = '';
		$_dt['intro'] = '后台系统管理';
		$_dt['url'] = '';
		$_dt['type'] = 2;
		$_dt['is_auth'] = 0;
		$_dt['is_menu'] = 1;
		$_dt['is_api'] = 1;
		$_dt['is_show'] = 1;
		$_dt['is_maker'] = 1;
		$_dt['status'] = 1;
		$_dt['sort'] = 0;
		$_dt['remark'] = '';
		
		$_d = $_dt;
		
		if (empty($reData)) {
			// 不存在新增
			$re = $ruleModel->add($_d);
		} else {
			// 存在修改
			$re = $ruleModel->editById($id, $_d);
		}
		
		return $re;
	}
	
	public function makeDb_class($comment, $var, $param, $ruleModel) {
		/** @var Rule $ruleModel */
		
		if (!isset($comment['title'])) { // title_list
			return rsErr('注解为空', 10010);
		}
		
		if (!isset($comment['type']) || !in_array($comment['type'], [2])) {
			return rsErr('不是后台接口');
		}
		
		if (!isset($comment['is_def_name']) || $comment['is_def_name'] == 1 ) {
			return rsOk();
		}
		
		if (isset($comment['is_rule_db']) && $comment['is_rule_db'] == 0 ) {
			return rsOk();
		}
		
		// $title_list = $comment['title_list'];
		//$ruleModel = new Rule();
		
		$_dt = [];
		$_dt['id'] = $comment['id'];
		$_dt['pid'] = $comment['pid'];
		$_dt['name'] = $comment['name'];
		$_dt['title'] = $comment['title'];
		$_dt['icon'] = isset($comment['icon']) ? $comment['icon'] : '';
		$_dt['intro'] = isset($comment['intro']) ? $comment['intro'] : '';
		$_dt['url'] = isset($comment['url']) ? $comment['url'] : '';
		$_dt['type'] = isset($comment['type']) ? $comment['type'] : 2;
		$_dt['is_auth'] = isset($comment['is_auth']) ? $comment['is_auth'] : 0;
		$_dt['is_menu'] = isset($comment['is_menu']) ? $comment['is_menu'] : 0;
		$_dt['is_api'] = isset($comment['is_api']) ? $comment['is_api'] : 0;
		$_dt['is_show'] = isset($comment['is_show']) ? $comment['is_show'] : 0;
		$_dt['is_maker'] = isset($comment['is_maker']) ? $comment['is_maker'] : 1;
		$_dt['status'] = isset($comment['status']) ? $comment['status'] : 1;
		$_dt['sort'] = isset($comment['sort']) ? $comment['sort'] : 0;
		$_dt['remark'] = isset($comment['remark']) ? $comment['remark'] : '';
		
		$_dt['tag'] = isset($comment['tag']) ? $comment['tag'] : '';
		
		$_w = [];
		$_d = $_dt;
		
		// switch ($param['appType']) {
		// 	case 'mp':
		// 		$_d['mpid'] = $param['mid'];
		// 		$_w[] = ['mpid', '=', $param['mid']];
		// 		break;
		// 	case 'miniapp':
		// 		$_d['maid'] = $param['mid'];
		// 		$_w[] = ['maid', '=', $param['mid']];
		// 		break;
		// }
		
		$_w[] = ['tag', '=', $comment['tag']];
		
		$re = $ruleModel->getItem($_w);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		$_class_id = 0;
		if (empty($reData)) {
			// 不存在新增
			$re = $ruleModel->add($_d);
			if (isErr($re)) {
				return $re;
			}
			
			$reAdd = gData($re);
			$_class_id = $reAdd['id'];
		} else {
			// 存在修改
			$_class_id = $reData['id'];
			$re = $ruleModel->editById($_class_id, $_d);
			if (isErr($re)) {
				return $re;
			}
		}
		
		return rsOk();
	}
	
	/**
	 * 构建Func
	 * @param $comment_class
	 * @param $comment_func
	 * @param $var
	 * @param $param
	 * @param $ruleModel
	 * @return array
	 */
	public function makeDb_Func($comment_class, $comment_func, $var, $param, $ruleModel) {
		/** @var Rule $ruleModel */
		
		$class_id = $comment_class['id'];
		
		$_id = $class_id;
		foreach ($comment_func as $item) {
			$_id++;
			
			if (!isset($item['title'])) {
				continue;
			}
			
			if (!isset($item['type']) || !in_array($item['type'], [2])) {
				continue;
			}
			
			if (!isset($item['is_def_name']) || $item['is_def_name'] == 1 ) {
				continue;
			}
			
			if (isset($item['is_rule_db']) && $item['is_rule_db'] == 0 ) {
				continue;
			}
			
			// $title_list = $comment['title_list'];
			//$ruleModel = new Rule();
			
			$_dt = [];
			$_dt['id'] = $_id;
			$_dt['pid'] = $class_id;
			$_dt['name'] = $item['name'];
			$_dt['title'] = $item['title'];
			$_dt['icon'] = isset($item['icon']) ? $item['icon'] : '';
			$_dt['intro'] = isset($item['intro']) ? $item['intro'] : '';
			$_dt['url'] = isset($item['url']) ? $item['url'] : '';
			$_dt['type'] = isset($item['type']) ? $item['type'] : 2;
			$_dt['is_auth'] = isset($item['is_auth']) ? $item['is_auth'] : 0;
			$_dt['is_menu'] = isset($item['is_menu']) ? $item['is_menu'] : 0;
			$_dt['is_api'] = isset($item['is_api']) ? $item['is_api'] : 0;
			$_dt['is_show'] = isset($item['is_show']) ? $item['is_show'] : 0;
			$_dt['is_maker'] = isset($item['is_maker']) ? $item['is_maker'] : 1;
			$_dt['status'] = isset($item['status']) ? $item['status'] : 1;
			$_dt['sort'] = isset($item['sort']) ? $item['sort'] : 0;
			$_dt['remark'] = isset($item['remark']) ? $item['remark'] : '';
			
			$_dt['tag'] = isset($item['tag']) ? $item['tag'] : '';
			
			$_w = [];
			$_d = $_dt;
			
			// switch ($param['appType']) {
			// 	case 'mp':
			// 		$_d['mpid'] = $param['mid'];
			// 		$_w[] = ['mpid', '=', $param['mid']];
			// 		break;
			// 	case 'miniapp':
			// 		$_d['maid'] = $param['mid'];
			// 		$_w[] = ['maid', '=', $param['mid']];
			// 		break;
			// }
			
			$_w[] = ['tag', '=', $item['tag']];
			
			$re = $ruleModel->getItem($_w);
			if (isErr($re)) {
				return $re;
			}
			
			$reData = gData($re);
			$_func_id = 0;
			if (empty($reData)) {
				// 不存在新增
				$re = $ruleModel->add($_d);
				if (isErr($re)) {
					return $re;
				}
				
				$reAdd = gData($re);
				$_func_id = $reAdd['id'];
			} else {
				// 存在修改
				$_func_id = $reData['id'];
				$re = $ruleModel->editById($_func_id, $_d);
				if (isErr($re)) {
					return $re;
				}
			}
		}
		
		return rsOk();
	}
	
}