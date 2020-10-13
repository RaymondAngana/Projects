<?php
/**
 * @file
 * Encrypt the PIN and other columns.
 */

/**
 * Root directory of Drupal installation.
 */
define('DRUPAL_ROOT', getcwd());
// No time limit.
set_time_limit(0);

// Set some server variables.
$_SERVER['HTTP_HOST'] = 'propco.prometstaging.com';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_METHOD'] = 'POST';

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo "Updating PIN Codes." . PHP_EOL;
$results = db_select('node', 'n')
  ->condition('type', 'pin')
  ->fields('n',array('nid', 'title'))
  ->execute();

echo 'Updating, please wait...' . PHP_EOL;
while($row = $results->fetchAssoc()) {
  echo '+ ' . $row['nid'] . ':' . $row['title'] . PHP_EOL;
  $node = node_load($row['nid']);
  $title = $row['title'];
  $encrypted_pin = _propco_encryption_pin_encrypt_decrypt($title, 'encrypt');
  $node->title = $encrypted_pin;
  node_save($node);

  $alias = _propco_encryption_load_path($node->nid, $title);
  $path = array('pid' => $alias['pid'], 'source' => "node/$node->nid", 'alias' => "content/$title");
  path_save($path);
}

