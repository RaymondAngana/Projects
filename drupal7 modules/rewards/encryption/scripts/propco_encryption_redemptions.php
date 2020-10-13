<?php
/**
 * @file
 * Encrypt the other columns.
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

_propco_encrypt_lastnames();
_propco_encrypt_firstname();
_propco_encrypt_emails();
_propco_encrypt_address();

/**
 *  Encrypt Addresses.
 */
function _propco_encrypt_address() {
  echo "Converting Addresses." . PHP_EOL;
  $result = db_select('field_data_field_address', 'n')
    ->condition('bundle', 'redemption')
    ->fields('n',array(
          'entity_id',
          'field_address_thoroughfare',
          'field_address_premise',
          'field_address_locality',
          'field_address_administrative_area',
          'field_address_postal_code',
        )
      )
    ->execute();

  $nids = array();
  while($row = $result->fetchAssoc()) {
    $nids[] = array(
      'entity_id' => $row['entity_id'],
      'field_address_thoroughfare' => $row['field_address_thoroughfare'],
      'field_address_premise' => $row['field_address_premise'],
      'field_address_locality' => $row['field_address_locality'],
      'field_address_administrative_area' => $row['field_address_administrative_area'],
      'field_address_postal_code' => $row['field_address_postal_code'],
    );
  }

  foreach ($nids as $n) {
    $converted_add1 = _propco_encryption_pin_encrypt_decrypt($n['field_address_thoroughfare'], 'encrypt');
    $converted_add2 = _propco_encryption_pin_encrypt_decrypt($n['field_address_premise'], 'encrypt');
    $converted_add3 = _propco_encryption_pin_encrypt_decrypt($n['field_address_locality'], 'encrypt');
    $converted_add4 = _propco_encryption_pin_encrypt_decrypt($n['field_address_administrative_area'], 'encrypt');
    $converted_add5 = _propco_encryption_pin_encrypt_decrypt($n['field_address_postal_code'], 'encrypt');

    echo ' + encrypting address -> ' . $n['entity_id'] . PHP_EOL;
    db_update('field_data_field_address')
      ->fields(
        array(
          'field_address_thoroughfare' => $converted_add1,
          'field_address_premise' => $converted_add2,
          'field_address_locality' => $converted_add3,
          'field_address_administrative_area' => $converted_add4,
          'field_address_postal_code' => $converted_add5,
        )
      )
      ->condition('entity_id', $n['entity_id'])
      ->execute();
  }
}

/**
 *  Encrypt Emails.
 */
function _propco_encrypt_emails() {
  echo "Converting Emails." . PHP_EOL;
  $result = db_select('field_data_field_email', 'n')
    ->condition('bundle', 'redemption')
    ->fields('n',array('entity_id', 'field_email_email'))
    ->execute();

  $nids = array();
  while($row = $result->fetchAssoc()) {
    $nids[] = array(
      'entity_id' => $row['entity_id'],
      'field_email_email' => $row['field_email_email']
    );
  }

  foreach ($nids as $n) {
    $converted_text = _propco_encryption_pin_encrypt_decrypt($n['field_email_email'], 'encrypt');
    echo ' + encrypting -> ' . $n['entity_id'] . ':' . $n['field_email_email'] . PHP_EOL;
    db_update('field_data_field_email')
      ->fields(
        array(
          'field_email_email' => $converted_text,
        )
      )
      ->condition('entity_id', $n['entity_id'])
      ->execute();
  }
}

/**
 *  Encrypt Lastnames.
 */
function _propco_encrypt_lastnames() {
  echo "Converting Lastnames." . PHP_EOL;
  $result = db_select('field_data_field_last_name', 'n')
    ->condition('bundle', 'redemption')
    ->fields('n',array('entity_id', 'field_last_name_value'))
    ->execute();

  $nids = array();
  while($row = $result->fetchAssoc()) {
    $nids[] = array(
      'entity_id' => $row['entity_id'],
      'field_last_name_value' => $row['field_last_name_value'],
    );
  }

  foreach ($nids as $n) {
    $converted_text = _propco_encryption_pin_encrypt_decrypt($n['field_last_name_value'], 'encrypt');
    echo ' + encrypting -> ' . $n['entity_id'] . ':' . $n['field_last_name_value'] . PHP_EOL;
    db_update('field_data_field_last_name')
      ->fields(
        array(
          'field_last_name_value' => $converted_text
        )
      )
      ->condition('entity_id', $n['entity_id'])
      ->execute();
  }
}

/**
 *  Encrypt Firstnames.
 */
function _propco_encrypt_firstname() {
  echo "Converting Firstnames." . PHP_EOL;
  $result = db_select('field_data_field_first_name', 'n')
    ->condition('bundle', 'redemption')
    ->fields('n',array('entity_id', 'field_first_name_value'))
    ->execute();

  $nids = array();
  while($row = $result->fetchAssoc()) {
    $nids[] = array(
      'entity_id' => $row['entity_id'],
      'field_first_name_value' => $row['field_first_name_value'],
    );
  }

  foreach ($nids as $n) {
    $converted_text = _propco_encryption_pin_encrypt_decrypt($n['field_first_name_value'], 'encrypt');
    echo ' + encrypting -> ' . $n['entity_id'] . ':' . $n['field_first_name_value'] . PHP_EOL;
    db_update('field_data_field_first_name')
      ->fields(
        array(
          'field_first_name_value' => $converted_text,
        )
      )
      ->condition('entity_id', $n['entity_id'])
      ->execute();
  }
}



