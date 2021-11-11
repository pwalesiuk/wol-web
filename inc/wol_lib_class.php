<?php

/**
 * główna klasa do obsługi netstats
 */
class wol_lib {

  public $dbl;  // link do bazy lokalnej
  public $config; // konfiguracja
  public $logs;   // logi

  private $db_stmt;  // wykorzystywane obiekty PDOStatement

  /**
   * utworzenie nowego obiektu wol_lib
   */
  function __construct() {
    require_once('config.php');
    $this->config = $config;
    /*
    try {
      $this->dbl = new PDO($this->config['dbl_dsn'],
                           $this->config['dbl_user'],
                           $this->config['dbl_pass']);
    } catch (PDOException $e) {
      print "Błąd przy łączeniu z pgsql: " . $e->getMessage() . "<br/>";
      die();
    }
    $this->dbl->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->db_stmt = array();
    $this->baza = 'l';
    */

    $this->hosts = $hosts;
    $this->nmap_out = array();
    $this->logs = array();
    $this->log_file = WOL_BASE_DIR . '/log/wol.log';

    if ($this->config['dev']) {
      $this->config['show_logs'] = 1;
//      $this->dbl->exec('set search_path to os_dev');
    }
  }

  static function parse_sort_mode(&$sm, &$sq, $cols, $def) {
    $acols = array();
    foreach ($cols as $col) {
      $acols[] = $col . '_asc';
      $acols[] = $col . '_desc';
    }  
    if (!in_array($sm, $acols)) {
      $sm = $def;
    }
    if (!in_array($sm, $acols)) {
      $sm = $acols[0];
    }
    $stab = explode('_', $sm);
    $so = array_pop($stab);
    $sq = implode('_', $stab) . ' ' . $so;
  }

  function log($message, $level) {
    if ($level > $this->config['log_level']) return;
    $this->logs[] = array('level' => $level,
                          'message' => $message);
    if (PHP_SAPI == 'cli') {
      printf("log: %d. %s\n", $level, $message);
    }
  }

  /**
   * zwraca wyrażenie do zapytania sql dla zadanego kodu przedziału czasu
   *
   * @param
   *   kod przedziału czasu (d,m,w)
   *
   * @return
   *   wyrażenie do zapytania sql
   */
  static function get_period($fmode) {
    switch ($fmode) {
      case 'm' :
        $period = "to_char(data, 'yyyymm')";
        break;
      case 'w' :
        $period = "to_char(data, 'yyyyiw')";
        break;
      default :
        $period = "data";
    }
    return $period;
  }

  function get_host_tr($fhost, $fmode, $fval, $forder, $fco = 'host') {
    $period = self::get_period($fmode);
    $qvar = array('adres' => $fhost);
    $warunek = '';
    if ($fval) {
      $qvar['val'] = $fval;
      $warunek = "and $period = :val";
    }
    if ($fco == 'net') {
      $hostop = '<<';
    } else {
      $hostop = '=';
    }
    $sql = "select adres, $period period, sum(rx) rx, sum(tx) tx,
            sum(rx+tx) sx
            from tr_dni
            where adres $hostop :adres
            $warunek
            group by adres, period
            order by $forder";
//    print_r($sql);
    $st = $this->dbl->prepare($sql);
    $st->execute($qvar);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  function get_net_from_host($fhost) {
    $sql = "select adres from ost_odczyty
            where adres >> :host";
    $st = $this->dbl->prepare($sql);
    $st->execute(array('host' => $fhost));
    $wyn = $st->fetch(PDO::FETCH_ASSOC);
    if ($wyn) {
      return $wyn['adres'];
    } else {
      return $fhost;
    }
  }

  function get_networks() {
    $sql = "select * from ost_odczyty
            where masklen(adres) = 24
            order by adres";
    $st = $this->dbl->query($sql);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  function get_hosts() {
    $wyn = array();
    $arp = file_get_contents('/proc/net/arp');
    $nml = implode($this->nmap_out);
    foreach ($this->hosts as $kto => $mac) {
      $h = array('mac' => $mac, 'kto' => $kto);
      if (preg_match('/(\d+\.\d+\.\d+\.\d+).*' . $mac . '/', $arp, $m) > 0) {
        $h['ip'] = $m[1];
        $h['sort'] = explode('.', $m[1])[3];
//        exec('ping -qn -c 1 ' . $h['ip'], $q, $zwrot);
        $zwrot = strpos($nml, $h['ip']);
        if ($zwrot > 0) {
          $h['up'] = 1;
        } else {
          $h['up'] = 0;
        }
      } else {
        $h['ip'] = '';
        $h['up'] = 0;
        $h['sort'] = 300;
      }
      $wyn[] = $h;
    }
    $pom = array_column($wyn, 'sort');
    array_multisort($pom, SORT_ASC, SORT_NUMERIC, $wyn);
    return $wyn;
  }

  function get_harp() {
    $wyn = array();
    $linie = file('/proc/net/arp');
    $spr = array_values($this->hosts);
    //echo '<pre>';
    foreach ($linie as $linia) {
      $pom = preg_split('/ +/', $linia);
      if (strlen($pom[0]) < 6) continue;
      if (in_array($pom[3], $spr)) continue;
      $h = array('mac' => $pom[3], 'ip' => $pom[0]);
      $h['sort'] = explode('.', $pom[0])[3];
      $wyn[] = $h;
    }
    //echo '</pre>';
    $pom = array_column($wyn, 'sort');
    array_multisort($pom, SORT_ASC, SORT_NUMERIC, $wyn);
    return $wyn;
  }
  function get_logs() {
    exec('/usr/bin/tail -n 20 ' . $this->log_file, $logs);
    $logs = array_reverse($logs);
    $wyn = array();
    foreach ($logs as $log) {
      $kl = explode('|', $log);
      $pom = array('date' => $kl[0], 'host' => $kl[1], 'mac' => $kl[2]);
      $wyn[] = $pom;
    }
    return $wyn;
  }
  
  function save_smp_log($mac) {
    $log = date('Ymd H:i:s') . '|' .
           $_SERVER['REMOTE_ADDR'] . '|' .
           $mac . "\n";
    file_put_contents($this->log_file, $log, FILE_APPEND);
  }
  
  function scan() {
    exec('/usr/bin/sudo /usr/bin/nmap -sn -PE -oG - 192.168.1.98-105', $this->nmap_out);
  }
  
  
} // wol_lib class

?>
