<?php
// +----------------------------------------------------------------------
// | Description: 系统配置
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace app\sys\com\base\common\v1\controller\admin;


class SystemConfigs extends ApiCommon {
    public function save()
    {
        $configModel = model('SystemConfig');
        $param = $this->param;
        $data = $configModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $configModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);	
    }
}
 