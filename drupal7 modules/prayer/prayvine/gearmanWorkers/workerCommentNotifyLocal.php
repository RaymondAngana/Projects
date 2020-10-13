<?php
//require_once '../../../../default/settings.php';
global $conf;

if (isset($_SERVER['REMOTE_ADDR'])) {
  print "...";
  exit(1);
}

// drupal root and include
chdir(dirname(__FILE__));
define('DRUPAL_ROOT', '../../../../../..');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
require_once DRUPAL_ROOT . '/sites/all/modules/contrib/geophp/geoPHP/geoPHP.inc';//it breaks if not is called
require_once DRUPAL_ROOT . '/modules/system/system.module';//it breaks if not is called

// you might need to define some of these if the script is not called from a webpage
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';             // required, else drupal will complain
$_SERVER['HTTP_HOST'] = 'prayvine.prometdev.com';//CHNAGE THIS ON SKELE AND LOCAL $conf['path_dev'];//'skele.prayvine.org'; // optional but required for multi site configs
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
$worker->addFunction("comment_notify_local", "prayvine_comment_notify");
$worker->addFunction("comment_notify_check", "prayvine_comment_notify_check");
$worker->setTimeout(60000);
//echo "Start comment notify worker";//do not use as on deamon options it messes up http header
while ($worker->work()){

};
/**
 * send email when comment is posted on topic
 * @param type $job
 */
function prayvine_comment_notify($job) {
  //input is comment object
  //echo "Start comment notify function".PHP_EOL;
  $data_json = $job->workload();
  $data = json_decode($data_json,TRUE);
  global $user;
  $user = (object)$data['user'];
  prayvine_notify_comment_insert((object)$data['comment'],(object)$data['user']);
  //echo "End comment notify function".PHP_EOL;
}
/**
 * check if worker is live
 * @param type $job
 * @return int
 */

function prayvine_comment_notify_check($job) {
  //echo "check".PHP_EOL;
  return 1;
}
