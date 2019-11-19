<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Msg\common\model;


class Send extends \app\sys\com\Msg\common\model\table\Send {
	
	public static $_READ_FLAG = [
		'not_read' => 0,    // 未读
		'read' => 1,        // 已读
	];

	public static $_STATUS = [
		'wait' => 0,    // 等待发送
		'send' => 1,    // 发送中
		'success' => 2, // 成功
		'failure' => 3, // 失败
	];
	
	/**
	 * 关联内容
	 * @return \think\model\relation\BelongsTo
	 */
	public function hText() {
		return $this
			->belongsTo('app\sys\com\Msg\common\model\Text', 'msg_text_id', 'id')
			->field('id, title, content, type, status, remark');
	}
	
	public function setStatusSuccess($id) {
		$data = [];
		$data['status'] = self::$_STATUS['success'];
		
		$re = $this->editById($id, $data);
		return $re;
	}
	
	public function setStatusFailure($id) {
		$data = [];
		$data['status'] = self::$_STATUS['failure'];
		
		$re = $this->editById($id, $data);
		return $re;
	}
	
	public function setReadFlag($id, $value = true) {
		$data = [];
		$data['read_flag'] = $value ? 1 : 0;
		
		$re = $this->editById($id, $data);
		return $re;
	}

}
