<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\Update\common\logic;


use app\sys\com\Update\common\model\Media;
use app\sys\com\Update\common\model\Picture;
use think\Db;
use think\Env;
use think\facade\Request;
use think\facade\Session;
use think\Image;

class Upload {
    protected $thumbPath;
    protected $reducePath;

    public function __construct() {
        if (!Request::isAjax() && !Request::isPost()) return false;
        
	    // $addonParam = sessionOrGLOBALS('addonParam');
	    // $this->mid = $addonParam['mid'];
	    // $this->type = 1;
	    // !empty($addonParam['addon_type']) && $addonParam['addon_type'] == 'api' && $this->type = 2;
	    
        $this->thumbPath = \think\facade\Env::get('root_path') . ENTR_PATH . '/' . 'uploads/thumb/';
        $this->reducePath = \think\facade\Env::get('root_path') . ENTR_PATH . '/' . 'uploads/reduce/';
    }
    
	public function uploadImg() {
        $file = \request()->file('image');
        if (empty($file)) {
        	return rjErrCode(10001);
        }
        
        $info = $file->rule('md5')->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . '/' . ENTR_PATH . '/' . 'uploads');
        if ($info) {
            $saveName = str_replace('\\', '/', $info->getSaveName());
            $_array = explode('/', $saveName);
            $Name = end($_array);
            if (!Picture::get(['name' => $Name])) {
                $picture = 'uploads' . '/' . $saveName;
                $image_path = ROOT_PATH . '/' . ENTR_PATH . '/' . $picture;
                if (is_file($image_path)) {
                    if ($array = explode('/', $saveName)) {
                        if (createDir($this->thumbPath . $array[0])) {
                            $thumb = $this->thumbPath . $saveName;
                            $image = Image::open($image_path);
                            $image->thumb(260, 146, \think\Image::THUMB_CENTER)->save($thumb);
                            if (createDir($this->reducePath . $array[0])) {
                                $reduce = $this->reducePath . $saveName;
                                $image->thumb(260, 260, \think\Image::THUMB_SCALING)->save($reduce);
                            }
                            $_data = [
                                'name' => $Name,
                                'thumb' => 'uploads/thumb/' . $saveName,
                                'picture' => 'uploads/' . $saveName,
                                'reduce' => 'uploads/reduce/' . $saveName,
                                'create_time' => time()
                            ];
                            $model = new Picture();
                            $model->save($_data);
                        }
                    }
                }
            }

            header('Content-Type:application/json; charset=utf-8');
            $res = [
                'src' => '/uploads/' . $saveName,
                'thumb' => '/uploads/thumb/' . $saveName,
                'reduce' => '/uploads/reduce/' . $saveName,
                'src_domain' => getHostDomain() . '/uploads/' . $saveName,
                'thumb_domain' => getHostDomain() . '/uploads/thumb/' . $saveName,
                'reduce_domain' => getHostDomain() . '/uploads/reduce/' . $saveName,
            ];
            return rjData($res);

        } else {
            // 上传失败获取错误信息
            // $res = [
            //     'code' => 1,
            //     'msg' => $file->getError()
            // ];
            // return json_encode($res);
	        return rjErr('上传失败 ' . $file->getError());
        }
    }


    public function uploadFileBYmpVerify()
    {
        $file = \request()->file('file');
        $info = $file->validate(['ext' => 'mp3,wma,wav,amr,rm,rmvb,wmv,avi,mpg,mpeg,mp4,txt,zip,rar'])->move(ROOT_PATH . '/' . ENTR_PATH . '/', '');

        if ($info) {
            header('Content-Type:application/json; charset=utf-8');
            // $res = [
            //     'code' => 0,
            //     'data' => [
            //         'src' => getHostDomain() . '/uploads/' . $info->getSaveName()
            //     ]
            // ];
            // return json_encode($res);
	        $res = [
		        'src' => getHostDomain() . '/uploads/' . $info->getSaveName(),
	        ];
	        return rjData($res);

        } else {
            // 上传失败获取错误信息
            // $res = [
            //     'code' => 1,
            //     'msg' => $file->getError()
            // ];
            // return json_encode($res);
	        return rjErr('上传失败 ' . $file->getError());
        }

    }

    public function uploadMedia() {
        $file = \request()->file('media');
	    if (empty($file)) {
		    return rjErrCode(10001);
	    }
        
        $info = $file->rule('md5')->validate(['ext' => 'mp3,wma,wav,amr,rm,rmvb,wmv,avi,mpg,mpeg,mp4,mov,MOV'])->move(ROOT_PATH . '/' . ENTR_PATH . '/uploads');

        if ($info) {
	        $saveName = str_replace('\\', '/', $info->getSaveName());
	        $_array = explode('/', $saveName);
	        $Name = end($_array);
	        if (!Media::get(['name' => $Name])) {
		        $media = 'uploads' . '/' . $saveName;
		        $media_path = ROOT_PATH . '/' . ENTR_PATH . '/' . $media;
		        if (is_file($media_path)) {
			        if ($array = explode('/', $saveName)) {
				        $_data = [
					        'name' => $Name,
					        'media' => 'uploads/' . $saveName,
					        'create_time' => time()
				        ];
				        $model = new Media();
				        $model->save($_data);
			        }
		        }
	        }
        	
            header('Content-Type:application/json; charset=utf-8');
            // $res = [
            //     'code' => 0,
            //     'data' => [
            //         'src' => getHostDomain() . '/uploads/' . $info->getSaveName()
            //     ]
            // ];
            // return json_encode($res);
	        $res = [
		        'src' => '/uploads/' . $saveName,
		        'src_domain' => getHostDomain() . '/uploads/' . $saveName,
	        ];
	        return rjData($res);

        } else {
            // 上传失败获取错误信息
            // $res = [
            //     'code' => 1,
            //     'msg' => $file->getError()
            // ];
            // return json_encode($res);
	        return rjErr('上传失败 ' . $file->getError());
        }
    }

    public function uploadFile()
    {
        $file = \request()->file('media');
        $info = $file->rule('md5')->validate(['ext' => 'mp3,wma,wav,amr,rm,rmvb,wmv,avi,mpg,mpeg,mp4,txt,zip,rar'])->move(ROOT_PATH . '/' . ENTR_PATH . '/uploads');

        if ($info) {
            header('Content-Type:application/json; charset=utf-8');
            // $res = [
            //     'code' => 0,
            //     'data' => [
            //         'src' => getHostDomain() . '/uploads/' . $info->getSaveName()
            //     ]
            // ];
            // return json_encode($res);
	        $res = [
		        'src' => getHostDomain() . '/uploads/' . $info->getSaveName(),
	        ];
	        return rjData($res);

        } else {
            // 上传失败获取错误信息
            // $res = [
            //     'code' => 1,
            //     'msg' => $file->getError()
            // ];
            // return json_encode($res);
	        return rjErr('上传失败 ' . $file->getError());
        }
    }

    public function qiniuUpload()
    {
        $file = \request()->file('image');
        $info = $file->rule('md5')->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . '/' . ENTR_PATH . '/' . 'uploads');
        if ($info) {
            $saveName = str_replace('\\', '/', $info->getSaveName());
            $file = './uploads/' . $saveName;
            // if (!empty($mid = session('mid')) || !empty($mid = input('mid'))) {
            // }
            // if ($_mid = input('_mid')) {
            //     $mid = $_mid;
            // }
            $result = qiniuUpload($mid, $file, $saveName);
            header('Content-Type:application/json; charset=utf-8');
            if ($result['code'] == '0') {

                $_array = explode('/', $saveName);
                $Name = end($_array);
                if (!Picture::get(['name' => $Name])) {
                    $picture = 'uploads/' . $saveName;
                    $image_path = \think\facade\Env::get('root_path') . $picture;
                    if (is_file($image_path)) {
                        if ($array = explode('/', $saveName)) {
                            if (createDir($this->thumbPath . $array[0])) {
                                $thumb = $this->thumbPath . $saveName;
                                $image = Image::open($image_path);
                                $image->thumb(260, 146, \think\Image::THUMB_CENTER)->save($thumb);
                                if (createDir($this->reducePath . $array[0])) {
                                    $reduce = $this->reducePath . $saveName;
                                    $image->thumb(260, 260, \think\Image::THUMB_CENTER)->save($reduce);
                                }
                                $_data = [
                                    'name' => $Name,
                                    'thumb' => 'uploads/thumb/' . $saveName,
                                    'picture' => $result['data']['src'],
                                    'reduce' => 'uploads/reduce/' . $saveName,
                                    'create_time' => time()
                                ];
                                $model = new Picture();
                                $model->save($_data);
                            }
                        }
                    }
                }
                // return json_encode($result);
	            return rjData($result);
            } else {
                // return json_encode($result);
	            return rjData($result);
            }
        } else {
            // 上传失败获取错误信息
            // $res = [
            //     'code' => 1,
            //     'msg' => $file->getError()
            // ];
            // return json_encode($res);
	        return rjErr('上传失败 ' . $file->getError());
        }
    }

    public function uploaderMediaNewsImg()
    {
        $file = \request()->file('file_upload');
        $info = $file->rule('md5')->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . '/' . ENTR_PATH . '/uploads');

        if ($info) {
            header('Content-Type:application/json; charset=utf-8');
            $saveName = str_replace('\\', '/', $info->getSaveName());
            // $res = [
            //     'code' => 1,
            //     'data' => getHostDomain() . '/uploads/' . $saveName,
            //     'message' => '上完成功'
            // ];
            // return json_encode($res);
	
	        $res = [
		        'src' => getHostDomain() . '/uploads/' . $info->getSaveName(),
	        ];
	        return rjData($res);
        } else {
            // 上传失败获取错误信息
            // $res = [
            //     'code' => 0,
            //     'data' => '',
            //     'message' => $info->getError()
            // ];
            // return json_encode($res);
	        return rjErr('上传失败 ' . $file->getError());
        }
    }

}