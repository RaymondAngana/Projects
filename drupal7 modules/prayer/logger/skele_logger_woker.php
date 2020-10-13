<?php
include_once '/var/www/sites/prayvine.prometdev.com/www/sites/all/modules/custom/prayvine_logger/prayvine_logger.module';
$worker= new GearmanWorker();
$timer = time();
$worker->addServer();
$worker->addFunction("skele_log", "prayvine_logger");

//echo "Start prayer notify worker".PHP_EOL;
$worker->setTimeout(195000);


while ($worker->work()){

};

/**
 * save log in database
 * @param type $job
 */
function prayvine_logger($job) {
  //database date
  $user = 'prayvinedevDBA';
  $pass = 'prayvinedevDBPASS';
  $host = 'localhost';
  $database = 'prayvinedevDB';
  static $connection = 0;//use static variable to avoid reconnection each time log is called
  if (empty($connection)) {
    $connection = prayvine_logger_connect($host,$user,$pass);//
  }else {
    if (!mysql_ping($connection)) {

    }
  }
  //echo "Start logger function".PHP_EOL;
  $data_json = $job->workload();
  $data = json_decode($data_json,TRUE);
  prayvine_logger_save($data,$connection,$database);
  //echo "End logger function".PHP_EOL;
}
