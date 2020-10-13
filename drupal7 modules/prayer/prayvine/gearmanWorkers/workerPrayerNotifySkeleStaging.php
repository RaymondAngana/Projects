<?php

/**
 * @file
 * Gearman Worker Prayer for Staging.
 */

if (isset($_SERVER['REMOTE_ADDR'])) {
  print "...";
  exit(1);
}

// Include requred drupal files.
define('DRUPAL_ROOT', '/var/www/sites/prayvine.prometstaging.com/www');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

// It breaks if not called.
require_once DRUPAL_ROOT . '/sites/all/modules/contrib/geophp/geoPHP/geoPHP.inc';
require_once DRUPAL_ROOT . '/modules/system/system.module';

// You might need to define some of these if the script is not called from a webpage.
// Required, else drupal will complain.
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

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
$worker->addFunction("prayer_notify_skele_staging", "prayvine_prayer_notify");
$worker->addFunction("prayer_notify_check", "prayvine_prayer_notify_check");

$worker->setTimeout(65000);
while ($worker->work()) {

};

/**
 * Send emails when prayer is posted on topic.
 */
function prayvine_prayer_notify($job) {
  $data_json = $job->workload();
  $data = json_decode($data_json, TRUE);
  global $user;
  $user = (object) $data['user'];
  prayvine_notify_prayer_insert((object) $data['prayer'], (object) $data['user']);
}

/**
 * Check if worker is live.
 */
function prayvine_prayer_notify_check($job) {
  watchdog('gearman', 'gearman staging');
  return 'staging';
}
