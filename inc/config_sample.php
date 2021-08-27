<?php
  define('NS_BASE_DIR', '/var/www/wizard/htdocs/netstats');
  define('NS_BASE_URL', 'http://10.6.7.101/netstats');

  $config = array(
    'dbl_dsn'			=> 'pgsql:dbname=net',
    'dbl_user'			=> 'net',
    'dbl_pass'			=> 'n3tb0s',

    'dev'			=> 1,
    'local_cache_time'		=> 10,
    'log_level'			=> LOG_INFO
  );

?>
