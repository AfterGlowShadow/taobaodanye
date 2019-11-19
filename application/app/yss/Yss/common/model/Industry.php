<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\common\model;


class Industry extends \app\app\yss\Yss\common\model\table\Industry
{


    /**
     * 关联用户表
     * @return \think\model\relation\hasMany
     */
    public function hYssAttribute()
    {

        return $this
            ->hasMany('app\app\yss\Yss\common\model\Attribute', 'id', 'ind_id');
    }

    /**
     * 根据二级分类id搜索所有价格列表
     */
    public function getDetailById($id)
    {
        $_where = [];
        $_where[] = ['a.cat_id','=',$id];
        $industryModel = new Industry();
        $res = $industryModel->alias('a')->join('wp_app_yss_attribute b', 'a.id=b.ind_id')->select();
        if ($res === false) {
            return rsErr('查询失败，请重试', 11010);
        }
        return rsData($res);
    }
}
