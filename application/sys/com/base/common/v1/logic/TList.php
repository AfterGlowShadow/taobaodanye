<?php


namespace app\sys\com\base\common\v1\logic;


use app\sys\com\base\common\v1\traits\Base;

class TList {
	use Base;
	
	protected $_id = 1;
	protected $items = [];
	
	public function __construct() {
		$this->items = [];
	}
	
	public function create_id() {
		return uniqid();
	}
	
	public function makeData($item) {
		$_d = [];
		$_d[$this->create_id()] = $item;
		return $_d;
	}
	
	public function add($item) {
		$_item = $this->makeData($item);
		$this->items[] = $_item;
		return key($_item);
	}
	
	public function insert($index, $item) {
		$_item = $this->makeData($item);
		array_splice($this->items, $index, 0, $_item);
		return key($_item);
	}
	
	public function delete($index) {
		unset($this->items[$index]);
	}
	
	public function deleteById($id) {
		foreach ($this->items as $k => $item) {
			if (isset($item[$id])) {
				unset($this->items[$k]);
				break;
			}
		}
	}
	
}

// 可以使用双向链表 SplDoublyLinkedList