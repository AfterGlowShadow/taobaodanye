<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: lz <jtddsoft@qq.com>
// +----------------------------------------------------------------------

namespace application\sys\com\Config\common\model\table;

use lib\sys\com\base\common\v1\logic\ModelCommon;
use Exception;


class Config extends ModelCommon {
	
	protected $field_prefix       = '';
	protected $pk                 = 'id';
	protected $name               = 'system_config';
	protected $createTime         = false;
	protected $updateTime         = false;
	protected $autoWriteTimestamp = false;
	protected $insert             = [

	];

	//设置删除时间字段,配合软删除功能
	protected $deleteTime 		  = false;
	//设置软删除字段的默认值
	protected $defaultSoftDelete  = 0;

	protected $enabled_validate_add = false;
	protected $enabled_validate_edit = false;

	public function _init() {
		parent::_init();

		$this->_pcmv['package'] = 'sys';
		$this->_pcmv['component'] = 'Config';
		$this->_pcmv['module'] = 'common';
		$this->_pcmv['appType'] = 'lib';

		$this->_config_info['component_name'] = 'sys/com/Config';
	}
	
	/**
	 * 获取列表
	 * @param array  $where
	 * @param array  $order
	 * @param int    $page
	 * @param int    $limit
	 * @param string $field
	 * @param bool   $link
	 * @param array  $join
	 * @param array  $param
	 * @return array
	 * @throws \think\Exception
	 */
	public function getList($where = [], $order = [], $page = 1, $limit = PHP_INT_MAX, $field = '*', $link = false, $join = [], $param = []) {
		$_where = [];

		$m = $this;
        if (!empty($join)) {
            $m = $m->alias('a');

            foreach ($join as $item) {
                if (count($item) == 2) {
                    $m = $m->join($item[0], $item[1]);
                } elseif (count($item) > 2) {
                    $m = $m->join($item[0], $item[1], $item[2]);
                }
            }

            foreach ($where as &$_w_item) {
                $_w_item[0] = 'a.' . $_w_item[0];
            }
        }

        $_where = array_merge($_where, $where);

        if (!empty($param)) {
            if (isset($param['func']) && $param['func'] instanceof \Closure) {
                $m = call_user_func_array($param['func'], [$m]);
            }
        }

        if (!empty($join)) {
            $dataCount = $m->where($_where)->count('a.' . $m->getPk());
        } else {
            $dataCount = $this->where($_where)->count($this->getPk());
        }
		
		$listM = $this;
		
		if (!empty($link) && is_array($link)) {
		    $listM = $listM->with($link);
		}
		
		// 若有分页
		if ($page && $limit) {
			$listM = $listM->page($page, $limit);
		}
		
		if (!empty($join)) {
		    $listM = $listM
		        ->alias('a');

		    foreach ($join as $item) {
		    	if (count($item) >= 2) {
				    $listM = $listM->join($item[0], $item[1]);
			    } elseif (count($item) > 2) {
				    $listM = $listM->join($item[0], $item[1], $item[2]);
			    }
		    }
		}

		if (!empty($param)) {
            if (isset($param['func']) && $param['func'] instanceof \Closure) {
                $listM = call_user_func_array($param['func'], [$listM]);
            }
        }
		
		try {
			$list = $listM
				->field($field)
				->where($_where)
				->order($order)
				->select();
			
			$reList = $this->cToArray($list);
			
			log_record("--- list=" . json_encode($list, JSON_UNESCAPED_UNICODE));
			log_record("--- list sql=" . $this->getLastSql());
			
			$data = [
				'total' => $dataCount,
				'data' => $reList,
			];
			
			return return_status_ok_data($data);
		} catch (\Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}

	/**
	 * 获取单项
	 *
	 * @param int        $id
	 * @param string     $field
	 * @param bool|array $link
	 * @param array      $join
	 * @param array      $param
	 * @return array
	 */
	public function getItemById($id = 0, $field = '*', $link = false, $join = [], $param = []) {
		$_where = [];

		try {
			$m = $this;

			if (!empty($link) && is_array($link)) {
				$m = $m->with($link);
			}

			if (!empty($join)) {
				$m = $m
					->alias('a');

				foreach ($join as $item) {
					if (count($item) >= 2) {
						$m = $m->join($item[0], $item[1]);
					} elseif (count($item) > 2) {
						$m = $m->join($item[0], $item[1], $item[2]);
					}
				}

				$_where[] = ["a.{$this->getPk()}", '=', $id];
			} else {
			    $_where[] = ["{$this->getPk()}", '=', $id];
			}

			if (!empty($param)) {
                if (isset($param['func']) && $param['func'] instanceof \Closure) {
                    $m = call_user_func_array($param['func'], [$m]);
                }
            }

			$item = $m
				->field($field)
				->where($_where)
				->find();

			$itemArr = $this->cToArray($item);
			if ($itemArr === false) {
				return $this->return_error();
			}

			return return_status_ok_data($itemArr);
		} catch (Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}

	/**
	 * 获取单项
	 *
	 * @param array      $where
	 * @param string     $field
	 * @param bool|array $link
	 * @param array      $join
	 * @param array      $param
	 * @return array
	 */
	public function getItem($where = [], $field = '*', $link = false, $join = [], $param = []) {
		$_where = $where;

		try {
			$m = $this;

			if (!empty($link) && is_array($link)) {
				$m = $m->with($link);
			}

			if (!empty($join)) {
				$m = $m
					->alias('a');

				foreach ($join as $item) {
					if (count($item) >= 2) {
						$m = $m->join($item[0], $item[1]);
					} elseif (count($item) > 2) {
						$m = $m->join($item[0], $item[1], $item[2]);
					}
				}
			}

			if (!empty($param)) {
                if (isset($param['func']) && $param['func'] instanceof \Closure) {
                    $m = call_user_func_array($param['func'], [$m]);
                }
            }

			$item = $m
				->field($field)
				->where($_where)
				->find();

			$itemArr = $this->cToArray($item);
			if ($itemArr === false) {
				return $this->return_error();
			}

			return return_status_ok_data($itemArr);
		} catch (Exception $e) {
			$this->error = empty($e->getMessage()) ? '数据查询失败' : $e->getMessage();
			return $this->return_error();
		}
	}

}
