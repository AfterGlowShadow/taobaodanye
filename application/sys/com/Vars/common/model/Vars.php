<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Vars\common\model;


class Vars extends \app\sys\com\Vars\common\model\table\Vars {
	
	public function getItemByVar($var) {
		$_where = [];
		$_where[] = ['var', '=', $var];
		
		$re = $this->getDataItem($_where);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		if (empty($reData)) {
			return rsErr('数据为空', 10010);
		}
		
		return rsData($reData);
	}
	
	public function setItemByVar($var, $param) {
		$_where = [];
		$_where[] = ['var', '=', $var];
		
		$re = $this->getDataItem($_where);
		if (isErr($re)) {
			return $re;
		}
		
		$reData = gData($re);
		if (empty($reData)) {
			$re = $this->add($param);
		} else {
			$re = $this->editByWhere($_where, $param);
			if (isErr($re)) {
				return $re;
			}
		}
		
		return rsData($re);
	}

}
