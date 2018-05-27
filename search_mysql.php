<?php
require 'config.php';

$mysqli = new mysqli($mysql_config['connect']['host'], $mysql_config['connect']['user'], $mysql_config['connect']['password'], $mysql_config['connect']['db']);
$mysqli->set_charset($mysql_config['charset']);

if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
};

$mysql_table=$mysql_config['table'];
foreach($weSeek as $word){
  $start=microtime(TRUE);
  if($result=$mysqli->query("select count(*) as cnt from $mysql_table where MATCH(OKPD2_synonim) AGAINST('+{$word}' IN BOOLEAN MODE)")){
    while ($row = $result->fetch_object()) {
      $end=microtime(TRUE);
      echo $word,'...',$row->cnt," got in ",($end-$start)," sec\n";
    }
    $result->close();
  };

};

$mysqli->close();

?>
