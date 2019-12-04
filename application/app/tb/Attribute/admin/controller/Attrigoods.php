<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\app\tb\Attribute\admin\controller;

use app\app\tb\Attribute\common\model\Attrigood;
use app\app\tb\Tb\admin\controller\Goodss;
use app\app\tb\Tb\common\model\Goods;
use think\Db;

/**
 * Class Attrigoods
 * 货物规格中间表(规格没有排列组合的 只为了根据规格添加图片)
 * @api_name 货物规格
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\app\tb\Attribute\admin\controller
 */
class Attrigoods extends \app\app\tb\Attribute\admin\controller\logic\Attrigoods {
    public function init_before() {
        parent::init_before();
    }

    /**
     * 添加
     * 货物规格中间表(规格没有排列组合的 只为了根据规格添加图片)
     * @api_name 添加货物规格
     * @api_type 2
     * @api_is_menu 0
     * @api_is_maker 1
     * @api_is_show 1
     * @api_is_def_name 0
     * @api_url /app/admin/Attribute.v1.Attrigoods.addM
     *
     * attrid            属性id
     * goodid            商品id
     * img                图片
     * specsid            规格id
     * @return mixed|string
     * @throws \think\exception\PDOException
     */
    public function addM() {
        $param=$this->param;
        $param=$this->FormatParam($param);
        if($param){
            $this->startTrans();
            $attrgoodM=new Attrigood();
            $res=$attrgoodM->insertAll($param);
            $goodM=new Goods();
            $where[]=array("goodid",'=',$param['goodid']);
            $data[]=array("specsid",'=',$param['specsid']);
            $res1=$goodM->saveData($data, $where);
            if($res&&$res1){
                $this->commit();
                return rjData($res);
            }else{
                $this->rollback();
                return return_json_err("添加失败",400);
            }
        }else{
            return return_json_err("参数格式有误",400);
        }
    }

    /**
     * 格式param 判断数据格式 有没有img只取出有的
     */
    public function FormatParam($param)
    {
        $back=array();
        if(array_key_exists("goodid",$param)&&$param['goodid']!=""&&array_key_exists("specsid",$param)&&$param['specsid']!=""&&array_key_exists("attr",$param)&&$param['attr']!=""){
            $back['goodid']=$param['goodid'];
            $back['specsid']=$param['specsid'];
            $back['attr']=array();
            foreach ($param['attr'] as $key => $value){
                if(array_key_exists("attrid",$value)&&$value['attrid']!=""&&array_key_exists("img",$value)&&$value['img']!=""){
                    array_push($back['attr'],$value);
                }else{
                    return return_json_err("参数有误",400);
                    exit;
                }
            }
        }else{
            return return_json_err("参数有误",400);
            exit;
        }
        return $back;
    }
}
