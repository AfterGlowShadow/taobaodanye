<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Tb\admin\controller;

use app\app\tb\Tb\common\model\Model;
use think\Db;

/**
 * Class Models
 * 宣传页模型
 * @api_name 宣传页模板
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Tb\admin\controller
 */
class Models extends \app\app\tb\Tb\admin\controller\logic\Models {

    public function init_before() {
        parent::init_before();


    }

    /**
     * 添加
     * 宣传页模型
     * @api_name 添加宣传页模板
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Models.addModel
     *
     * name
     * url
     * @return mixed|string
     */
    public function addModel(){
        $param=$this->param;
        if(array_key_exists("name",$param)&&$param['name']!=""&&array_key_exists("url",$param)&&$param['url']!=""){
            $swhere['name']=$param['name'];
            $swhere['url']=$param['url'];
            $swhere['delete_time']=0;
            $ModelsM=new Model();
            $res=$ModelsM->getDataItem($swhere);
            if(empty($res['result'])){
                return $this->add();
            }else{
                return rjData("此模板已经存在,请勿重复添加");
            }
        }else{
            return rjData("缺少参数");
        }
    }
    /**
     * 更改
     * 宣传页模型
     * @api_name 更改宣传页模板
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Tb.v1.Models.editModel
     *
     * id
     * name
     * url
     * @return mixed|string
     */
    public function editModel() {
        $param=$this->param;
        if(array_key_exists("name",$param)&&$param['name']!=""&&array_key_exists("url",$param)&&$param['url']!=""){
            $swhere['name']=$param['name'];
            $swhere['url']=$param['url'];
            $swhere['delete_time']=0;
            $ModelsM=new Model();
            $res=$ModelsM->getDataItem($swhere);
            if(empty($res['result'])){
                return $this->edit();
            }else{
                return rjData("此模板已经存在,请确认后修改");
            }
        }else{
            return rjData("缺少参数");
        }
    }
}
