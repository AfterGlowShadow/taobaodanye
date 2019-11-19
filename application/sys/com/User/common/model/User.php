<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <weipai_lz@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\User\common\model;


use think\facade\Request;

class User extends \app\sys\com\User\common\model\table\User
{

    protected $enabled_validate_add = true;
    protected $enabled_validate_edit = true;

    public static $_STATUS = [
        'disabled' => 0,
        'enabled' => 1,
    ];

    public function _init()
    {
        parent::_init();

        $this->enabled_validate_add_obj = new \app\sys\com\User\common\validate\User();
        $this->enabled_validate_edit_obj = new \app\sys\com\User\common\validate\User();
        $this->enabled_validate_editw_obj = new \app\sys\com\User\common\validate\User();
    }

    /**
     * 生成随机码
     * @param int $len
     * @param array $where 校验是否已存在
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function makeRandCode($len = 10, $where = [])
    {
        // 重试10次避开重复（已存在） 一般一次通过
        for ($i = 0; $i < 10; $i++) {
            $code = makeRandChars($len);

            $re = $this->getItem($where);
            if (!is_return_ok($re)) {
                return $code;
            }

            $reData = get_return_data($re);

            if (!empty($reData)) {
                return $code;
            }
        }

        return makeRandChars($len);
    }

    /**
     * 用invite code查找用户
     *
     * @param      $inviteCode
     * @param bool $allowEmpty
     * @return array
     */
    public function findUser_InviteCode($inviteCode, $allowEmpty = false)
    {
        try {
            $re = $this->where('invite_code', $inviteCode)->find();
            if ($re === false) {
                return $this->return_error();
            } else if (empty($re)) {
                if ($allowEmpty) {
                    return rsData([]);
                } else {
                    return rsErrCode(11011); // 找不到用户
                }
            }

            return rsData($re->toArray());
        } catch (\Exception $e) {
            $this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
            return $this->return_error();
        }
    }

    /**
     * 用token查找用户
     * @param $token
     * @return array
     */
    public function findUser_Token($token, $allowEmpty = false)
    {
        try {
            $re = $this->where('token', $token)->find();
            if ($re === false) {
                return $this->return_error();
            } else if (empty($re)) {
                if ($allowEmpty) {
                    return rsData([]);
                } else {
                    return rsErrCode(11011); // 找不到用户
                }
            }

            return rsData($re->toArray());
        } catch (\Exception $e) {
            $this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
            return $this->return_error();
        }
    }

    /**
     * 用mobile查找用户
     *
     * @param      $mobile
     * @param bool $allowEmpty
     * @return array
     */
    public function findUser_Mobile($mobile, $allowEmpty = false)
    {
        try {
            $re = $this->where('mobile', $mobile)->find();
            if ($re === false) {
                return $this->return_error();
            } else if (empty($re)) {
                if ($allowEmpty) {
                    return rsData([]);
                } else {
                    return rsErrCode(11011); // 找不到用户
                }
            }

            return rsData($re->toArray());
        } catch (\Exception $e) {
            $this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
            return $this->return_error();
        }
    }

    /**
     * 用name查找用户
     *
     * @param      $name
     * @param bool $allowEmpty
     * @return array
     */
    public function findUser_Name($name, $allowEmpty = false)
    {
        try {
            $re = $this->where('name', $name)->find();
            if ($re === false) {
                return $this->return_error();
            } else if (empty($re)) {
                if ($allowEmpty) {
                    return rsData([]);
                } else {
                    return rsErrCode(11011); // 找不到用户
                }
            }

            return rsData($re->toArray());
        } catch (\Exception $e) {
            $this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
            return $this->return_error();
        }
    }

    /**
     * 用uid查找用户
     *
     * @param      $uid
     * @param bool $allowEmpty
     * @return array
     */
    public function findUser_Uid($uid, $allowEmpty = false)
    {
        try {
            $re = $this->where('id', $uid)->find();
            if ($re === false) {
                return $this->return_error();
            } else if (empty($re)) {
                if ($allowEmpty) {
                    return rsData([]);
                } else {
                    return rsErrCode(11011); // 找不到用户
                }
            }

            return rsData($re->toArray());
        } catch (\Exception $e) {
            $this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
            return $this->return_error();
        }
    }

    /**
     * 唯一校验
     *
     * @param       $param
     * @param array $field
     * @param bool $isAdd
     * @return array|\think\response\Json
     */
    public function unique_check($param, $field = [], $isAdd = true)
    {
        $config_unique_param = app_config('reg_use.unique');

        return parent::unique_check($param, $config_unique_param, $isAdd);
    }

    /**
     * 注册添加用户
     * @param $data
     * @return array
     */
    public function reg_user($data)
    {
        // 先处理是否有三方登录header信息
        // $header = Request::header();
        $thirdInfo = [];
        if (!empty(input('third-session-token'))) {
            $thirdInfo = cache('tlogin:st_' . input('third-session-token'));
            !empty($thirdInfo['avatar']) && $data['avatar'] = $thirdInfo['avatar'];
            !empty($thirdInfo['nick']) && $data['nickname'] = $thirdInfo['nick'];
            !empty($thirdInfo['gender']) && $data['gender'] = $thirdInfo['gender'];
            // !empty($thirdInfo['province']) && $data['province'] = $thirdInfo['province'];
            // !empty($thirdInfo['city']) && $data['city'] = $thirdInfo['city'];
        }

        // 添加用户
        $data['invite_code'] = makeInviteCode();

        !isset($data['name']) && $data['name'] = 'user_' . $data['invite_code'];
        !isset($data['nickname']) && $data['nickname'] = 'user_' . $data['invite_code'];

        $data['token'] = makeAccessToken();
        $data['token_expires_in'] = time() + config('sys_config.user_token_expires_in');
        $data['last_login_time'] = 0;
        $data['last_login_ip'] = '';
        $data['status'] = self::$_STATUS['enabled'];

        // 校验唯一
        $re = $this->unique_check($data, [], true);
        if (isErr($re)) {
            return $re;
        }

        // 添加写入
        $reUser = $this->add($data);
        if (isErr($reUser)) {
            return $reUser;
        }

        $reUserData = get_return_data($reUser);
        $uid = $reUserData['id'];

        if (!empty($thirdInfo)) {
            $openid = $thirdInfo['openid'];
            $channel = $thirdInfo['channel'];
            $_uid = $thirdInfo['uid'];
            $id = $thirdInfo['id'];

            if (!empty($_uid)) {
                return rsErr('第三方登录信息已绑定其他用户', 14004); // 已绑定过用户
            }

            if (empty($openid) || empty($channel)) {
                return rsErr('会话token信息异常 请重新登录', 14009); // 会话token信息异常 请重新登录
            }

            $thirdM = new Third();
            $re = $thirdM->findId($id);
            if (isErr($re)) {
                return $re;
            }

            // 写入uid
            $_d = [];
            $_d['uid'] = $uid;
            $re = $thirdM->editById($id, $_d);
            if (isErr($re)) {
                return $re;
            }
        }

        $re = $this->login_user(['uid' => $uid]);
        if (isErr($re)) {
            return $re;
        }

        $reLogin = gData($re);

        $GLOBALS['user_info'] = array_merge($GLOBALS['user_info'], $data);
        $GLOBALS['user_info']['uid'] = $uid;
        $GLOBALS['user_info']['token'] = $reLogin['token'];
        $GLOBALS['user_info']['avatar'] = $reLogin['userInfo']['avatar'];
        $GLOBALS['user_info']['nickname'] = $reLogin['userInfo']['nickname'];

        return $re;
    }

    /**
     * 用户登录
     *
     * @param array $data
     * @return array|bool
     */
    public function login_user($data = [])
    {
        $_login_type = app_config('login_use.def_type');
        isset($data['_login_type']) && $_login_type = $data['_login_type'];

        if (!empty($data['uid'])) {
            $_login_type = 'uid';
            $re = $this->getItemById($data['uid']);
        } else {
            $where = [];

            switch ($_login_type) {
                case 'mobile_passwd':
                    if (empty($data['passwd'])) {
                        return rsErr('密码不能为空', 10003);
                    }

                    $passwd = md5($data['passwd']);
                    $where[] = ['passwd', '=', $passwd];

                    // 如果登陆方式启用手机号
                    if (app_config('login_use.mobile') == 1) {
                        if (empty($data['mobile'])) {
                            return rsErr('手机号不能为空', 10003);
                        }

                        $mobile = $data['mobile'];
                        $where[] = ['mobile', '=', $mobile];
                    }

                    break;
                case 'mobile_code':
                    // 如果登陆方式启用手机号
                    if (app_config('login_use.mobile') == 1) {
                        if (empty($data['mobile'])) {
                            return rsErr('手机号不能为空', 10003);
                        }

                        $mobile = $data['mobile'];
                        $where[] = ['mobile', '=', $mobile];
                    }
                    break;
                case 'user_passwd':
                    if (empty($data['passwd'])) {
                        return rsErr('密码不能为空', 10003);
                    }

                    $passwd = md5($data['passwd']);
                    $where[] = ['passwd', '=', $passwd];

                    // 如果登陆方式启用用户名
                    if (app_config('login_use.username') == 1) {
                        if (empty($data['username'])) {
                            return rsErr('帐号不能为空', 10003);
                        }

                        $username = $data['username'];
                        $where[] = ['name', '=', $username];
                    }

                    // 如果登陆方式启用手机号
                    if (app_config('login_use.mobile') == 1) {
                        if (empty($data['mobile'])) {
                            return rsErr('手机号不能为空', 10003);
                        }

                        $mobile = $data['mobile'];
                        $where[] = ['mobile', '=', $mobile];
                    }

                    break;
                case 'mix_passwd':
                    if (empty($data['passwd'])) {
                        return rsErr('密码不能为空', 10003);
                    }
                    $passwd = md5($data['passwd']);
                    $where[] = ['passwd', '=', $passwd];

                    if (empty($data['username'])) {
                        return rsErr('帐号/手机号不能为空', 10003);
                    } else{
                        $username = $data['username'];
                        $where[] = ['mobile|name', '=', $username];
                    }
                    // 如果登陆方式启用用户名
//                    if (app_config('login_use.username') == 1) {
//
//
//
//                    }
//
                    // 如果登陆方式启用手机号
//                    if (app_config('login_use.mobile') == 1) {
//                        if (empty($data['mobile'])) {
//                            return rsErr('手机号不能为空', 10003);
//                        }
//
//                        $mobile = $data['mobile'];
//                        $where[] = ['mobile', '=', $mobile];
//                    }

                    break;
            }
            // $where[] = ['status', '=', User::$_STATUS['enabled']]
            $re = $this->getItem($where);
        }

        if (isErr($re)) {
            return rsErr('登录失败', 10003);
        }

        $reUser = gData($re);

        switch ($_login_type) {
            case 'uid':
                if (empty($reUser)) {
                    return rsErr('用户不存在', 10011);
                }
                break;
            case 'user_passwd':
            case 'mobile_passwd':
                if (empty($reUser)) {
                    return rsErr('用户名密码错误', 10011);
                }
                break;
            case 'mobile_code':
                if (empty($reUser)) {
                    return rsErr('手机号不存在', 10011);
                }
                break;
            case 'mix_passwd':
                if (empty($reUser)) {
                    return rsErr('手机号/用户名不存在', 10011);
                }
                break;
            default:
                return rsErr('未知的登录方式', 10011);
                break;
        }

        if ($reUser['status'] == User::$_STATUS['disabled'] || $reUser['frozen_end_time'] > time()) {
            return rsErr('该用户被禁用', 10011);
        }

        //// 在登陆验证处添加验证token过期
        // if ($reUser['token_expire_in'] <= time()) {
        // 	return rsErr('登录态过期 请重新登陆', 10011);
        // }

        $uid = $reUser['id'];

        $id = $reUser['id'];
        $token = $reUser['token'];
        $lastLoginTime = $reUser['last_login_time'];
        $lastLoginIp = $reUser['last_login_ip'];

        $ip = '';
        if (isset($GLOBALS['login_info']) && isset($GLOBALS['login_info']['ip'])) {
            $ip = $GLOBALS['login_info']['ip'];
        }


        // $new_token = md5($reUser['name'] . $reUser['passwd'] . $info['sessionId']);
        $new_token = makeAccessToken($uid);
        // $new_token = $token;

        $_data = [];
        $_data['last_login_time'] = time();
        $_data['last_login_ip'] = $ip;
        $_data['token'] = $new_token;
        $_data['token_expire_in'] = time() + config('sys_config.user_token_expires_in');
        //$this->tmp_scene = 'edit_ip';
        $this->enabled_validate_edit = false;
        $re = $this->editById($id, $_data);
        if (!is_return_ok($re)) {
            return $re;
        }

        $reUser['last_login_time'] = $_data['last_login_time'];
        $reUser['last_login_ip'] = $_data['last_login_ip'];
        $reUser['token'] = $new_token;
        $reUser['token_expire_in'] = time() + config('sys_config.user_token_expires_in');

        // 缓存当前用户
        //session_start();

        //$info['addonType'] = sessionOrGLOBALS('addonParam')['addon_type'];
        //$token = md5($reUser['name'] . $reUser['passwd'] . $info['sessionId']);

        $info['uid'] = $uid;
        $info['uInfo'] = $reUser;
        $info['sessionId'] = session_id();

        $login_limit = app_config('login_use.login_limit');
        !empty($login_limit) && cache('ulogin:User_' . $token, null);
        cache('ulogin:User_' . $new_token, $info, config('sys_config.user_token_expires_in'));

        unset($reUser['passwd']);
        unset($reUser['id']);

        // 返回信息
        $_data = [];
        //$_data['authKey']        = $authKey;
        //$_data['sessionId']      = $info['sessionId'];
        $_data['token'] = $new_token;
        $_data['userInfo'] = $reUser;
        $_data['uid'] = $uid;

        return rsData($_data);
    }

    /**
     * 退出登陆
     * @param array $data
     * @return array
     */
    public function logout($data = [])
    {
        $token = isset($GLOBALS['token']) ? $GLOBALS['token'] : '';
        if (!empty($token)) {
            cache('ulogin:User_' . $token, null);
        }

        return rsOk();
    }

    /**
     * 修改密码
     * @param array $data
     * @return array
     */
    public function changePasswd($data = [])
    {
        $uid = $data['uid'];
        $new_pw = md5($data['new_passwd']);
        $old_pw = md5($data['old_passwd']);

        if (empty($uid)) {
            return rsErr('用户账号无效，请先登录', 10011);
        }

        $re = $this->findUser_Uid($uid);
        if (isErr($re)) {
            return $re;
        }

        $reUser = gData($re);
        if ($reUser['passwd'] !== $old_pw) {
            return rsErr('原密码错误', 10011);
        }

        if ($new_pw == $old_pw) {
            return rsErr('密码相同', 10011);
        }

        $_d = [];
        $_d['passwd'] = $new_pw;
        $this->tmp_scene = 'change_pw';
        $re = $this->editById($uid, $_d);
        return $re;
    }

    public function resetPasswd($data = [])
    {
        $uid = $data['uid'];
        $new_pw = md5($data['new_passwd']);

        if (empty($uid)) {
            return rsErr('用户账号无效，请先登录', 10011);
        }

        $re = $this->findUser_Uid($uid);
        if (isErr($re)) {
            return $re;
        }

        $_d = [];
        $_d['passwd'] = $new_pw;
        $this->tmp_scene = 'reset_pw';
        $re = $this->editById($uid, $_d);
        return $re;
    }

    public function setStatus($id, $status)
    {
        $_d = [];
        $_d['status'] = $status;
        $this->tmp_scene = 'set_status';
        $re = $this->editById($id, $_d);
        return $re;
    }


}
