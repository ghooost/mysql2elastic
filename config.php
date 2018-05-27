<?php
$weSeek=['вода','услуг','товар','компьют','рыба','сено','повар','пожар','ремонт'];

$elastic_config=[
  'connect'=>[
    'hosts'=>['http://localhost:9200']
  ],
  'index'=>'nmck',
  'type'=>'doc'
];

$mysql_config=[
  'connect'=>[
    'host'=>'localhost',
    'user'=>'root',
    'password'=>'1',
    'db'=>'nmck'
  ],
  'charset'=>'utf8',
  'table'=>'EIS_OKPD2_synonims',
  'pagesize'=>1000
];
?>
