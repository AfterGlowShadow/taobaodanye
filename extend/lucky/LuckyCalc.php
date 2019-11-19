<?php


namespace lucky;


class LuckyCalc {
	/**
	 * 概率算法
	 * @param $proArr array(2, 8, 90)
	 * @return int|string
	 */
	public static function get_rand($proArr) {
		$result = '';
		$proSum = array_sum($proArr);
		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				$result = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}
		unset($proArr);
		return $result;
	}
}