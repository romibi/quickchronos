<?php
namespace ch\romibi\quickchronos;
class StringHelper {
	public static function format($str='', $vars=array(), $char='%')
	{
	    if (!$str) return '';
	    if (count($vars) > 0)
	    {
	        foreach ($vars as $k => $v)
	        {
	            $str = str_replace($char . $k, $v, $str);
	        }
	    }
	
	    return $str;
	}
}