<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\model;


class CategoryDetail extends \app\app\yss\Yss\common\model\table\CategoryDetail {

    public function afterDelById($id, &$result = [])
    {
        $categoryDetailModel = new CategoryDetail();
        $_w = [];
        $_w[] = ['pid', '=', $id];
        $re = $categoryDetailModel->delByWhere($_w);
        if (isErr($re)) {
            $result = $this->return_error();
            return false;
        }
        return parent::afterDelById($id, $result);
    }
}
