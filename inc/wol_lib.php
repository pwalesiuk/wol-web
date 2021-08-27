<?php

  $bd = dirname(__DIR__);
  require $bd . '/vendor/autoload.php';

require_once('wol_lib_class.php');
require_once('mysmarty_class.php');

define('WOL_VERSION', '2.0');

$bar_width = 200;
$bar_height = 10;


function exception_handler($exception) {
  echo "Uncaught exception: " , $exception->getMessage(), "\n";
}

set_exception_handler('exception_handler');

session_start();
$_SESSION['ns']['time_start'] = microtime(true);
$wol_lib = new wol_lib();

$smarty = new mySmarty($wol_lib);

$smarty->assign('bar_height', $bar_height);
$smarty->assign('bar_width', $bar_width);

?>
