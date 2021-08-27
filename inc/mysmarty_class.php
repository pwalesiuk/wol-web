<?php

class mySmarty extends Smarty {

  public function __construct(&$wol_lib) {
    parent::__construct();
    $sdir = WOL_BASE_DIR . '/smarty/';
    $this->template_dir = $sdir . 'templates/';
    $this->compile_dir = $sdir . 'templates_c/';
    $this->config_dir = $sdir . 'configs/';
    $this->cache_dir = $sdir . 'cache/';
    $this->plugins_dir = array($sdir . '/plugins', 'plugins');

    $this->debugging_ctrl = 'URL';
    $this->assign('wol_lib', $wol_lib);
  }

} // mySmarty class

?>
