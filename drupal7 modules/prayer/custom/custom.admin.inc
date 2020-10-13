<?php

/**
 * @file
 * Administration page callbacks for the Prayvine custom module.
 */

/**
 * Form constructor for Prayvine Prayer Request admin settings.
 */
function prayvine_custom_prayer_request_reminder_form($form, &$form_state) {
  global $base_url;
  $form = array();
  $header = array();
  $rows = array();

  $sql = "SELECT p.nid, n.nid as tid FROM {node} p
          INNER JOIN {field_data_field_want_reminder} w ON w.entity_id = p.nid AND w.bundle ='prayer_request'
          INNER JOIN {field_data_field_topic_id} t ON t.entity_id = p.nid AND t.bundle ='prayer_request'
          INNER JOIN {node} n ON t.field_topic_id_value = n.nid
          INNER JOIN {field_data_field_ministry} m ON m.entity_id = n.nid AND m.bundle ='topic'
          WHERE p.type = 'prayer_request'
          AND n.status = 1 AND m.field_ministry_value = 1
          AND w.field_want_reminder_value = 1
          ORDER BY p.created DESC";
  $result = db_query($sql);

  $header = array(
    'title' => t('Title'),
    'topic' => t('Topic'),
    'author' => t('Author'),
    'date' => t('Latest Post'),
    'reminder' => t('Reminder Days'),
    'operation' => t('Operation'),
  );

  foreach ($result as $k => $row) {
    $topic = node_load($row->tid);
    $request = node_load($row->nid);
    $author = user_load($request->uid);

    if (isset($request->nid)) {
      // Email reminder days value.
      $reminder_days = 0;
      if (isset($request->field_email_reminder_prayer[LANGUAGE_NONE][0]['value'])) {
        $reminder_days = $request->field_email_reminder_prayer[LANGUAGE_NONE][0]['value'];
      }

      // Get the latest post date.
      $latest_post = date("m/d/Y g:i", $request->created);
      $post_date = _prayvine_custom_get_latest_request_post_date($topic->nid);
      if ($post_date > 0 && $post_date > $request->created) {
        $latest_post = date("m/d/Y g:i", $post_date);
      }

      // If there are new post updates by ministry communicators, reset the
      // email reminder value of the prayer request to zero.
      if ($post_date > $request->created) {
        $request->field_email_reminder_prayer[LANGUAGE_NONE][0]['value'] = 0;
        node_save($request);
        $reminder_days = 0;
      }

      $rows[$row->nid] = array(
        'title' => ucwords($request->title),
        'topic' => ucwords(isset($topic->title) ? $topic->title : ''),
        'author' => $author->name,
        'date' => $latest_post,
        'reminder' => $reminder_days,
        'operation' => l(t('Edit'), $base_url . '/admin/prayvine/prayer-request/' . $request->nid . '/edit'),
      );
    }
  }

  $form['cron'] = array(
    '#type' => 'submit',
    '#value' => t('Run Cron'),
    '#suffix' => t('Click the button to trigger cron manually.'),
  );

  $form['requests'] = array(
    '#type' => 'tableselect',
    '#header' => $header,
    '#options' => $rows,
    '#disabled' => TRUE,
    '#multiple' => FALSE,
    '#weight' => 10,
    '#empty' => t('No prayer requests available.'),
  );

  $form['pager'] = array(
    '#markup' => theme('pager'),
    '#weight' => 12,
  );

  return $form;
}

/**
 * Form submission to manually run cron for prayer request reminder.
 */
function prayvine_custom_prayer_request_reminder_form_submit($form, &$form_state) {
  prayvine_ministry_prayer_post_reminder();
  drupal_set_message('Email Reminders sent.');
}

/**
 * Form constructor for Edit Prayer Request Date.
 */
function prayvine_custom_prayer_request_reminder_edit_form($form, &$form_state, $nid) {
  $form = array();

  $request = node_load($nid);
  if (isset($request->created)) {
    $form['nid'] = array(
      '#type' => 'hidden',
      '#default_value' => $request->nid,
    );

    $form['title'] = array(
      '#markup' => '<h2>Update Prayer Request Date</h2>',
    );

    $form['body'] = array(
      '#markup' => '<b>' . $request->title .
      '</b><br>' . $request->body[LANGUAGE_NONE][0]['value'],
    );

    $form['created'] = array(
      '#type' => 'textfield',
      '#title' => t('Date Posted'),
      '#default_value' => date('m/d/Y g:i', $request->created),
    );

    $form['reminder'] = array(
      '#type' => 'textfield',
      '#title' => t('Email Reminder Prayer'),
      '#default_value' => $request->field_email_reminder_prayer[LANGUAGE_NONE][0]['value'],
    );

    $form['cancel'] = array(
      '#type' => 'submit',
      '#value' => t('Cancel'),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Update'),
    );
  }
  else {
    drupal_set_message(t('Access Denied'), 'error');
  }

  return $form;
}

/**
 * Form submission to Edit Prayer Request Date.
 */
function prayvine_custom_prayer_request_reminder_edit_form_submit($form, &$form_state) {
  $values = $form_state['values'];

  if ($values['op'] == 'Update') {
    $node = node_load($values['nid']);
    if (isset($node->nid)) {
      // Update all other prayer and prayer requests inside the community.
      $prayers_arr = _prayvine_custom_get_topic_prayers($node->field_topic_id[LANGUAGE_NONE][0]['value']);
      if (count($prayers_arr) > 0) {
        db_update('node')
          ->fields(array('created' => strtotime($values['created'])))
          ->condition('nid', $prayers_arr, 'IN')
          ->execute();
      }

      // Update all post updates inside the community.
      $comments_arr = _prayvine_custom_get_topic_comments($node->field_topic_id[LANGUAGE_NONE][0]['value']);
      if (count($comments_arr) > 0) {
        db_update('comment')
          ->fields(array('created' => strtotime($values['created'])))
          ->condition('cid', $comments_arr, 'IN')
          ->execute();
      }

      $node->created = strtotime($values['created']);
      $node->field_email_reminder_prayer[LANGUAGE_NONE][0]['value'] = $values['reminder'];
      node_save($node);
      drupal_set_message(t('You have successfully updated the date.'));
    }
    else {
      drupal_set_message(t('The node you attempted to update does not exists.'));
    }
  }
  else {
    drupal_goto('admin/prayvine/prayer-request/reminder');
  }
}

/**
 * Form constructor for Prayvine Topic Reminder admin settings.
 */
function prayvine_custom_topic_reminder_form($form, &$form_state) {
  global $base_url;
  $form = array();
  $header = array();
  $rows = array();

  $sql = "SELECT n.nid FROM {node} n
          LEFT JOIN {field_data_field_ministry} m
          ON m.entity_id = n.nid
          WHERE type = 'topic'
          AND n.status = 1
          AND m.field_ministry_value = 1
          ORDER BY created DESC";
  $result = db_query($sql);

  $header = array(
    'title' => t('Title'),
    'author' => t('Author'),
    'date' => t('Latest Post'),
    'reminder_days' => t('Reminder Days'),
    'reminder_frequency' => t('Reminder Frequency'),
    'reminder_date' => t('Last Reminder'),
    'operation' => t('Operation'),
  );

  foreach ($result as $k => $row) {
    $topic = node_load($row->nid);
    $author = user_load($topic->uid);

    $days = 30;
    if (isset($topic->field_email_reminder[LANGUAGE_NONE][0]['value'])) {
      $days = $topic->field_email_reminder[LANGUAGE_NONE][0]['value'];
    }

    $frequency = 20;
    if (isset($topic->field_email_reminder_frequency[LANGUAGE_NONE][0]['value'])) {
      $frequency = $topic->field_email_reminder_frequency[LANGUAGE_NONE][0]['value'];
    }

    if (isset($topic->nid)) {
      // Get latest reminder sent.
      $latest_update = 'NONE';
      $reminder_sql = "SELECT * FROM {prayvine_reminder} WHERE nid = :nid
                       ORDER BY created DESC LIMIT 1";
      $reminder_rst = db_query($reminder_sql, array(':nid' => $topic->nid));
      foreach ($reminder_rst as $rem) {
        $latest_update = date("m/d/Y g:i", strtotime($rem->created));
      }

      // Get the latest post date.
      $latest_post = date("m/d/Y g:i", $topic->created);
      $post_date = _prayvine_custom_get_latest_request_post_date($topic->nid);
      if ($post_date > 0 && $post_date > $topic->created) {
        $latest_post = date("m/d/Y g:i", $post_date);
      }

      $rows[$topic->nid] = array(
        'title' => ucwords(isset($topic->title) ? $topic->title : ''),
        'author' => $author->name,
        'date' => $latest_post,
        'reminder_days' => $days,
        'reminder_frequency' => $frequency,
        'reminder_date' => $latest_update,
        'operation' => l(t('Edit'), $base_url . '/admin/prayvine/topic/' . $topic->nid . '/edit'),
      );
    }
  }

  $form['cron'] = array(
    '#type' => 'submit',
    '#value' => t('Run Cron'),
    '#suffix' => t('Click the button to trigger cron manually.'),
  );

  $form['requests'] = array(
    '#type' => 'tableselect',
    '#header' => $header,
    '#options' => $rows,
    '#disabled' => TRUE,
    '#multiple' => FALSE,
    '#weight' => 10,
    '#empty' => t('No topics available.'),
  );

  return $form;
}

/**
 * Form submission to manually run cron for topic reminders.
 */
function prayvine_custom_topic_reminder_form_submit($form, &$form_state) {
  prayvine_ministry_post_reminder();
  drupal_set_message('Email Reminders sent.');
}

/**
 * Form constructor for Edit Topic Date.
 */
function prayvine_custom_topic_reminder_edit_form($form, &$form_state, $nid) {
  $form = array();

  $topic = node_load($nid);
  if (isset($topic->created)) {
    $form['nid'] = array(
      '#type' => 'hidden',
      '#default_value' => $topic->nid,
    );

    $form['title'] = array(
      '#markup' => '<h2>Update Topic Date</h2>',
    );

    $form['body'] = array(
      '#markup' => '<b>' . $topic->title . '</b>',
    );

    // Get the latest post date.
    $latest_post = date("m/d/Y g:i", $topic->created);
    $post_date = _prayvine_custom_get_latest_request_post_date($topic->nid);
    if ($post_date > 0 && $post_date > $topic->created) {
      $latest_post = date("m/d/Y g:i", $post_date);
    }

    $form['created'] = array(
      '#type' => 'textfield',
      '#title' => t('Latest Post Date'),
      '#default_value' => $latest_post,
    );

    // Get latest reminder sent.
    $latest_update = '';
    $reminder_sql = "SELECT * FROM {prayvine_reminder} WHERE nid = :nid
                     ORDER BY created DESC LIMIT 1";
    $reminder_rst = db_query($reminder_sql, array(':nid' => $topic->nid));
    foreach ($reminder_rst as $rem) {
      $latest_update = date('m/d/Y g:i', strtotime($rem->created));
    }

    $form['last_reminder'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Reminder'),
      '#default_value' => $latest_update,
    );

    // Email Reminder days.
    $days = 30;
    if (isset($topic->field_email_reminder[LANGUAGE_NONE][0]['value'])) {
      $days = $topic->field_email_reminder[LANGUAGE_NONE][0]['value'];
    }

    $form['reminder'] = array(
      '#type' => 'textfield',
      '#title' => t('Email Reminder'),
      '#default_value' => $days,
    );

    // Email Reminder Frequency.
    $frequency = 20;
    if (isset($topic->field_email_reminder_frequency[LANGUAGE_NONE][0]['value'])) {
      $frequency = $topic->field_email_reminder_frequency[LANGUAGE_NONE][0]['value'];
    }

    $form['frequency'] = array(
      '#type' => 'textfield',
      '#title' => t('Email Reminder Frequency'),
      '#default_value' => $frequency,
    );

    $form['cancel'] = array(
      '#type' => 'submit',
      '#value' => t('Cancel'),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Update'),
    );
  }
  else {
    drupal_set_message(t('Access Denied'), 'error');
  }

  return $form;
}

/**
 * Form submission to Edit Topic Date.
 */
function prayvine_custom_topic_reminder_edit_form_submit($form, &$form_state) {
  $values = $form_state['values'];

  if ($values['op'] == 'Update') {
    $node = node_load($values['nid']);
    if (isset($node->nid)) {
      // Update all other prayer and prayer requests inside the community.
      $prayers_arr = _prayvine_custom_get_topic_prayers($node->nid);
      if (count($prayers_arr) > 0) {
        db_update('node')
          ->fields(array('created' => strtotime($values['created'])))
          ->condition('nid', $prayers_arr, 'IN')
          ->execute();
      }

      // Update all post updates inside the community.
      $comments_arr = _prayvine_custom_get_topic_comments($node->nid);
      if (count($comments_arr) > 0) {
        db_update('comment')
          ->fields(array('created' => strtotime($values['created'])))
          ->condition('cid', $comments_arr, 'IN')
          ->execute();
      }

      $node->created = strtotime($values['created']);
      $node->field_email_reminder[LANGUAGE_NONE][0]['value'] = $values['reminder'];
      $node->field_email_reminder_frequency[LANGUAGE_NONE][0]['value'] = $values['frequency'];
      node_save($node);

      // Update the last reminder sent.
      if (isset($values['last_reminder']) && !empty($values['last_reminder'])) {
        db_delete('prayvine_reminder')
          ->condition('nid', $node->nid)
          ->execute();

        db_insert('prayvine_reminder')
          ->fields(array(
            'nid' => $node->nid,
            'uid' => $node->uid,
            'created' => date('Y-m-d h:i:s', strtotime($values['last_reminder'])),
          ))
          ->execute();
      }

      drupal_set_message(t('You have successfully updated the date.'));
    }
    else {
      drupal_set_message(t('The node you attempted to update does not exists.'));
    }
  }
  else {
    drupal_goto('admin/prayvine/topic/reminder');
  }
}

/**
 * Get the latest activity post date within the prayer request topic.
 */
function _prayvine_custom_get_latest_request_post_date($nid = 0) {
  $latest_post = 0;

  if (is_numeric($nid) && $nid > 0) {
    // Get all ministry communicator's uid.
    $communicators_arr = _prayvine_custom_get_topic_ministry_communicators($nid);
    if (count($communicators_arr) > 0) {
      $communicators_arr = implode(",", $communicators_arr);
    }
    else {
      $communicators_arr = '0';
    }

    // Get latest prayer or prayer request posted by communicators.
    $sql = "SELECT n.created FROM {node} n
            LEFT JOIN {field_data_field_topic_id} t
            ON n.nid = t.entity_id
            WHERE n.type IN ('prayer', 'prayer_request')
            AND t.field_topic_id_value = :nid
            AND n.uid IN (:uids)
            ORDER BY n.created DESC
            LIMIT 1";
    $rst = db_query($sql, array(':nid' => $nid, ':uids' => $communicators_arr));
    foreach ($rst as $row) {
      $latest_post = $row->created;
    }

    // Get latest comment posted by communicators.
    $sql = "SELECT created FROM {comment} WHERE nid = :nid
            AND uid IN (:uids)
            ORDER BY created DESC LIMIT 1";
    $rst = db_query($sql, array(':nid' => $nid, ':uids' => $communicators_arr));
    foreach ($rst as $row) {
      if ($row->created > $latest_post) {
        $latest_post = $row->created;
      }
    }
  }

  return $latest_post;
}

/**
 * Fetches all prayer and prayer request nids inside the topic.
 */
function _prayvine_custom_get_topic_prayers($topic = 0) {
  $prayers_arr = array();

  if (is_numeric($topic) && $topic > 0) {
    $result = db_select('node', 'n');
    $result->leftJoin('field_data_field_topic_id', 't', 'n.nid = t.entity_id');
    $result->fields('n', array('nid'))
      ->condition('n.type', array('prayer', 'prayer_request'), 'IN')
      ->condition('t.field_topic_id_value', $topic, '=');
    $row = $result->execute()->fetchAll();

    foreach ($row as $prayer) {
      $prayers_arr[] = $prayer->nid;
    }
  }

  return $prayers_arr;
}

/**
 * Fetches all comment ids inside the topic.
 */
function _prayvine_custom_get_topic_comments($topic = 0) {
  $comments_arr = array();

  if (is_numeric($topic) && $topic > 0) {
    $sql = "SELECT cid FROM {comment} WHERE nid = :nid";
    $rst = db_query($sql, array(':nid' => $topic));
    foreach ($rst as $row) {
      $comments_arr[] = $row->cid;
    }
  }

  return $comments_arr;
}

/**
 * Fetches all ministry communicators of the topic community.
 */
function _prayvine_custom_get_topic_ministry_communicators($topic = 0) {
  $communicators_arr = array();

  if (is_numeric($topic) && $topic > 0) {
    $node = node_load($topic);
    if (isset($node->type) && $node->type == 'topic') {
      if (isset($node->field_settings[LANGUAGE_NONE][0]['value'])) {
        $settings = unserialize($node->field_settings[LANGUAGE_NONE][0]['value']);
        if (isset($settings['ministry_communicator']) && is_array($settings['ministry_communicator'])) {
          foreach ($settings['ministry_communicator'] as $uid) {
            $communicators_arr[] = $uid;
          }
        }
      }

      // Include the topic owner as ministry communicator.
      $communicators_arr[] = $node->uid;

      $communicators_arr = array_unique($communicators_arr);
    }
  }

  return $communicators_arr;
}
