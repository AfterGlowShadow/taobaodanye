<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Msg\admin\controller;

use app\sys\com\Msg\common\model\Send;
use app\sys\com\Msg\common\model\Text;
use app\sys\com\Msg\event\Event;
use app\sys\com\Queue\common\job\JobFire;
use think\Db;

/**
 * Class Sends
 * 站内消息发送表
 * @api_name 站内消息发送
 * @api_type 2
 * @api_is_menu 0
 * @api_is_maker 1
 * @api_is_show 1
 * @api_is_def_name 0
 * @package app\sys\com\Msg\admin\controller
 */
class Sends extends \app\sys\com\Msg\admin\controller\logic\Sends {

    public function init_before() {
        parent::init_before();


    }
	
	/**
	 * 获取列表
	 * 站内消息发送表
	 * @api_name 获取站内消息发送列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Msg.v1.Sends.getList
	 *
	 * page_num
	 * page_limit
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
    public function getList() {
	    /** @var $m Send */
	    $m = $this->_model;
	    $param = $this->param;
    	
    	$this->_buf['getList'] = [
		    'link' => ['h_text'],
	    ];
	    $re = parent::getList()->getData();
	    $reData = gData($re);
	
	    $value = [];
	    $value['addonParam'] = $this->_addon_param;//$addonParam;
	    $value['sendModel'] = $m;
	    $value['param'] = $param;
	    $value['listdata'] = $reData;
	
	    $re = Event::t('sendMsgListData', $value);
	    if (isErr($re)) {
		    return return_json($re);
	    }
	
	    $reListData = gData($re);
	    
	    $result = isset($reListData['listdata']) ? $reListData['listdata'] : $reData;
	    
	    return rjData($result);
    }
	
	/**
	 * 获取列表
	 * 站内消息发送表
	 * @api_name 获取未读消息列表
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Msg.v1.Sends.getListNotRead
	 *
	 * page_num
	 * page_limit
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getListUnread() {
		/** @var $m Send */
		$m = $this->_model;
		$param = $this->param;
		
		$this->_buf['getList'] = [
			'link' => ['h_text'],
			'where' => [
				['read_flag', '=', Send::$_READ_FLAG['not_read']],
			]
		];
		
		$re = parent::getList()->getData();
		$reData = gData($re);
		
		$value = [];
		$value['addonParam'] = $this->_addon_param;//$addonParam;
		$value['sendModel'] = $m;
		$value['param'] = $param;
		$value['listdata'] = $reData;
		
		$re = Event::t('sendMsgListData', $value);
		if (isErr($re)) {
			return return_json($re);
		}
		
		$reListData = gData($re);
		
		$result = isset($reListData['listdata']) ? $reListData['listdata'] : $reData;
		
		return rjData($result);
	}
	
	/**
	 * 获取详情 通过id查询
	 * 站内消息发送表
	 * @api_name 获取消息详情
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url /sys/admin/Msg.v1.Sends.getItemById
	 *
	 * id
	 * @return \think\response\Json
	 * @throws \think\Exception
	 */
	public function getItemById() {
		/** @var $m Send */
		$m = $this->_model;
		$param = $this->param;
		
		$id = $this->p('id');
		
		// 写已读标记
		$re = $m->setReadFlag($id);
		
		//return parent::getItemById();
		$this->_buf['getItemById'] = [
			'link' => ['h_text'],
		];
		
		$re = parent::getItemById()->getData();
		$reData = gData($re);
		
		$value = [];
		$value['addonParam'] = $this->_addon_param;//$addonParam;
		$value['sendModel'] = $m;
		$value['param'] = $param;
		$value['itemdata'] = $reData;
		
		$re = Event::t('sendMsgItemData', $value);
		if (isErr($re)) {
			return return_json($re);
		}
		
		$reListData = gData($re);
		
		$result = isset($reListData['itemdata']) ? $reListData['itemdata'] : $reData;
		
		return rjData($result);
	}
	
	/**
	 * 添加
	 * 站内消息发送表
	 * @api_name 添加站内消息发送
	 * @api_type 2
	 * @api_is_menu 0
	 * @api_is_maker 1
	 * @api_is_show 0
	 * @api_is_def_name 0
	 * @api_is_rule_db 0
	 * @api_url /sys/admin/Msg.v1.Sends.add
	 *
	 * send_id			发送者id
	 * receiver_id		接收者id
	 * send_param		附件参数 推送相关参数
	 * send_time		发送时间（保留定时发送）
	 * read_flag		已读标志（0-未读 1-已读）
	 * msg_text_id		消息内容id
	 * status			状态（0-等待发送 1-发送中 2-成功 3-失败）
	 * addon_name		应用名称
	 * @return mixed|string
	 */
	public function add() {
		return parent::add();
	}
	
	/**
	 * 发送消息
	 * 站内消息发送表
	 * @api_name        发送消息
	 * @api_type        2
	 * @api_is_menu     0
	 * @api_is_maker    1
	 * @api_is_show     0
	 * @api_is_def_name 0
	 * @api_is_rule_db  0
	 * @api_url         /sys/admin/Msg.v1.Sends.sendMessage
	 *
	 * send_params
	 * title
	 * content
	 * type
	 * status*
	 * remark
	 * addon_name
	 * @param array $param
	 * @return \think\response\Json
	 * @throws \Throwable
	 */
	public function sendMessage($param = []) {
		/** @var $m Send */
		$m = $this->_model;
		$param = !empty($param) ? $param : $this->param;
		
		if (empty($param['send_params'])) {
			return rsErr('发送对象不能为空', 10004);
		}
		
		$re = $this->transaction(function () use ($param) {
			// 先创建消息内容
			$textModel = new Text();
			$_d = [];
			$_d['title'] = $param['title'];
			$_d['content'] = $param['content'];
			$_d['send_param'] = defi($param, 'send_param', '');
			$_d['type'] = defi($param, 'type', Text::$_TYPE['none']);
			$_d['status'] = defi($param, 'status', Text::$_STATUS['wait_send']);
			$_d['remark'] = defi($param, 'remark', '');
			$_d['addon_name'] = defi($param, 'addon_name', '');
			$re = $textModel->add($_d);
			if (isErr($re)) {
				return $re;
			}
			
			$reText = gData($re);
			if (empty($reText)) {
				return rsErr('消息内容创建失败', 10010);
			}
			
			$text_data = $_d;
			$text_id = $reText['id'];
			
			// 再创建发送队列
			$_send_params = $param['send_params'];
			$sendModel = new Send();
			foreach ($_send_params as $item) {
				$_d = [];
				$_d['send_id'] = $item['send_id'];
				$_d['receiver_id'] = $item['receiver_id'];
				$_d['send_param'] = defi($item, 'send_param', '');
				$_d['send_time'] = defi($item, 'send_time', 0);
				$_d['read_flag'] = Send::$_READ_FLAG['not_read'];
				$_d['msg_text_id'] = $text_id;
				$_d['status'] = defi($item, 'status', Send::$_STATUS['send']);
				$_d['addon_name'] = defi($item, 'addon_name', '');
				$re = $sendModel->add($_d);
				if (isErr($re)) {
					return $re;
				}
				
				$reSend = gData($re);
				
				// todo: 队列
				$jobFire = new JobFire();
				$_queue_data = [];
				$_queue_data['taskMode'] = 'task_send_msg';
				$_queue_data['addonParam'] = sessionOrGLOBALS('addonParam');
				$_queue_data['id'] = $reSend['id'];
				// $_queue_data['send'] = $_d;
				// $_queue_data['text'] = $text_data;
				$re = $jobFire->createQueue($_queue_data);
				if (isErr($re)) {
					return $re;
				}
			}
			
			return rsOk();
		});
		
		return return_json($re);
	}
	
	/**
	 * 发送消息
	 * 站内消息发送表
	 * @api_name       发送消息
	 * @api_type       2
	 * @api_is_menu    0
	 * @api_is_maker   1
	 * @api_is_show 1
	 * @api_is_def_name 0
	 * @api_url        /sys/admin/Msg.v1.Sends.send
	 *
	 * isSendAllUser
	 * sendUsers
	 * content
	 * type
	 * status*
	 * remark
	 * addon_name
	 * @return \think\response\Json
	 * @throws \Throwable
	 */
	public function send() {
		/** @var $m Send */
		$m = $this->_model;
		$param = $this->param;
		
		//$addonParam = sessionOrGLOBALS('addonParam');
		
		$value = [];
		$value['addonParam'] = $this->_addon_param;//$addonParam;
		$value['sendModel'] = $m;
		$value['param'] = $param;
		
		$re = Event::t('sendMsg', $value);
		if (isErr($re)) {
			return return_json($re);
		}
		
		$reData = gData($re);
		
		//$param = array_merge($param, $reData['param']);
		$param = isset($reData['param']) ? $reData['param'] : $param;
		
		return $this->sendMessage($param);
	}

}
