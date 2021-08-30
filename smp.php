<?php
  require('inc/wol_lib.php');

  if (isset($_REQUEST['mac'])) {
    if (file_exists($wol_lib->config['wolbin'])) {
    $mac = escapeshellcmd($_REQUEST['mac']);
    $cmd = sprintf('%s -i %s %s', $wol_lib->config['wolbin'], $wol_lib->config['broadcast'], $mac);
    $wol_lib->save_smp_log($mac);
    $wyn = array($cmd);
    exec($cmd, $wyn, $ret);
    } else {
      $wyn = array('brak pliku :' . $wol_lib->config['wolbin']);
    }
  } else {
    $wyn = array();
  }
  header( "refresh:3;url=./" );
  echo "<pre>";
  echo join("\n", $wyn);
  echo "</pre>";
  echo "<br><br>";
  echo 'You\'ll be redirected in about 3 secs. If not, click <a href="./">here</a>.';
?>
