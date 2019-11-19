<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/16
 * Time: 15:30
 */

namespace app\app\yss\Yss\common\service;

use app\app\yss\Yss\common\model\CategoryDetail;
use app\app\yss\Yss\common\model\Finance;
use app\app\yss\Yss\common\model\Industry;
use app\app\yss\Yss\common\model\Yss;

class SearchKeyword
{
    public function getList($param)
    {
        $returnObj = [];
        $yssModel = new Yss();

        $page_num = isset($param['page_num']) ? $param['page_num'] : 1;
        $page_limit = isset($param['page_limit']) ? $param['page_limit'] : PHP_INT_MAX;
        $_where = [];
        $_where[] = ['status', '=', 2];
        if (isset($param['keywprds']) && !empty($param['keywprds'])) {
            $_where[] = ["industry_second_name|company_type_name|company_name", 'like', '%' . $param['keywprds'] . '%'];
        }
        $_field = "id,user_id,company_type_name,company_name,sell_price,registered_capital,pay_taxes,establishment,publish_time,industry_name,registered_capital,industry_second_name,declare_tax";
        $re = $yssModel->getList($_where, [], $page_num, $page_limit, $_field);
        if (!is_return_ok($re)) {
            return return_json($re);
        }
        $returnObj['yssData'] = get_return_data($re);
        $categoryModel = new CategoryDetail();
        $_param = ['func' => function ($m) {
            return $m->group('a.id');
        },"count_field"=>'id'];
        $_where2 = [];
        $_where2[] = ['id', 'in', [39, 14, 15]];
        $_join = [['wp_app_yss_category_detail b', 'a.id=b.pid and b.name like "%' . $param['keywprds'] . '%"'],['wp_app_yss_industry f', 'f.cat_second_id=b.id']];
        $_fields = "a.id as id,a.name as name,b.id as bid,f.price,f.title_desc";
        $res = $categoryModel->getList($_where2, [], $page_num, $page_limit, $_fields, false, $_join, $_param);
        if (!is_return_ok($res)) {
            return return_json($res);
        }
        $reData = get_return_data($res);
        foreach ($reData as $v){
//            $categoryModel->getItemById($v['']);
        }
        return rjData($reData);
//        $returnObj['yssData'] = get_return_data($re);
//        $financesModel = new Finance();
//
//
//
//        39,14,15
//        $page_num = isset($param['page_num']) ? $param['page_num'] : 1;
//        $page_limit = isset($param['page_limit']) ? $param['page_limit'] : PHP_INT_MAX;
//
//        $cat_id = isset($param['cat_id']) ? $param['cat_id'] : 0;
//        $cat_second_id = isset($param['cat_second_id']) ? $param['cat_second_id'] : 0;
//        $title = isset($param['title']) ? $param['title'] : '';
//        $title_desc = isset($param['title_desc']) ? $param['title_desc'] : '';
//        $shop_price = isset($param['shop_price']) ? $param['shop_price'] : 0;
//        $price = isset($param['price']) ? $param['price'] : 0;
//        $service_type = isset($param['service_type']) ? $param['service_type'] : 0;
//        $service_name = isset($param['service_name']) ? $param['service_name'] : '';
//        $meal_name = isset($param['meal_name']) ? $param['meal_name'] : '';
//        $meal_ids = isset($param['meal_ids']) ? $param['meal_ids'] : 0;
//        $company_type = isset($param['company_type']) ? $param['company_type'] : 0;
//        $company_name = isset($param['company_name']) ? $param['company_name'] : '';
//        $address = isset($param['address']) ? $param['address'] : '';
//        $delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
//        $view_num = isset($param['view_num']) ? $param['view_num'] : 0;
//        $collection_num = isset($param['collection_num']) ? $param['collection_num'] : 0;
//
//        /** @var $m Industry */
//        $m = $this->_model;
//        $_where = [];
//        isset($param['cat_id']) && $_where[] = ['cat_id', '=', $cat_id];
//        isset($param['cat_second_id']) && $_where[] = ['cat_second_id', '=', $cat_second_id];
//        isset($param['title']) && $_where[] = ['title', '=', $title];
//        isset($param['title_desc']) && $_where[] = ['title_desc', '=', $title_desc];
//        isset($param['shop_price']) && $_where[] = ['shop_price', '=', $shop_price];
//        isset($param['price']) && $_where[] = ['price', '=', $price];
//        isset($param['service_type']) && $_where[] = ['service_type', '=', $service_type];
//        isset($param['service_name']) && $_where[] = ['service_name', '=', $service_name];
//        isset($param['meal_name']) && $_where[] = ['meal_name', '=', $meal_name];
//        isset($param['meal_ids']) && $_where[] = ['meal_ids', '=', $meal_ids];
//        isset($param['company_type']) && $_where[] = ['company_type', '=', $company_type];
//        isset($param['company_name']) && $_where[] = ['company_name', '=', $company_name];
//        isset($param['address']) && $_where[] = ['address', '=', $address];
//        isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
//        isset($param['view_num']) && $_where[] = ['view_num', '=', $view_num];
//        isset($param['collection_num']) && $_where[] = ['collection_num', '=', $collection_num];
//
//        $_order = ['create_time' => 'DESC'];
//
//        $_field = isset($this->_buf['getList']['field']) ? $this->_buf['getList']['field'] : '*';
//        $_link = isset($this->_buf['getList']['link']) ? $this->_buf['getList']['link'] : false;
//        $_join = isset($this->_buf['getList']['join']) ? $this->_buf['getList']['join'] : [];
//        $_where = isset($this->_buf['getList']['where']) ? array_merge($_where, $this->_buf['getList']['where']) : $_where;
//        $_order = isset($this->_buf['getList']['order']) ? $this->_buf['getList']['order'] : $_order;
//        $_param = isset($this->_buf['getList']['param']) ? $this->_buf['getList']['param'] : [];
//        $re = $m->getList($_where, $_order, $page_num, $page_limit, $_field, $_link, $_join, $_param);
//        if (!is_return_ok($re)) {
//            return return_json($re);
//        }
//
//        $reData = get_return_data($re);
//        return rjData($reData);
//
//
//        $industryModel = new Industry();
//        $param = $param;
//
//        $page_num = isset($param['page_num']) ? $param['page_num'] : 1;
//        $page_limit = isset($param['page_limit']) ? $param['page_limit'] : PHP_INT_MAX;
//
//        $title = isset($param['title']) ? $param['title'] : '';
//        $title_desc = isset($param['title_desc']) ? $param['title_desc'] : '';
//        $shop_price = isset($param['shop_price']) ? $param['shop_price'] : 0;
//        $price = isset($param['price']) ? $param['price'] : 0;
//        $view_num = isset($param['view_num']) ? $param['view_num'] : 0;
//        $celection_num = isset($param['celection_num']) ? $param['celection_num'] : 0;
//        $service_type = isset($param['service_type']) ? $param['service_type'] : 0;
//        $service_name = isset($param['service_name']) ? $param['service_name'] : '';
//        $address = isset($param['address']) ? $param['address'] : '';
//        $delete_time = isset($param['delete_time']) ? $param['delete_time'] : 0;
//
//        /** @var $m Finance */
//        $m = $this->_model;
//        $_where = [];
//        isset($param['title']) && $_where[] = ['title', '=', $title];
//        isset($param['title_desc']) && $_where[] = ['title_desc', '=', $title_desc];
//        isset($param['shop_price']) && $_where[] = ['shop_price', '=', $shop_price];
//        isset($param['price']) && $_where[] = ['price', '=', $price];
//        isset($param['view_num']) && $_where[] = ['view_num', '=', $view_num];
//        isset($param['celection_num']) && $_where[] = ['celection_num', '=', $celection_num];
//        isset($param['service_type']) && $_where[] = ['service_type', '=', $service_type];
//        isset($param['service_name']) && $_where[] = ['service_name', '=', $service_name];
//        isset($param['address']) && $_where[] = ['address', '=', $address];
//        isset($param['delete_time']) && $_where[] = ['delete_time', '=', $delete_time];
//
//        $_order = ['create_time' => 'DESC'];
//
//        $_field = isset($this->_buf['getList']['field']) ? $this->_buf['getList']['field'] : '*';
//        $_link = isset($this->_buf['getList']['link']) ? $this->_buf['getList']['link'] : false;
//        $_join = isset($this->_buf['getList']['join']) ? $this->_buf['getList']['join'] : [];
//        $_where = isset($this->_buf['getList']['where']) ? array_merge($_where, $this->_buf['getList']['where']) : $_where;
//        $_order = isset($this->_buf['getList']['order']) ? $this->_buf['getList']['order'] : $_order;
//        $_param = isset($this->_buf['getList']['param']) ? $this->_buf['getList']['param'] : [];
//        $re = $m->getList($_where, $_order, $page_num, $page_limit, $_field, $_link, $_join, $_param);
//        if (!is_return_ok($re)) {
//            return return_json($re);
//        }
//
//        $reData = get_return_data($re);
//        return rjData($reData);
    }
}