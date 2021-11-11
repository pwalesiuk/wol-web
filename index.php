<?php

require('inc/wol_lib.php');

//$wol_lib->scan();
$hosts = $wol_lib->get_hosts();
$harp = $wol_lib->get_harp();


$smarty->assign('hosts', $hosts);
$smarty->assign('harp', $harp);
$smarty->assign('logs', $wol_lib->get_logs());

$smarty->display('index.tpl');

?>
