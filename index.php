<?php

require('inc/wol_lib.php');

function get_upt() {
  $str   = @file_get_contents('/proc/uptime');
  $num   = intval($str);
  $secs  = fmod($num, 60); $num = intdiv($num, 60);
  $mins  = $num % 60;      $num = intdiv($num, 60);
  $hours = $num % 24;      $num = intdiv($num, 24);
  $days  = $num;
  return sprintf('%d days, %02d:%02d:%02d', $days, $hours, $mins, $secs);
}

//$wol_lib->scan();
$hosts = $wol_lib->get_hosts();
$harp = $wol_lib->get_harp();


$smarty->assign('sesja', wol_lib::version . ' (' . PHP_VERSION . ')' . ' [uptime: ' . get_upt() . ']');
$smarty->assign('hosts', $hosts);
$smarty->assign('harp', $harp);
$smarty->assign('logs', $wol_lib->get_logs());

$smarty->display('index.tpl');

?>
