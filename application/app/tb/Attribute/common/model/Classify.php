<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\common\model;


class Classify extends \app\app\tb\Attribute\common\model\table\Classify {


    /**
     * 获取详情 通过id查询
     * 商品分类
     * @api_name 获取分类详情
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Attribute.v1.Classifys.getItemById
     *
     * id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getItemByIdM($id, $_field, $_link, $_join, $_param)
    {
        $re = $this->getItemById($id, $_field, $_link, $_join, $_param);
        if (!is_return_ok($re)) {
            return return_json($re);
        }else{
            $specsM=new Specs();
            $where[]=['classifyid',"=",$re['result']['id']];
            $specs=$specsM->where($where)->select()->toArray();
            if($specs){
                $re['specs']=$specs;
            }
            return $re;
        }
    }

}
