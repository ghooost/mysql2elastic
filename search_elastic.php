<?php
require 'config.php';
require 'vendor/autoload.php';
use Elasticsearch\ClientBuilder;

$elastic = ClientBuilder::fromConfig($elastic_config['connect']);

$elastic_index=$elastic_config['index'];
$elastic_type=$elastic_config['type'];

foreach($weSeek as $word){
  $params = [
      'index' => $elastic_index,
      'type' => $elastic_type,
      'body' => [
          'query'=>[
            'match'=>[
              'OKPD2_synonim' =>$word
            ]
          ]
      ]
  ];
  $start=microtime(TRUE);
  $results = $elastic->search($params);
  $end=microtime(TRUE);
  echo $word,'...',$results['hits']['total']," got in ",($end-$start)," sec\n";
}
?>
