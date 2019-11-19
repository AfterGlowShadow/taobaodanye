<?php

namespace app\sys\com\base\common\v1\logic;

use think\Model;

class CommonDate extends Model {
	public static function getYesterday1() {
		$yesterday1 = strtotime(date("Y-m-d", strtotime("-1 day")));
		return $yesterday1;
	}

	/**
	 * 得到的其实是今天 只是按昨天计算
	 * @return false|int
	 */
	public static function getYesterday2() {
		$yesterday2 = strtotime(date("Y-m-d", strtotime("-1 day"))) + 86400;
		return $yesterday2;
	}

	public static function getToday1() {
		$today1 = strtotime(date('Y-m-d', time()));
		return $today1;
	}

	/**
	 * 得到的是明天 只是按今天计算
	 * @return false|int
	 */
	public static function getToday2() {
		$today2 = strtotime(date('Y-m-d', time())) + 86400;
		return $today2;
	}

	public static function getToday() {
		return time();
	}

	public static function isToday($date) {
		$t = self::getDate_Timestamp($date);
		$today = self::getDate_Timestamp(self::getToday());
		return $t == $today;
	}

	/**
	 * 获取时间戳日期部分 舍弃秒
	 * @param $date
	 * @return false|int
	 */
	public static function getDate_Timestamp($date) {
		$t = strtotime(date('Y-m-d', $date));
		return $t;
	}

	/**
	 * 获取累加天数后的时间戳
	 * @param int $t        时间戳
	 * @param int $incDays  要累加的天数
	 * @return
	 */
	public static function getDate_Timestamp_DayInc($t, $incDays) {
		$_t = strtotime('+' . $incDays . ' days', $t);
		return self::getDate_Timestamp($_t);
	}

	/**
	 * 获取递减天数后的时间戳
	 * @param int $t        时间戳
	 * @param int $incDays  要累加的天数
	 * @return
	 */
	public static function getDate_Timestamp_DayDec($t, $incDays) {
		$_t = strtotime('-' . $incDays . ' days', $t);
		return self::getDate_Timestamp($_t);
	}

	/**
	 * 提取时间戳里秒数 舍弃日期部分
	 * @param $time
	 * @return false|int
	 */
	public static function getTimestamp_Sec($time) {
		$t = $time - strtotime(date('Y-m-d', $time));
		return $t;
	}

	public static function getTextDateAddDay_Text($n, $date_text) {
		$d = date('Y-m-d', strtotime("+{$n} day", strtotime($date_text)));
		return $d;
	}

	public static function compareTextDate($date_text_1, $date_text_2) {
		$t1 = strtotime($date_text_1);
		$t2 = strtotime($date_text_2);

		if ($t1 > $t2) {
			return 1;
		} elseif ($t1 == $t2) {
			return 0;
		} else {
			return -1;
		}
	}

	/**
	 * 两个时间段比较 判断是否时间不相交 t0是基准 t1是需要比较的
	 * @param $t0_start
	 * @param $t0_end
	 * @param $t1_start
	 * @param $t1_end
	 * @return bool
	 */
	public static function outTime_Timebucket($t0_start, $t0_end, $t1_start, $t1_end) {
		return (($t1_start < $t0_start && $t1_end <= $t0_start) || ($t1_start >= $t0_end && $t1_end > $t0_end));
	}

	/**
	 *  求两个日期之间相差的天数
	 *  (针对1970年1月1日之后，求之前可以采用泰勒公式)
	 *
	 * @param $dayT1
	 * @param $dayT2
	 * @return number
	 *  
	 */
	public static function diffBetweenTwoDays_Timestamp($dayT1, $dayT2) {
		$second1 = self::getDate_Timestamp($dayT1);
		$second2 = self::getDate_Timestamp($dayT2);

		if ($second1 < $second2) {
			$tmp     = $second2;
			$second2 = $second1;
			$second1 = $tmp;
		}
		return ($second1 - $second2) / 86400;
	}

	/**
	 * 求两个日期之间相差的天数
	 * (针对1970年1月1日之后，求之前可以采用泰勒公式)
	 * @param string $day1
	 * @param string $day2
	 * @return number
	 */
	public static function diffBetweenTwoDays($day1, $day2) {
		$second1 = strtotime($day1);
		$second2 = strtotime($day2);

		return self::diffBetweenTwoDays_Timestamp($second1, $second2);
	}
}