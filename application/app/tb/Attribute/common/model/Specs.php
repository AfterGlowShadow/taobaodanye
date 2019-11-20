<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\common\model;


class Specs extends \app\app\tb\Attribute\common\model\table\Specs {




    /**
     * 批量添加
     * 商品规格
     * @api_name 批量添加 商品规格
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url
     *
     * array
     * name
     * id
     * @return \think\response\Json
     * @throws \Throwable
     * @throws \think\Exception\DbException
     */
    public function BulkAdd($array,$name,$id) {
        return parent::BulkAdd($array,$name,$id);
    }
}
