<?php

/**
 * @file
 * Contains prayvine related dashboard customizations.
 */

define('PRAYVINE_DB_TOPIC_MINISTRY', 1);
define('PRAYVINE_DB_TOPIC_NON_MINISTRY', 0);
define('PRAYVINE_DB_TOTAL', 0);
define('PRAYVINE_DB_DAILY', 1);
define('PRAYVINE_DB_MONTHLY', 2);
define('PRAYVINE_DB_START_DATE', 'start_date');
define('PRAYVINE_DB_END_DATE', 'end_date');

/**
 * Main callback for the dashboard page.
 */
function _prayvine_dashboard_main($start_date, $end_date) {
  drupal_add_css(drupal_get_path('module', 'prayvine_dashboard') . '/css/dashboard.css');

  $header = array_values(_prayvine_dashboard_headers());
  array_unshift($header, t('Date'));
  list($rows_daily, $rows_monthly) = _prayvine_dashboard_get_rows($start_date, $end_date);

  $html = theme('link', array(
    'text' => t('Download CSV'),
    'path' => '/admin/reports/prayvine_dashboard_csv',
    'options' => array(
      'attributes' => array(
        'class' => array('')
      ),
      'html' => FALSE,
      'query' => array(
        PRAYVINE_DB_START_DATE => $start_date,
        PRAYVINE_DB_END_DATE => $end_date,
      ),
    )
  ));

  $html .= theme('table', array(
    'header' => $header,
    'rows' => $rows_monthly,
    'attributes' => array(
      'class' => array('dashboard-main-metrics')
    ),
  ));

  $html .= theme('table', array(
    'header' => $header,
    'rows' => $rows_daily,
    'attributes' => array(
      'class' => array('dashboard-main-metrics')
    ),
  ));

  return $html;
}

/**
 * Starting point for dashboard.
 */
function _prayvine_dashboard_main_form($form, &$form_state) {
  if (isset($form_state['storage'][PRAYVINE_DB_START_DATE]) && isset($form_state['storage'][PRAYVINE_DB_START_DATE])) {
    $start_date = $form_state['storage'][PRAYVINE_DB_START_DATE];
    $end_date = $form_state['storage'][PRAYVINE_DB_END_DATE];
  }

  $form[PRAYVINE_DB_START_DATE] = array(
    '#type' => 'date_popup',
    '#date_format' => 'Y-m-d',
    '#default_value' => isset($start_date) ? $start_date : date('Y-m-d'),
    '#title' => t('Start Date'),
  );

  $form[PRAYVINE_DB_END_DATE] = array(
    '#type' => 'date_popup',
    '#date_format' => 'Y-m-d',
    '#default_value' => isset($end_date) ? $end_date : date('Y-m-d'),
    '#title' => t('End Date'),
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Filter'),
  );

  if (isset($start_date) && isset($end_date)) {
    $form['dashboard'] = array(
      '#markup' => _prayvine_dashboard_main($start_date, $end_date)
    );
  }

  return $form;
}

/**
 * Main form submit handler.
 */
function _prayvine_dashboard_main_form_submit($form, &$form_state) {
  $form_state['storage'][PRAYVINE_DB_START_DATE] = $form_state['values'][PRAYVINE_DB_START_DATE];
  $form_state['storage'][PRAYVINE_DB_END_DATE] = $form_state['values'][PRAYVINE_DB_END_DATE];
  $form_state['rebuild'] = TRUE;
}

/**
 * Main callback for the dashboard page as csv.
 */
function _prayvine_dashboard_main_csv() {
  $header = array_values(_prayvine_dashboard_headers());
  array_unshift($header, t('Date'));

  $params = drupal_get_query_parameters();
  $start_date = $params[PRAYVINE_DB_START_DATE];
  $end_date = $params[PRAYVINE_DB_END_DATE];
  list($rows_daily, $rows_monthly) = _prayvine_dashboard_get_rows($start_date, $end_date);

  // Add necessary headers for browsers.
  drupal_add_http_header('Content-Type', 'text/csv; utf-8');
  drupal_add_http_header('Content-Disposition', 'attachment; filename = dashboard.csv');

  // Instead of writing down to a file we write to the output stream.
  $fh = fopen('php://output', 'w');

  // Form header.
  fputcsv($fh, $header);

  // Write data in the CSV format.
  foreach ($rows_monthly as $row) {
    fputcsv($fh, $row);
  }

  // Spacer.
  fputcsv($fh);

  // Form header.
  fputcsv($fh, $header);

  // Write data in the CSV format.
  foreach ($rows_daily as $row) {
    fputcsv($fh, $row);
  }

  // Close the stream.
  fclose($fh);
}

/**
 * Get headers as array.
 */
function _prayvine_dashboard_headers() {
  return array(
    '1' => '1. Communities of type = ministry.',
    '2' => '2. Communities of type = not ministry.',
    '3' => '3. New members of communities of type = ministry.',
    '4' => '4. New post type = written prayer by user type = ministry communicator in communities of type = ministry.',
    '5' => '5. New post type = written prayer by user type = NOT ministry communicator in communities of type = ministry.',
    '6' => '6. New post type = prayer request in communities of type = ministry.',
    '7' => '7. New post type = ministry update in communities of type = ministry',
    '8' => '8. New amen clicks in communities of type = ministry.',
    '9' => '9. New pray silently clicks in communities of type = ministry.',
    '10' => '10. New "prayers" (sum of amen clicks + pray silently clicks + written prayers) in communities of type = ministry.',
  );
}

/**
 * Combine into a single map.
 */
function _pravine_dashboard_build_map(&$map, $total, $key) {
  foreach ($total as $_key => $value) {
    if (array_key_exists($_key, $map)) {
      $map[$_key][$key] += $value->count;
    }
    else {
      $map[$_key] = array($key => $value->count);
    }
  }
}

/**
 * Arrange map presentation.
 */
function _pravine_dashboard_present_map(&$map) {
  $subheaders = _prayvine_dashboard_headers();
  $rows = array();
  foreach ($map as $_key => $value) {
    $row = array();
    $row[] = $_key;
    foreach (array_keys(_prayvine_dashboard_headers()) as $_subkey) {
      if (array_key_exists($_subkey, $value)) {
        $row[] = number_format($map[$_key][$_subkey]);
      }
      else {
        $row[] = 0;
      }
    }
    $rows[] = $row;
  }
  return $rows;
}

/**
 * Get results as array of arrays.
 */
function _prayvine_dashboard_get_rows($start_date, $end_date) {
  $row = array();
  $total_prayers = 0;
  $daily_prayers = 0;
  $monthly_prayers = 0;

  $map_daily = array();
  $map_monthly = array();

  // 1. Aggregate total and new count of communities of type = ministry.
  $daily = _prayvine_dashboard_topic_count(
    $start_date,
    $end_date,
    PRAYVINE_DB_TOPIC_MINISTRY,
    PRAYVINE_DB_DAILY
  );
  _pravine_dashboard_build_map($map_daily, $daily, '1');

  // 2. Aggregate total and new count of communities of type = not ministry.
  $daily = _prayvine_dashboard_topic_count(
    $start_date,
    $end_date,
    PRAYVINE_DB_TOPIC_MINISTRY,
    PRAYVINE_DB_DAILY,
    TRUE
  );
  _pravine_dashboard_build_map($map_daily, $daily, '2');

  // 3. Aggregate total and new members of communities of type = ministry.
  $daily = _prayvine_dashboard_member_count($start_date, $end_date, PRAYVINE_DB_DAILY);
  _pravine_dashboard_build_map($map_daily, $daily, '3');

  // 4. Aggregate total and new post type = written prayer by user type = ministry communicator in communities of type = ministry.
  $daily = _prayvine_dashboard_mc_prayers($start_date, $end_date, PRAYVINE_DB_DAILY);
  _pravine_dashboard_build_map($map_daily, $daily, '4');

  // 5. Aggregate total and new post type = written prayer by user type = NOT ministry communicator in communities of type = ministry.
  $daily = _prayvine_dashboard_mc_prayers(
    $start_date,
    $end_date,
    PRAYVINE_DB_DAILY,
    TRUE
  );
  _pravine_dashboard_build_map($map_daily, $daily, '5');

  // 6. Aggregate total and new post type = prayer request in communities of type = ministry.
  $daily = _prayvine_dashboard_prayer_request($start_date, $end_date, PRAYVINE_DB_DAILY);
  _pravine_dashboard_build_map($map_daily, $daily, '6');

  // 7. Aggregate total and new post type = ministry update in communities of type = ministry.
  $daily = _prayvine_dashboard_ministry_update($start_date, $end_date, PRAYVINE_DB_DAILY);
  _pravine_dashboard_build_map($map_daily, $daily, '7');

  // 8. Aggregate total and new amen clicks in communities of type = ministry.
  $daily = _prayvine_dashboard_amen_clicks($start_date, $end_date, PRAYVINE_DB_DAILY);
  _pravine_dashboard_build_map($map_daily, $daily, '8');

  // 9. Aggregate total and new pray silently clicks in communities of type = ministry.
  $daily = _prayvine_dashboard_silent_prayer($start_date, $end_date, PRAYVINE_DB_DAILY);
  _pravine_dashboard_build_map($map_daily, $daily, '9');
  $daily = _prayvine_dashboard_silent_prayer_comments($start_date, $end_date, PRAYVINE_DB_DAILY);
  _pravine_dashboard_build_map($map_daily, $daily, '9');
  $daily = _prayvine_dashboard_silent_prayer_prayer_request($start_date, $end_date, PRAYVINE_DB_DAILY);
  _pravine_dashboard_build_map($map_daily, $daily, '9');

  // 10. Aggregate total and new "prayers" (sum of amen clicks + pray silently clicks + written prayers) in communities of type = ministry.
  _prayvine_dashboard_get_total_prayers($map_daily);

  ksort($map_daily);
  $map_monthly = _prayvine_dashboard_summarize_monthly($map_daily);
  ksort($map_monthly);

  $present_daily = _pravine_dashboard_present_map($map_daily);
  $present_monthly = _pravine_dashboard_present_map($map_monthly);

  return array($present_daily, $present_monthly);
}

/**
 * Summarize daily counts to monthly.
 */
function _prayvine_dashboard_summarize_monthly($map_daily) {
  $map_monthly = array();
  foreach ($map_daily as $_key => $daily) {
    $key = date('Y-m', strtotime($_key));
    if (!array_key_exists($key, $map_monthly)) {
      $map_monthly[$key] = array();
    }

    foreach ($daily as $type => $metric) {
      if (!array_key_exists($type, $map_monthly[$key])) {
        $map_monthly[$key][$type] = 0;
      }
      $map_monthly[$key][$type] += $daily[$type];
    }
  }
  return $map_monthly;
}

/**
 * Counts the created topic.
 */
function _prayvine_dashboard_topic_count($start_date, $end_date, $ministry, $interval = PRAYVINE_DB_DAILY, $not = FALSE) {
  $query = db_select('node', 'n');
  $query->addExpression('count(1)', 'count');
  $query->leftJoin('field_data_field_ministry', 'm', 'n.nid = m.entity_id');
  $query->condition('n.type', 'topic');

  $tx_start = strtotime(date($start_date . ' 00:00:00'));
  $tx_end = strtotime(date($end_date . ' 23:59:59'));

  $query->condition('n.created', $tx_start, '>=');
  $query->condition('n.created', $tx_end, '<=');

  if ($not) {
    $query->condition('m.field_ministry_value', $ministry, '<>');
  }
  else {
    $query->condition('m.field_ministry_value', $ministry);
  }

  if ($interval == PRAYVINE_DB_DAILY) {
    $query->addExpression("date_format(from_unixtime(n.created), '%Y-%m-%d')", 'date');
    $query->groupBy('date');
  }
  elseif ($interval == PRAYVINE_DB_MONTHLY) {
    $query->addExpression("date_format(from_unixtime(n.created), '%Y-%m')", 'date');
    $query->groupBy('date');
  }

  $result = $query->execute();
  return $result->fetchAllAssoc('date');
}

/**
 * Counts the number of members.
 */
function _prayvine_dashboard_member_count($start_date, $end_date, $interval = PRAYVINE_DB_TOTAL) {
  $query = db_select('node', 'n');
  $query->addExpression('count(1)', 'count');
  $query->leftJoin('field_data_field_ministry', 'm', 'n.nid = m.entity_id');
  $query->leftJoin('prayvine_invites', 'i', 'n.nid = i.nid');
  $query->condition('n.type', 'topic');
  $query->condition('m.field_ministry_value', PRAYVINE_DB_TOPIC_MINISTRY);
  $query->isNotNull('i.claimed_uid');

  $tx_start = strtotime($start_date);
  $tx_end = strtotime($end_date);

  $tx_start = date('Y-m-d ', $tx_start) . ' 00:00:00';
  $tx_end = date('Y-m-d', $tx_end) . ' 23:59:59';

  $query->condition('i.first_access', $tx_start, '>=');
  $query->condition('i.first_access', $tx_end, '<=');

  if ($interval == PRAYVINE_DB_DAILY) {
    $query->addExpression("date_format(i.first_access, '%Y-%m-%d')", 'date');
    $query->groupBy('date');
  }
  elseif ($interval == PRAYVINE_DB_MONTHLY) {
    $query->addExpression("date_format(i.first_access, '%Y-%m')", 'date');
    $query->groupBy('date');
  }

  $result = $query->execute();
  return $result->fetchAllAssoc('date');
}

/**
 * Counts the number of prayer_request.
 */
function _prayvine_dashboard_prayer_request($start_date, $end_date, $interval = PRAYVINE_DB_TOTAL) {
  $query = db_select('node', 'n');
  $query->addExpression('count(1)', 'count');
  $query->leftJoin('field_data_field_ministry', 'm', 'n.nid = m.entity_id');
  $query->leftJoin('field_data_field_topic_id', 'topic_id', 'n.nid = topic_id.field_topic_id_value');
  $query->leftJoin('node', 'npr', 'npr.nid = topic_id.entity_id');
  $query->condition('n.type', 'topic');
  $query->condition('npr.type', 'prayer_request');
  $query->condition('m.field_ministry_value', PRAYVINE_DB_TOPIC_MINISTRY);
  $query->isNotNull('npr.nid');

  $tx_start = strtotime(date($start_date . ' 00:00:00'));
  $tx_end = strtotime(date($end_date . ' 23:59:59'));

  $query->condition('npr.created', $tx_start, '>=');
  $query->condition('npr.created', $tx_end, '<=');

  if ($interval == PRAYVINE_DB_DAILY) {
    $query->addExpression("date_format(from_unixtime(npr.created), '%Y-%m-%d')", 'date');
    $query->groupBy('date');
  }
  elseif ($interval == PRAYVINE_DB_MONTHLY) {
    $query->addExpression("date_format(from_unixtime(npr.created), '%Y-%m')", 'date');
    $query->groupBy('date');
  }

  $result = $query->execute();
  return $result->fetchAllAssoc('date');
}

/**
 * Counts the number of ministry_update.
 */
function _prayvine_dashboard_ministry_update($start_date, $end_date, $interval = PRAYVINE_DB_TOTAL) {
  // 7. Aggregate total and new post type = ministry update in communities of type = ministry.
  $query = db_select('node', 'n');
  $query->addExpression('count(1)', 'count');
  $query->leftJoin('field_data_field_ministry', 'm', 'n.nid = m.entity_id');
  $query->leftJoin('comment', 'c', 'n.nid = c.nid');
  $query->condition('n.type', 'topic');
  $query->condition('m.field_ministry_value', PRAYVINE_DB_TOPIC_MINISTRY);
  $query->isNotNull('c.cid');

  $tx_start = strtotime(date($start_date . ' 00:00:00'));
  $tx_end = strtotime(date($end_date . ' 23:59:59'));

  $query->condition('c.created', $tx_start, '>=');
  $query->condition('c.created', $tx_end, '<=');

  if ($interval == PRAYVINE_DB_DAILY) {
    $query->addExpression("date_format(from_unixtime(c.created), '%Y-%m-%d')", 'date');
    $query->groupBy('date');
  }
  elseif ($interval == PRAYVINE_DB_MONTHLY) {
    $query->addExpression("date_format(from_unixtime(c.created), '%Y-%m')", 'date');
    $query->groupBy('date');
  }

  $result = $query->execute();
  return $result->fetchAllAssoc('date');;
}

/**
 * Counts the number of amen clicks.
 */
function _prayvine_dashboard_amen_clicks($start_date, $end_date, $interval = PRAYVINE_DB_TOTAL) {
  // 8. Aggregate total and new amen clicks in communities of type = ministry.
  $query = db_select('node', 'n');
  $query->addExpression('count(1)', 'count');
  $query->leftJoin('field_data_field_ministry', 'm', 'n.nid = m.entity_id');
  $query->leftJoin('field_data_field_topic_id', 'topic_id', 'n.nid = topic_id.field_topic_id_value');
  $query->leftJoin('node', 'np', 'np.nid = topic_id.entity_id');
  $query->leftJoin('prayvine_prayer_amens', 'amen', 'np.nid = amen.nid');
  $query->condition('n.type', 'topic');
  $query->condition('np.type', 'prayer');
  $query->condition('m.field_ministry_value', PRAYVINE_DB_TOPIC_MINISTRY);
  // No sure whether to set amen.status = 0 or 1.
  $query->isNotNull('amen.nid');

  $tx_start = strtotime($start_date);
  $tx_end = strtotime($end_date);

  $tx_start = date('Y-m-d ', $tx_start) . ' 00:00:00';
  $tx_end = date('Y-m-d', $tx_end) . ' 23:59:59';

  $query->condition('amen.updated', $tx_start, '>=');
  $query->condition('amen.updated', $tx_end, '<=');

  if ($interval == PRAYVINE_DB_DAILY) {
    $query->addExpression("date_format(amen.updated, '%Y-%m-%d')", 'date');
    $query->groupBy('date');
  }
  elseif ($interval == PRAYVINE_DB_MONTHLY) {
    $query->addExpression("date_format(amen.updated, '%Y-%m')", 'date');
    $query->groupBy('date');
  }

  $result = $query->execute();
  return $result->fetchAllAssoc('date');
}

/**
 * Counts the number of silent prayers on prayer_requests.
 */
function _prayvine_dashboard_silent_prayer_prayer_request($start_date, $end_date, $interval = PRAYVINE_DB_TOTAL) {
  // 9. Aggregate total and new pray silently clicks in communities of type = ministry.
  $query = db_select('prayvine_logs', 'log');
  $query->addExpression('count(1)', 'count');
  $query->leftJoin('node', 'n', 'log.content_id = n.nid');
  $query->leftJoin('field_data_field_topic_id', 't', 't.entity_id = n.nid');
  $query->leftJoin('node', 'tn', 't.field_topic_id_value = tn.nid');
  $query->leftJoin('field_data_field_ministry', 'm', 'n.nid = m.entity_id');
  $query->condition('n.type', 'prayer_request');
  $query->condition('log.type', 'pray_silently');
  $query->condition('tn.type', 'topic');
  $query->condition('m.field_ministry_value', PRAYVINE_DB_TOPIC_MINISTRY);
  // No sure whether to set amen.status = 0 or 1.
  $query->isNotNull('tn.nid');

  $tx_start = strtotime(date($start_date . ' 00:00:00'));
  $tx_end = strtotime(date($end_date . ' 23:59:59'));

  $query->condition('log.timestamp', $tx_start, '>=');
  $query->condition('log.timestamp', $tx_end, '<=');

  if ($interval == PRAYVINE_DB_DAILY) {
    $query->addExpression("date_format(from_unixtime(log.timestamp), '%Y-%m-%d')", 'date');
    $query->groupBy('date');
  }
  elseif ($interval == PRAYVINE_DB_MONTHLY) {
    $query->addExpression("date_format(from_unixtime(log.timestamp), '%Y-%m')", 'date');
    $query->groupBy('date');
  }

  $result = $query->execute();
  return $result->fetchAllAssoc('date');
}

/**
 * Counts the number of silent prayers on comments.
 */
function _prayvine_dashboard_silent_prayer_comments($start_date, $end_date, $interval = PRAYVINE_DB_TOTAL) {
  // 9. Aggregate total and new pray silently clicks in communities of type = ministry.
  $query = db_select('prayvine_logs', 'log');
  $query->addExpression('count(1)', 'count');
  $query->leftJoin('comment', 'c', 'log.content_id = c.cid');
  $query->leftJoin('node', 'cn', 'c.nid = cn.nid');
  $query->leftJoin('field_data_field_ministry', 'm', 'm.entity_id = cn.nid');
  $query->condition('log.type', 'pray_silently');
  $query->condition('cn.type', 'topic');
  $query->condition('m.field_ministry_value', PRAYVINE_DB_TOPIC_MINISTRY);
  // No sure whether to set amen.status = 0 or 1.
  $query->isNotNull('cn.nid');

  $tx_start = strtotime(date($start_date . ' 00:00:00'));
  $tx_end = strtotime(date($end_date . ' 23:59:59'));

  $query->condition('log.timestamp', $tx_start, '>=');
  $query->condition('log.timestamp', $tx_end, '<=');

  if ($interval == PRAYVINE_DB_DAILY) {
    $query->addExpression("date_format(from_unixtime(log.timestamp), '%Y-%m-%d')", 'date');
    $query->groupBy('date');
  }
  elseif ($interval == PRAYVINE_DB_MONTHLY) {
    $query->addExpression("date_format(from_unixtime(log.timestamp), '%Y-%m')", 'date');
    $query->groupBy('date');
  }

  $result = $query->execute();
  return $result->fetchAllAssoc('date');
}

/**
 * Counts the number of silent prayers.
 */
function _prayvine_dashboard_silent_prayer($start_date, $end_date, $interval = PRAYVINE_DB_TOTAL) {
  // 9. Aggregate total and new pray silently clicks in communities of type = ministry.
  $query = db_select('node', 'n');
  $query->addExpression('count(1)', 'count');
  $query->leftJoin('field_data_field_ministry', 'm', 'n.nid = m.entity_id');
  $query->leftJoin('prayvine_silent_log', 'silent', 'n.nid = silent.nid');
  $query->condition('n.type', 'topic');
  $query->condition('m.field_ministry_value', PRAYVINE_DB_TOPIC_MINISTRY);
  // No sure whether to set amen.status = 0 or 1.
  $query->isNotNull('silent.nid');

  $tx_start = strtotime($start_date);
  $tx_end = strtotime($end_date);

  $tx_start = date('Y-m-d ', $tx_start) . ' 00:00:00';
  $tx_end = date('Y-m-d', $tx_end) . ' 23:59:59';

  $query->condition('silent.created', $tx_start, '>=');
  $query->condition('silent.created', $tx_end, '<=');

  if ($interval == PRAYVINE_DB_DAILY) {
    $query->addExpression("date_format(silent.created, '%Y-%m-%d')", 'date');
    $query->groupBy('date');
  }
  elseif ($interval == PRAYVINE_DB_MONTHLY) {
    $query->addExpression("date_format(silent.created, '%Y-%m')", 'date');
    $query->groupBy('date');
  }

  $result = $query->execute();
  return $result->fetchAllAssoc('date');
}

/**
 * Counts the number of prayers started by ministry communicators.
 */
function _prayvine_dashboard_mc_prayers($start_date, $end_date, $interval = PRAYVINE_DB_TOTAL, $not = FALSE) {
  // 4. Aggregate total and new post type = written prayer by user type = ministry communicator in communities of type = ministry.
  $mcs = prayvine_dashboard_get_ministry_communicators();

  if (count($mcs) == 0 && !$not) {
    return 0;
  }

  $query = db_select('node', 'n');
  $query->addExpression('count(1)', 'count');
  $query->leftJoin('field_data_field_ministry', 'm', 'n.nid = m.entity_id');
  $query->leftJoin('field_data_field_topic_id', 'topic_id', 'n.nid = topic_id.field_topic_id_value');
  $query->leftJoin('node', 'np', 'np.nid = topic_id.entity_id');
  $query->condition('n.type', 'topic');
  $query->condition('np.type', 'prayer');
  $query->condition('m.field_ministry_value', PRAYVINE_DB_TOPIC_MINISTRY);
  // No sure whether to set amen.status = 0 or 1.
  $query->isNotNull('np.nid');

  $tx_start = strtotime(date($start_date . ' 00:00:00'));
  $tx_end = strtotime(date($end_date . ' 23:59:59'));

  $query->condition('np.created', $tx_start, '>=');
  $query->condition('np.created', $tx_end, '<=');

  if (count($mcs) > 0) {
    if ($not) {
      $query->condition('np.uid', $mcs, 'not in');
    }
    else {
      $query->condition('np.uid', $mcs);
    }
  }

  if ($interval == PRAYVINE_DB_DAILY) {
    $query->addExpression("date_format(from_unixtime(np.created), '%Y-%m-%d')", 'date');
    $query->groupBy('date');
  }
  elseif ($interval == PRAYVINE_DB_MONTHLY) {
    $query->addExpression("date_format(from_unixtime(np.created), '%Y-%m')", 'date');
    $query->groupBy('date');
  }

  $result = $query->execute();
  return $result->fetchAllAssoc('date');
}

/**
 * Adds header items 4,5,8,9.
 */
function _prayvine_dashboard_get_total_prayers(&$map) {
  foreach ($map as $date => &$row) {
    $row4 = isset($row['4']) ? $row['4'] : 0;
    $row5 = isset($row['5']) ? $row['5'] : 0;
    $row8 = isset($row['8']) ? $row['8'] : 0;
    $row9 = isset($row['9']) ? $row['9'] : 0;
    $row['10'] = $row4 + $row5 + $row8 + $row9;
  }
  unset($row);
}
