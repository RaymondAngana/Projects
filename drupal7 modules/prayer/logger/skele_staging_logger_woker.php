<?php

/**
 * @file
 * Gearman Worker Prayer Request for Staging.
 */

// Include required files.
include_once '/var/www/sites/prayvine.prometdev.com/www/sites/all/modules/custom/prayvine_logger/prayvine_logger.module';
$worker = new GearmanWorker();
$timer = time();
$worker->addServer();
$worker->addFunction("skele_log_staging", "prayvine_logger");

$worker->setTimeout(195000);

while ($worker->work()) {

};

/**
 * Save log in database.
 */
function prayvine_logger($job) {
  $user = 'prayvinestgDBA';
  $pass = 'prayvinestgDBPASS';
  $host = 'localhost';
  $database = 'prayvinestgDB';
  static $connection = 0;
  if (empty($connection)) {
    $connection = prayvine_logger_connect($host, $user, $pass);
  }
  else {
    if (!mysql_ping($connection)) {

    }
  }
  $data_json = $job->workload();
  $data = json_decode($data_json, TRUE);
  prayvine_logger_save($data, $connection, $database);
}
