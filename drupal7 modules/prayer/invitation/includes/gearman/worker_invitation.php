<?php

/**
 * @file
 * Gearman Worker for handling invitations.
 *
 * This worker bootstraps Drupal because the job requires some Drupal functions.
 */

if (isset($_SERVER['REMOTE_ADDR'])) {
  exit(1);
}

// Change the current directory to docroot.
chdir(dirname(__FILE__));
define('DRUPAL_ROOT', '../../../../../../..');

// Bootstraping Drupal.
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

// For some reason it breaks if these are not called.
require_once DRUPAL_ROOT . '/sites/all/modules/contrib/geophp/geoPHP/geoPHP.inc';
require_once DRUPAL_ROOT . '/modules/system/system.module';

// Required settings for bootstrapping Drupal to execute jobs.
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

// This sets the url:value in rules, if executed via commandline, and this is
// executed via commandline.
if ($argv[1] == 'local') {
  $_SERVER['HTTP_HOST'] = 'localhost';
}
elseif ($argv[1] == 'dev') {
  $_SERVER['HTTP_HOST'] = 'prayvine.prometdev.com';
}
elseif ($argv[1] == 'staging') {
  $_SERVER['HTTP_HOST'] = 'prayvine.prometstaging.com';
}
elseif ($argv[1] == 'prod') {
  $_SERVER['HTTP_HOST'] = 'www.prayvine.org';
}


// Optional settings.
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['SCRIPT_NAME'] = '/' . basename(__FILE__);
$_SERVER['SERVER_SOFTWARE'] = NULL;
set_time_limit(6000);

// Load Drupal.
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
require_once DRUPAL_ROOT . '/sites/default/settings.php';

$worker = new GearmanWorker();
$timer = time();

// Local.
if (isset($conf['gearman_local_server'])) {
  $worker->addServer($conf['gearman_local_server']);
}
else {
  // Dev, Staging, Prod.
  $worker->addServer();
}


// The staging and dev server are sharing gearman server.  Hence, there is a
// need to have a distinction between dev and staging registered worker functions.
// Production and local have different gearman workers, no need for distinction.
// $argv[1] is the argument supplied in the supervisor.conf.
if ($argv[1] == 'dev') {
  $worker->addFunction("prayvine_invitation_gearman_invite_dev", "prayvine_invitation_invite");
}
elseif ($argv[1] == 'staging') {
  $worker->addFunction("prayvine_invitation_gearman_invite_staging", "prayvine_invitation_invite");
}
else {
  $worker->addFunction("prayvine_invitation_gearman_invite", "prayvine_invitation_invite");
}

$worker->addFunction("prayvine_invitation_gearman_check", "prayvine_invitation_check");
$worker->setTimeout(65000);

// Listen for jobs.
while ($worker->work()) {

};

/**
 * Sends invitations.
 */
function prayvine_invitation_invite($job) {
  $data_json = $job->workload();
  $data = json_decode($data_json, TRUE);

  $user = (object) $data['user'];
  $nid = $data['topic_nid'];
  $message = $data['message'];
  $emails = (array) $data['emails'];

  // Require common invite worker functions.
  _prayvine_invitation_send_invites($nid, $user, $message, $emails);
}

/**
 * Check if worker is alive.
 */
function prayvine_invitation_check($job) {
  return 1;
}

/**
 * Send email invites.
 */
function _prayvine_invitation_send_invites($nid, $user, $message, $emails) {
  if (module_exists('prayvinestat')) {
    prayvinestat_stat_event('send-invites');
  }

  $topic = node_load($nid);

  if ($user->uid != $topic->uid) {
    $author = user_load($topic->uid);
  }
  else {
    $author = $user;
  }

  $email_token = implode(', ', $emails);

  foreach ($emails as $email) {
    _prayvine_invitation_send_invite($email, $topic, $user, $author, $email_token, $message);
  }

  // All emails sent.
  // Optionally, add an email here to say that all inviations are sent.
}

/**
 * Send single email.
 */
function _prayvine_invitation_send_invite($email, $topic, $user, $author, $email_token, $message) {

  $email = trim($email);
  if (empty($email)) {
    return;
  }

  // Make sure that $strCode is unique.
  $invite_code = prayvine_generate_random_string(6);
  db_query('LOCK TABLE {prayvine_invites} WRITE');
  while (TRUE) {
    $count = db_query("select count(nid) from {prayvine_invites} where invite_code = ':invite_code'",
      [':invite_code' => $invite_code])->fetchField();
    if ($count == 0) {
      break;
    }
    $invite_code = prayvine_generate_random_string(6);
  }

  $invite_id = db_insert('prayvine_invites')
    ->fields([
      'mail' => $email,
      'nid' => $topic->nid,
      'status' => 1,
      'inviter_uid' => $user->uid,
      'invite_code' => $invite_code,
      'sent' => date('Y-m-d H:i:s'),
    ])
    ->execute();

  db_query('UNLOCK TABLES');

  $topic_title = $topic->title;
  $inviter_name = prayvine_get_name($user->uid);

  $page_url = prayvine_get_prayer_page_url($topic->nid);
  $footer = ' ';
  if (empty($topic->field_ministry[LANGUAGE_NONE][0]['value'])) {
    $ministry = 0;
  }
  else {
    $ministry = $topic->field_ministry[LANGUAGE_NONE][0]['value'];
  }

  $unsubscribe_link = prayvine_unsuscribe_link($invite_id);
  rules_invoke_event('prayvine_send_mail_send_invite', $user, $email, $invite_code, $inviter_name, $topic_title, $page_url, $footer, $unsubscribe_link, $email_token, $message, $ministry, $topic);

  if (module_exists('prayvinestat')) {
    prayvinestat_stat_event('email-sent');
  }

  if ($user->uid != $topic->uid && prayvine_wants_updates($topic->uid)) {
    rules_invoke_event('prayvine_send_mail_send_invite_update', $user, $email, $invite_code, $author->mail, $topic_title, $page_url, $footer, $message, $ministry, $topic);

    if (module_exists('prayvinestat')) {
      prayvinestat_stat_event('email-sent');
    }
  }
}
