<?php

/**
 * Implements hook_views_data().
 */

function prayvine_views_data() {
  // Define the base group of this table.
  $data['prayvine_invites']['table']['group']  = t('Prayvine Invitations');

  // Advertise this table as a possible base table
  $data['prayvine_invites']['table']['base'] = array(
    'field' => 'inviteId',
    'title' => t('Prayvine Invitations'),
    'weight' => -10,
  );
  $data['prayvine_invites']['table']['join'] = array(
    // Index this array by the table name to which this table refers.
    // 'left_field' is the primary key in the referenced table.
    // 'field' is the foreign key in this table.
    'users' => array(
      'left_field' => 'uid',
      'field' => 'inviter_uid',
    ),
    'users' => array(
      'left_field' => 'uid',
      'field' => 'claimed_uid',
    ),
    'node' => array(
      'left_field' => 'nid',
      'field' => 'nid',
    )
  );

  $data['prayvine_invites']['inviter_uid'] = array(
    'title' => t('Inviter Id'),
    'help' => t('Inviter ID.'),
    'relationship' => array(
      'base' => 'users', // The name of the table to join with.
      'base field' => 'uid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here.
      'handler' => 'views_handler_relationship',
      'label' => t('Relation to inviter'),
      'title' => t('Add relation to inviter'),
      'help' => t('Get information from users'),
    ),
  );
  $data['prayvine_invites']['claimed_uid'] = array(
    'title' => t('Registred User Id'),
    'help' => t('ID of user that is registred on site using invitations.'),
    'relationship' => array(
      'base' => 'users', // The name of the table to join with.
      'base field' => 'uid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here.
      'handler' => 'views_handler_relationship',
      'label' => t('Relation to user that took invitation'),
      'title' => t('User that took invitation'),
      'help' => t('Get information from users'),
    ),
  );
  $data['prayvine_invites']['nid'] = array(
    'title' => t('Prayer Id'),
    'help' => t('ID of prayer where user is registred on site using invitations.'),
    'relationship' => array(
      'base' => 'node', // The name of the table to join with.
      'base field' => 'nid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here.
      'handler' => 'views_handler_relationship',
      'label' => t('Relation prayer topic node'),
      'title' => t('Add relation prayer topic node'),
      'help' => t('Get information from prayer topic node'),
    ),
  );
  $data['prayvine_invites']['sent'] = array(
    'title' => t('Sent Time'),
    'help' => t('Time when invitations is sent.'),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
      'numeric' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );
  $data['prayvine_invites']['first_access'] = array(
    'title' => t('First access'),
    'help' => t('Time when invitations is used.'),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
      'numeric' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  $data['prayvine_invites']['mail'] = array(
    'title' => t('Mail'),
    'help' => t('Mail where invitation is sent.'),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
      'numeric' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );
  $data['prayvine_invites']['status'] = array(
    'title' => t('Status'),
    'help' => t('Invitation status.'),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_number',
      'numeric' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_number',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );
  $data['prayvine_invites']['inviteId'] = array(
    'title' => t('InviteId'),
    'help' => t('Invitation Id.'),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_number',
      'numeric' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_number',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );
  //**********************************************************
  //subscription table
  $data['prayvine_subscriptions']['table']['group']  = t('Prayvine Subscription');

  // Advertise this table as a possible base table
  $data['prayvine_subscriptions']['table']['base'] = array(
    'field' => 'nid',
    'title' => t('Prayvine Subscription'),
    'weight' => -10,
  );
  $data['prayvine_subscriptions']['table']['join'] = array(
    // Index this array by the table name to which this table refers.
    // 'left_field' is the primary key in the referenced table.
    // 'field' is the foreign key in this table.
    'users' => array(
      'left_field' => 'uid',
      'field' => 'uid',
    ),
    'node' => array(
      'left_field' => 'nid',
      'field' => 'nid',
    )
  );

  $data['prayvine_subscriptions']['uid'] = array(
    'title' => t('Subscriber Id'),
    'help' => t('Subscriber ID.'),
    'relationship' => array(
      'base' => 'users', // The name of the table to join with.
      'base field' => 'uid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here.
      'handler' => 'views_handler_relationship',
      'label' => t('Relation to subscriber'),
      'title' => t('Add relation to sucriber'),
      'help' => t('Get information from users'),
    ),
  );

  $data['prayvine_subscriptions']['nid'] = array(
    'title' => t('Prayer Topic Id'),
    'help' => t('ID of prayer topic where user is registred on site using invitations.'),
    'relationship' => array(
      'base' => 'node', // The name of the table to join with.
      'base field' => 'nid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here.
      'handler' => 'views_handler_relationship',
      'label' => t('Relation prayer topic node'),
      'title' => t('Add relation prayer topic node'),
      'help' => t('Get information from prayer topic node'),
    ),
  );
  return $data;
}

/**
 * Implements hook_views_bulk_operations_form_alter().
 * @param type $form
 * @param type $form_state
 * @param type $vb
 */
function prayvine_views_bulk_operations_form_alter(&$form, &$form_state, $vbo) {
    if ($form['#form_id'] == 'views_form_subscribers_default') {
		$node = node_load($form_state['build_info']['args'][0]->args[0]);
 		if (!isset($node->field_ministry['und'][0]['value']) || $node->field_ministry['und'][0]['value'] == 0 ) {
 			$form['select']['action::prayvine_action_ministry_communicator_permission']['#type'] = 'hidden';
			$form['select']['action::prayvine_action_remove_ministry_communicator_permission']['#type'] = 'hidden';
		}
    }
}

/**
 * hook views_query_alter
 * @param type $view
 * @param type $query
 */
function prayvine_views_query_alter(&$view, &$query) {

  if ($view->name == 'subscribers' && ($view->current_display == 'default' || $view->current_display == 'page_1')) {//select only items that is related to user
    global $user;
    $topic_id = $view->args[0];
    $query->where[1]['conditions'][0]['value'] = $topic_id;

    //Code for checking ministry page
    $node = node_load($topic_id);
    if(!empty($view->field["title"])){
       $view->field["title"]->options['exclude'] = 1;
    }

    if (isset($node->field_ministry['und'][0]['value']) && $node->field_ministry['und'][0]['value'] == 1) {
        if(!empty($view->field["title"])){
          $view->field["title"]->options['exclude'] = 0;
        }
    }

  }

  if ( $view->name == 'subscribers' && ($view->current_display == 'block_1' || $view->current_display == 'block_2')) {
    global $user;

    $topic_id = $view->args[0];
    $query->where[1]['conditions'][0]['value'] = $topic_id;
  }
  if ($view->name == 'prayvine_invites') {//select only items that is related to user
    global $user;
    $topic_id = $view->args[0];
    $query->where[1]['conditions'][0]['value'] = $user->uid;
    $query->where[1]['conditions'][1]['value'] = $topic_id;
  }

  if ($view->name == 'prayers') {//select only items that is related to user

    $nodes = prayvine_get_my_subscribes();
    $query->where[1]['conditions'][2]['operator'] = 'IN';
    $query->where[1]['conditions'][2]['value'] = $nodes;

  }
}


/**
 * hook post execute views hook - take only my clients
 */
function prayvine_views_post_execute(&$view){
  global $user;

  if ($view->name == 'subscribers' && $view->current_display == 'default') {//dealing with invite permissions
    $topic_id = $view->args[0];
    $topic = node_load($topic_id);
    $settings=array();
    if (!empty($topic->field_settings['und'][0]['value'])) {
      $settings_text = $topic->field_settings['und'][0]['value'];
      $settings = unserialize($settings_text);
    }

    foreach ($view->result as $key => $row) {

      $uid = $row->users_prayvine_subscriptions_uid;
      if (empty($settings['invite_permission'][$uid]) && empty($settings['ministry_communicator'][$uid])){
        $view->result[$key]->users_prayvine_subscriptions_name = t('no');
      }else{
        $view->result[$key]->users_prayvine_subscriptions_name = t('yes');
      }
      if ($uid == $user->uid) {
        $view->result[$key]->users_prayvine_subscriptions_name = t('yes');
        //$owner_key = $key;
      }

      if (empty($settings['ministry_communicator'][$uid])){
      	$view->result[$key]->node_prayvine_subscriptions_title = t('no');
      }else{
      	$view->result[$key]->node_prayvine_subscriptions_title = t('yes');
      }
      if ($uid == $user->uid) {
      	$view->result[$key]->node_prayvine_subscriptions_title = t('yes');
      	//$owner_key = $key;
      }

    }
    //put owner on top
//     $owner = $view->result[$owner_key];
//     $first = $view->result[0];
//     $view->result[0] = $owner;
//     $view->result[$owner_key] = $first;

  }
  if ($view->name == 'prayvine_invites') {
    foreach ($view->result as $key => $row) {
      $time_sent = $view->result[$key]->prayvine_invites_sent;//UTC
      $time_sent_stamp = strtotime($time_sent.' UTC');//UTC timezone
      $time_access = $view->result[$key]->prayvine_invites_first_access;//UTC
      $time_access_stamp = strtotime($time_access.' UTC');//UTC timezone
      $time_zone = drupal_get_user_timezone();
      $expire_time = $time_sent_stamp + 7*24*60*60;
      $time_left = $expire_time-time();
      $days_d = $time_left/(24*60*60);
      $days = floor($days_d);
      $hours = abs(round(($days_d-$days)*24));
      $sent = format_date($time_sent_stamp,'custom','M j Y A h:i',$time_zone);
      $access = format_date($time_access_stamp,'custom','M j Y A h:i',$time_zone);
      if (stripos($view->result[$key]->prayvine_invites_first_access,'0000')!==FALSE){
        $view->result[$key]->prayvine_invites_first_access = 0;
      } else {
        $view->result[$key]->prayvine_invites_first_access = $access;
      }

      $view->result[$key]->prayvine_invites_sent = $sent;
      if ($days>0) {
        $view->result[$key]->users_prayvine_invites_name = t('%d days and %h hours',array('%d'=>$days,'%h'=>$hours));
      } else {
        $view->result[$key]->users_prayvine_invites_name = t('Expired');
      }


    }
  }
  if ($view->name == 'prayers') {
    foreach($view->result as $key=>$result) {
      $topicId = $result->nid;
      prayvine_topic_last_update($topicId);
      $names = prayvine_get_prayers_users_name($topicId);
      $value_names = '';
      $counter = 0;
      foreach ($names as $name) {
        $value_names .= $name.', ';
      }
      $value_names = substr($value_names, 0,-2);
      $view->result[$key]->users_node_name = $value_names;
      $last_update = prayvine_topic_last_update($topicId);
      $view->result[$key]->node_changed = $last_update;

    }
  }

}
/**
 * sorting function for prayer last update
 * @param type $obj1
 * @param type $obj2
 * @return int
 */
function prayvine_sort_topics($obj1, $obj2) {
  if ($obj1->node_changed == $obj2->node_changed) {
    return 0;
  }
  if ($obj1->node_changed<$obj2->node_changed){
    return 1;
  } else {
    return -1;
  }

}
/**
 * get subscribers names who is praying on topic
 * @param type $topicId - node id of topic
 */
function prayvine_get_prayers_users_name($topicId) {

  $subscribers = prayvine_get_subscriber_ids($topicId);

  foreach($subscribers as $uid) {
    $names[$uid] = prayvine_get_name($uid);
  }
  return $names;
}
/**
 *
 * @param type $topicId
 */
function prayvine_topic_last_update($topicId) {
  //check last comment update
  $query = db_select('comment', 'c');
  $query->fields('c',array('nid','changed'))->condition('nid',$topicId);
  $query->orderBy('changed', 'DESC')->range(0,1);//ORDER BY created
  $comment_last_update = $query->execute()->fetchAssoc();

  $updates[] = (int)$comment_last_update['changed'];
  //check prayers
  $query = db_select('field_data_field_topic_id', 'p');
  $query->join('node', 'n', 'p.entity_id = n.nid');
  $query->fields('n',array('nid','changed'))->condition('p.field_topic_id_value',$topicId);
  $query->orderBy('n.changed', 'DESC')->range(0,1);//ORDER BY created
  $other_last_update_record = $query->execute();
  $other_last_update = $other_last_update_record->fetchAssoc();
  $updates[] = (int)$other_last_update['changed'];

  //check sayamens
  $query = db_select('field_data_field_topic_id', 'p');
  $query->join('node', 'n', 'p.entity_id = n.nid');
  $query->join('prayvine_prayer_amens', 'a', 'a.nid = n.nid');
  $query->fields('a',array('nid','updated'))->condition('p.field_topic_id_value',$topicId);
  $query->orderBy('a.updated', 'DESC')->range(0,1);//ORDER BY created
  $other_last_update_record = $query->execute();
  $other_last_update = $other_last_update_record->fetchAssoc();
  $updates[] = strtotime($other_last_update['updated']);
  rsort($updates);
  $last_update = $updates[0];
  return $last_update;
}

function prayvine_get_my_subscribes() {
  global $user;
  $query = db_select('prayvine_subscriptions', 's');
  $query->fields('s', array('uid','nid'))->condition('uid',$user->uid);
  $result = $query->execute();
  while ($record = $result->fetchAssoc()) {
    $nodes[] = $record['nid'];
  }
  return $nodes;
}
