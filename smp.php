<?php
  require('inc/wol_lib.php');

  if (isset($_REQUEST['mac'])) {
    $mac = escapeshellcmd($_REQUEST['mac']);
    $cmd = '/usr/bin/wakeonlan -i 192.168.1.255 ' . $mac;
    $wol_lib->save_smp_log($mac);
    exec($cmd, $wyn, $ret);
  } else {
    $wyn = array();
  }
  header( "refresh:3;url=index.php" );
  echo "<pre>";
  echo join('\n', $wyn);
  echo "</pre>";
  echo "<br><br>";
  echo 'You\'ll be redirected in about 3 secs. If not, click <a href="index.php">here</a>.';
?>
