<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Rbac\common\model;


class Store extends \app\sys\com\Rbac\common\model\table\Store {
	
	
	public function afterDelById($id, &$result = []) {
		$userStoreModel = new UserStore();
		$_w = [];
		$_w[] = ['store_id', '=', $id];
		$re = $userStoreModel->delByWhere($_w);
		if (isErr($re)) {
			$result = $this->return_error();
			return false;
		}
		
		return parent::afterDelById($id, $result);
	}
	
	public function afterDelByWhere($where, &$result = []) {
		// ——查询删除的数据 提取相关信息
		$reData = glData($result);
		if (empty($reData)) {
			return true;
		}
		
		$store_ids = [];
		foreach ($reData as $row) {
			$store_ids[] = $row['id'];
		}
		
		if (!empty($store_ids)) {
			$userStoreModel = new UserStore();
			$_w = [];
			$_w[] = ['store_id', 'IN', $store_ids];
			$re = $userStoreModel->delByWhere($_w);
			if (isErr($re)) {
				$result = $this->return_error();
				return false;
			}
		}
		
		return parent::afterDelByWhere($where, $result);
	}


}
