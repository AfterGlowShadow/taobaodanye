<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Update\api\controller;


class Upload extends \app\sys\com\Update\common\logic\Upload {
	
	/**
	 * 上传图片
	 * @api_name 上传图片
	 * @api_type 3
	 * @api_is_menu 1
	 * @api_is_maker 1
	 * @api_url /sys/api/update.v1.upload.uploadImg
	 *
	 * @return float|int|mixed|string
	 */
	public function uploadImg() {
		//$addonParam = sessionOrGLOBALS('addonParam');
		
		return parent::uploadImg();
	}
	
}