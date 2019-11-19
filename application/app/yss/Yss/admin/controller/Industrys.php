<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\yss\Yss\admin\controller;

use app\app\yss\Yss\common\model\Attribute;
use app\app\yss\Yss\common\model\Industry;
use think\Db;

/**
 * Class Industrys
 * 工商服务表
 * @api_name 工商服务
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\yss\Yss\admin\controller
 */
class Industrys extends \app\app\yss\Yss\admin\controller\logic\Industrys
{

    public function init_before()
    {
        parent::init_before();


    }

    /**
     * 添加
     * 工商服务表
     * @api_name 添加工商服务
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Yss.v1.Industrys.add
     *
     * title                标题
     * title_desc            标题描述
     * shop_price            市场价
     * price                价格
     * service_type            服务行业
     * service_name            服务行业名
     * meal_name            套餐名称
     * meal_ids                服务套餐
     * company_type            企业类型
     * company_name            企业类型名
     * address                地区
     * view_num                浏览量
     * collection_num        收藏量
     * @return mixed|string
     */
    public function add()
    {
        $this->param['view_num'] = 0;
        $this->param['collection_num'] = 0;
        $res = parent::add();
        $resData = $res->getData();
        if ($resData['code'] !== 200) {
            return $res;
        }
        $res_id = $resData['result']['id'];  //新增的id
        $attr_id_arr = [];
        $attributeModel = new Attribute();
        $createArr = [];
        $createArr['ind_id'] = $res_id;
        if ($this->param['type'] == 1) { //工商服务
            $attr_id_arr[] = $this->param['company_type'];  //企业类型
            $attr_id_arr[] = $this->param['address_id'];  //地区
            if (isset($this->param['attribute_info']) && !empty($this->param['attribute_info'])) {
                $attributeArr = json_decode($this->param['attribute_info'],true);
                foreach ($attributeArr as $k => $v) {
                    $tempArr = [];
                    $tempArr[] = $attr_id_arr[0];
                    $tempArr[] = $attr_id_arr[1];
                    $tempArr[] = $v['attr_ids'];

                    $createArr['cat_ids'] = implode('-', $tempArr);
                    $createArr['cat_price'] = $v['attr_price'];
                    $re = $attributeModel->add($createArr);
                    if (!is_return_ok($re)) {
                        return return_json($re);
                    }
                }
            } else {
                $attr_id_arr[] = $this->param['service_type'];  //服务行业
                $attr_id_arr[] = $this->param['meal_ids'];  //套餐
                $createArr['cat_ids'] = implode('-', $attr_id_arr);
                $re = $attributeModel->add($createArr);
                if (!is_return_ok($re)) {
                    return return_json($re);
                }
            }
        } elseif ($this->param['type'] == 2) { //财税
            $attr_id_arr[] = $this->param['service_type'];  //服务类型
            $attr_id_arr[] = $this->param['address_id'];  //地区
            $createArr['cat_ids'] = implode('-', $attr_id_arr);
            $re = $attributeModel->add($createArr);
            if (!is_return_ok($re)) {
                return return_json($re);
            }
        }
        return $res;
    }

    /**
     * 获取列表
     * 工商服务表
     * @api_name 获取工商服务列表
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Yss.v1.Industrys.getList
     *
     * page_num
     * page_limit
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getList()
    {
        $param = $this->param;
        $where = [];
        if (isset($param['keywords'])) {
            $keywords = $param['keywords'];
            $where[] = ['title', 'like', "%{$keywords}%"];
        }
        $this->_buf['getList'] = [
            'where' => $where,
        ];
        return parent::getList();
    }


    /**
     * 更改
     * 工商服务表
     * @api_name 更改工商服务
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Yss.v1.Industrys.edit
     *
     * id
     * cat_id				所属分类id
     * cat_second_id		二级id
     * title				标题
     * title_desc			标题描述
     * shop_price			市场价
     * price				价格
     * service_type			服务行业
     * service_name			服务行业名
     * type					1工商服务 2财税服务
     * view_num				浏览量
     * collection_num		收藏量
     * address_id			地区id
     * address				地区
     * meal_name			套餐名称
     * meal_ids				服务套餐
     * company_type			企业类型
     * company_name			企业类型名
     * attribute_info		属性加价
     * @return mixed|string
     */
    public function edit() {
        $res = parent::edit();
        $resData = $res->getData();
        if ($resData['code'] !== 200) {
            return $res;
        }
        $res_id = $this->param['id'];  //新增的id
        $attributeModel = new Attribute();

        $_wh = [];
        $_wh[] = ['ind_id','=',$res_id];
        $attributeModel->where($_wh)->delete(true);
        $attr_id_arr = [];
        $createArr = [];
        $createArr['ind_id'] = $res_id;
        if ($this->param['type'] == 1) { //工商服务
            $attr_id_arr[] = $this->param['company_type'];  //企业类型
            $attr_id_arr[] = $this->param['address_id'];  //地区
            if (isset($this->param['attribute_info']) && !empty($this->param['attribute_info'])) {
                $attributeArr = json_decode($this->param['attribute_info'],true);
                foreach ($attributeArr as $k => $v) {
                    $tempArr = [];
                    $tempArr[] = $attr_id_arr[0];
                    $tempArr[] = $attr_id_arr[1];
                    $tempArr[] = $v['attr_ids'];

                    $createArr['cat_ids'] = implode('-', $tempArr);
                    $createArr['cat_price'] = $v['attr_price'];
                    $re = $attributeModel->add($createArr);
                    if (!is_return_ok($re)) {
                        return return_json($re);
                    }
                }
            } else {
                $attr_id_arr[] = $this->param['service_type'];  //服务行业
                $attr_id_arr[] = $this->param['meal_ids'];  //套餐
                $createArr['cat_ids'] = implode('-', $attr_id_arr);
                $re = $attributeModel->add($createArr);
                if (!is_return_ok($re)) {
                    return return_json($re);
                }
            }
        } elseif ($this->param['type'] == 2) { //财税
            $attr_id_arr[] = $this->param['service_type'];  //服务类型
            $attr_id_arr[] = $this->param['address_id'];  //地区
            $createArr['cat_ids'] = implode('-', $attr_id_arr);
            $re = $attributeModel->add($createArr);
            if (!is_return_ok($re)) {
                return return_json($re);
            }
        }
        return $res;
    }
}
