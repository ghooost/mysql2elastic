<?php
require 'config.php';
require 'vendor/autoload.php';
use Elasticsearch\ClientBuilder;

//create elastic
$elastic = ClientBuilder::fromConfig($elastic_config['connect']);

//connect to MySQL
$mysqli = new mysqli($mysql_config['connect']['host'], $mysql_config['connect']['user'], $mysql_config['connect']['password'], $mysql_config['connect']['db']);
$mysqli->set_charset($mysql_config['charset']);

if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
};

$elastic_index=$elastic_config['index'];
$elastic_type=$elastic_config['type'];
$mysql_table=$mysql_config['table'];
$mysql_pagesize=$mysql_config['pagesize'];

$cnt=0;
$start=time();

do {
  if($result=$mysqli->query("select * from {$mysql_table} limit {$cnt},{$mysql_pagesize}")){
    $nRows=$result->num_rows;
    while ($row = $result->fetch_object()) {
      $params = [
          'index' => $elastic_index,
          'type' => $elastic_type,
          'id'=>$row->id,
          'body' => [
            'OKPD2_code'=>$row->OKPD2_code,
            'OKPD2_synonim'=>$row->OKPD2_synonim,
            'rating'=>$row->rating
          ]
      ];
      $response = $elastic->index($params);
      $cnt++;
    }
    $result->close();
    echo $cnt." indexed\n";
  } else {
    break;
  }
} while ($nRows);
$end=time();
echo "Index took ".(($end-$start)/60.0)." minutes\n";

$mysqli->close();

?>
