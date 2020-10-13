<?php

/**
 * @file
 * Gearman Worker Prayer Request for Staging.
 */

global $conf;

if (isset($_SERVER['REMOTE_ADDR'])) {
  print "...";
  exit(1);
}

// Include requred drupal files.
define('DRUPAL_ROOT', '/var/www/sites/prayvine.prometstaging.com/www');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

// It breaks if this file is not called.
require_once DRUPAL_ROOT . '/sites/all/modules/contrib/geophp/geoPHP/geoPHP.inc';
require_once DRUPAL_ROOT . '/modules/system/system.module';
require_once DRUPAL_ROOT . '/sites/all/modules/contrib/smtp/smtp.module';

// You might need to define some of these if the script is not called from a webpage.
// Required, else drupal will complain.
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

// CHANGE THIS ON SKELE AND LOCAL $conf['path_dev'];
// Optional but required for multi site configs.
$_SERVER['HTTP_HOST'] = 'prayvine.prometstaging.com';

// Optional.
$_SERVER['REQUEST_METHOD'] = 'GET';

// Optional.
$_SERVER['SCRIPT_NAME'] = '/' . basename(__FILE__);
$_SERVER['SERVER_SOFTWARE'] = NULL;
set_time_limit(6000);

// Load Drupal.
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once DRUPAL_ROOT . '/sites/default/settings.php';
$worker = new GearmanWorker();
$timer = time();
$worker->addServer();
$worker->addFunction("request_notify_skele_staging", "prayvine_request_notify");
$worker->addFunction("request_notify_check", "prayvine_request_notify_check");
$worker->setTimeout(50000);

// Echo "Startrequest notify worker".
while ($worker->work()) {

};

/**
 * Send emails when request is posted on topic.
 */
function prayvine_request_notify($job) {
  $data_json = $job->workload();
  $data = json_decode($data_json, TRUE);
  global $user;
  $user = (object) $data['user'];
  prayvine_notify_request_insert((object) $data['request'], (object) $data['user']);
}

/**
 * Check if worker is live.
 */
function prayvine_request_notify_check($job) {
  watchdog('gearman', 'gearman staging');
  return 'staging';
}
