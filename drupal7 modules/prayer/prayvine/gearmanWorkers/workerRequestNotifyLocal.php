<?php

//require_once '../../../../default/settings.php';
global $conf;

if (isset($_SERVER['REMOTE_ADDR'])) {
  print "...";
  exit(1);
}

// drupal root and include
echo getcwd() . "\n";
chdir(dirname(__FILE__));
echo getcwd() . "\n";
define('DRUPAL_ROOT', '../../../../../..');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
require_once DRUPAL_ROOT . '/sites/all/modules/contrib/geophp/geoPHP/geoPHP.inc';//it breaks if not is called
require_once DRUPAL_ROOT . '/modules/system/system.module';//it breaks if not is called
require_once DRUPAL_ROOT . '/sites/all/modules/contrib/smtp/smtp.module';
//
// you might need to define some of these if the script is not called from a webpage
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';             // required, else drupal will complain
$_SERVER['HTTP_HOST'] = 'prayvine.prometdev.com';//CHNAGE THIS ON SKELE AND LOCAL $conf['path_dev']; // optional but required for multi site configs
$_SERVER['REQUEST_METHOD'] = 'GET';                // optional
$_SERVER['SCRIPT_NAME'] = '/' . basename(__FILE__);// optional
$_SERVER['SERVER_SOFTWARE'] = NULL;
set_time_limit(6000);
// Load Drupal
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once DRUPAL_ROOT . '/sites/default/settings.php';
$worker= new GearmanWorker();
$timer = time();
$worker->addServer($conf['gearman_local_server']);
$worker->addFunction("request_notify_local", "prayvine_request_notify");
$worker->addFunction("request_notify_check", "prayvine_request_notify_check");
$worker->setTimeout(50000);
echo "Startrequest notify worker".PHP_EOL;
while ($worker->work()){

};
/**
 * send emails when request is posted on topic
 * @param type $job
 */
function prayvine_request_notify($job) {
  //input is comment object
  //echo "Start request notify function".PHP_EOL;
  $data_json = $job->workload();
  $data = json_decode($data_json,TRUE);
  global $user;
  $user = (object)$data['user'];
  prayvine_notify_request_insert((object)$data['request'],(object)$data['user']);
  //echo "End request notify function".PHP_EOL;
}
/**
 * check if worker is live
 * @param type $job
 * @return int
 */

function prayvine_request_notify_check($job) {
  return 1;
}
