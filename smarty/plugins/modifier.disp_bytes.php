<?php

function smarty_modifier_disp_bytes($number, $jedn = '')
{
  switch($jedn) {
    case 'k':
	return number_format($number/1024, 2) . "k";
    case 'M':
	return number_format($number/1024/1024, 2) . "M";
    case 'G':
	return number_format($number/1024/1024/1024, 2) . "G";
    default:
	$sufix = '';
	if ($number > 1024) {
          $number /= 1024;
	  $sufix = 'k';
	};
	if ($number > 1024) {
	  $number /= 1024;
	  $sufix = 'M';
	};
	if ($number > 1024) {
	  $number /= 1024;
	  $sufix = 'G';
	}
   return number_format($number, 2) . $sufix;
  }	
}

?>
