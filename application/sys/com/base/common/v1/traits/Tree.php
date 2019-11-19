<?php


namespace app\sys\com\base\common\v1\traits;


trait Tree {
	
	/**
	 * 构建树
	 * @param array  $where
	 * @param array  $order
	 * @param int    $page
	 * @param int    $limit
	 * @param string $field
	 * @param bool   $link
	 * @param array  $join
	 * @param array  $param
	 * @param int    $pid
	 * @param int    $level
	 * @param array  $path_id
	 * @param array  $field_set
	 * @return array|mixed|void
	 * @throws \think\Exception
	 */
	public function getTree($where = [], $order = [], $page = 1, $limit = PHP_INT_MAX, $field = '*', $link = false, $join = [], $param = [], $pid = 0, $level = 0, $path_id = [], $field_set = []) {
		$fp = $this->field_prefix;
		$_pid_field = !empty($field_set['pid']) ? $field_set['pid'] : $fp . 'pid';
		// $_id_field = !empty($field_set['id']) ? $field_set['id'] : $fp . 'id';
		// $_children_field = !empty($field_set['children']) ? $field_set['children'] : 'children';
		
		// 1、获取根节点列表 分页
		$_where = [];
		$_where[] = [$_pid_field, '=', $pid];
		$_where = array_merge($_where, $where);
		$reList = $this->getList($_where, $order, $page, $limit, $field, $link, $join, $param);
		if (!is_return_ok($reList)) {
			return $reList;
		}
		
		$reDataRoot = get_return_data($reList);
		$totalRoot = $reDataRoot['total'];
		$rowsRoot = $reDataRoot['data'];
		
		// 2、获取子节点列表 不分页
		$_where = [];
		$_where[] = [$_pid_field, '<>', $pid];
		$_where = array_merge($_where, $where);
		$_order = ['create_time' => 'ASC'];
		$reList = $this->getList($_where, $_order, 1, PHP_INT_MAX, $field, $link, $join, $param);
		if (!is_return_ok($reList)) {
			return $reList;
		}
		
		$reDataLerf = get_return_data($reList);
		$rowsLerf = $reDataLerf['data'];
		
		// 3、拼接父子节点
		$rows = $rowsRoot;
		$rows = array_merge($rows, $rowsLerf);
		
		// 4、构建树
		$list = [];
		$this->build_tree($list, $pid, $rows, $level, $path_id, $field_set);
		
		$result = [
			'total' => $totalRoot,
			'data' => $list,
		];
		
		return return_status_ok_data($result);
	}
	
	
}