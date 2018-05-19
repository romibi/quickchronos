<?php
namespace ch\romibi\quickchronos;
require_once 'StringHelper.php';
class TimeHelper {
	public static function convertTimestampToArray($timestamp, $hoursInDay=24) {
		$s = $timestamp;
		$m = $s/60;
		$h = $m/60;
		$d = $h/$hoursInDay;

		$seconds = $s%60;
		$minutes = $m%60;
		$hours = $h%$hoursInDay;
		$days = floor($d);

		return array('d'=>$days, 'h'=>$hours, 'H'=>sprintf('%02d',$hours), 'm'=>$minutes, 'M'=>sprintf('%02d',$minutes), 's'=>$seconds,'S'=>sprintf('%02d',$seconds));
	}

	public static function convertTimestampToString($timestamp, $format='%dd, %H:%M:%S', $hoursInDay=24) {
		return StringHelper::format($format, self::convertTimestampToArray($timestamp, $hoursInDay));
	}
}