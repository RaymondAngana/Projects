<?php

/**
 * Implements hook_views_data().
 */

function prayvinestat_views_data() {
  
  // Define the base group of this table.
  $data['prayvinestat_invitations']['table']['group']  = t('Invitations Statistics');

  // Advertise this table as a possible base table
  $data['prayvinestat_invitations']['table']['base'] = array(
    'field' => 'uid',
    'title' => t('Invitations Statistics'),
    'weight' => -10,
  );
  $data['prayvinestat_invitations']['table']['join'] = array(
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

  $data['prayvinestat_invitations']['uid'] = array(
    'title' => t('User Id'),
    'help' => t('User ID.'),
    'relationship' => array(
      'base' => 'users', // The name of the table to join with. 
      'base field' => 'uid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here. 
      'handler' => 'views_handler_relationship', 
      'label' => t('Relation statistics to users'), 
      'title' => t('Add relation statistics
        to users'), 
      'help' => t('Get information from users'),  
    ),
  );
  $data['prayvinestat_invitations']['register_user'] = array(
    'title' => t('Registred User Id'),
    'help' => t('ID of user that is registred on site using invitations.'),
    'relationship' => array(
      'base' => 'users', // The name of the table to join with. 
      'base field' => 'uid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here. 
      'handler' => 'views_handler_relationship', 
      'label' => t('Relation statistics to register users'), 
      'title' => t('Add relation statistics to registred users using invitations'), 
      'help' => t('Get information from users'),  
    ),
  );
   $data['prayvinestat_invitations']['nid'] = array(
    'title' => t('Prayer Id'),
    'help' => t('ID of prayer where user is registred on site using invitations.'),
    'relationship' => array(
      'base' => 'node', // The name of the table to join with. 
      'base field' => 'nid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here. 
      'handler' => 'views_handler_relationship', 
      'label' => t('Relation prayer node'), 
      'title' => t('Add relation prayer node'), 
      'help' => t('Get information from prayer node'),  
    ),
  );
  $data['prayvinestat_invitations']['timestamp_send'] = array(
    'title' => t('Sent Time'),
    'help' => t('Time when invitations is sent.'),
    'field' => array(
      'handler' => 'views_handler_field_date',
      'click sortable' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_date',
      'numeric' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_date',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );
  $data['prayvinestat_invitations']['timestamp_clicked'] = array(
    'title' => t('Clicked Time'),
    'help' => t('Time when invitations is clicked.'),
    'field' => array(
      'handler' => 'views_handler_field_date',
      'click sortable' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_date',
      'numeric' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_date',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );
  $data['prayvinestat_invitations']['timestamp_action'] = array(
    'title' => t('Action Time'),
    'help' => t('Time when action is done.'),
    'field' => array(
      'handler' => 'views_handler_field_date',
      'click sortable' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_date',
      'numeric' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_date',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );
  $data['prayvinestat_invitations']['mail'] = array(
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
  $data['prayvinestat_invitations']['action'] = array(
    'title' => t('Action'),
    'help' => t('Action name.'),
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
  //*********************************************************
  //user action table
  $data['prayvinestat_user_actions']['table']['group']  = t('User Action Statistics');
  $data['prayvinestat_user_actions']['table']['base'] = array(
    'field' => 'uid',
    'title' => t('User Statistics'),
    'weight' => -10,
  );
  
  $data['prayvinestat_user_actions']['table']['join'] = array(
    // Index this array by the table name to which this table refers.
    // 'left_field' is the primary key in the referenced table.
    // 'field' is the foreign key in this table.
    'users' => array(
      'left_field' => 'uid', 
      'field' => 'uid',
    ),
    
  );

  $data['prayvinestat_user_actions']['uid'] = array(
    'title' => t('User Id'),
    'help' => t('User ID.'),
    'relationship' => array(
      'base' => 'users', // The name of the table to join with. 
      'base field' => 'uid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here. 
      'handler' => 'views_handler_relationship', 
      'label' => t('Relation statistics to users'), 
      'title' => t('Add relation statistics to users'), 
      'help' => t('Get information from users'),  
    ),
  );
  $data['prayvinestat_user_actions']['action'] = array(
    'title' => t('Action'),
    'help' => t('Action name.'),
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
  $data['prayvinestat_user_actions']['timestamp'] = array(
    'title' => t('Action Time'),
    'help' => t('Time when actions is performed.'),
    'field' => array(
      'handler' => 'views_handler_field_date',
      'click sortable' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_date',
      'numeric' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_date',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );
  
  return $data;
}
