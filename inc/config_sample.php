<?php
  define('WOL_BASE_DIR', '/var/www/wizard/htdocs/wold');

  $config = array(
    'wolbin'                    => '/usr/bin/wakeonlan',
    'broadcast'                 => '192.168.1.255',
    'dev'			=> 1,
    'local_cache_time'		=> 10,
    'log_level'			=> LOG_INFO
  );

  $hosts = array('MS' => '00:d8:61:c2:9b:a7',);

?>
