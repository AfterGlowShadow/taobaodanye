<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\model;


class Yss extends \app\app\yss\Yss\common\model\table\Yss {


    /**
     * 关联用户表
     * @return \think\model\relation\belongsTo
     */
    public function hUser() {

        return $this
            ->belongsTo('app\sys\com\Rbac\common\model\User', 'uid', 'id')
            ->selfRelation(true);
    }



}
