<?php
/**
 * hook rules event
 * @return type
 */
function prayvine_rules_event_info() {
  return array(
  'prayvine_send_mail_prayer_insert' => array(
     'label' => t('Insert Prayer event'),
     'group' => t('Prayvine'),
     'variables' => array(
       'subscriber' => array('type' => 'user', 'label' => t('Subscriber')),
       'author_name' => array('type' => 'text', 'label' => t('Author name')),
       'author_name_first' => array('type' => 'text', 'label' => t('Author first name.')),
       'topic' => array('type' => 'text', 'label' => t('Topic')),
       'url' => array('type' => 'text', 'label' => t('Prayer URL')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'prayer' => array('type' => 'node', 'label' => t('Prayer')),
       'sayamen' => array('type' => 'uri', 'label' => t('Say Amen Link.')),
       'access_link' => array('type' => 'uri', 'label' => t('Pray Silently Access Link.')),
       'request' => array('type' => 'node', 'label' => t('Request')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),

     ),
   ),
   'prayvine_send_mail_prayer_insert_un' => array(
     'label' => t('Insert Prayer event for unregistereg users'),
     'group' => t('Prayvine'),
     'variables' => array(
       'subscriber_mail' => array('type' => 'text', 'label' => t('Subscriber mail.')),
       'author_name' => array('type' => 'text', 'label' => t('Author name')),
       'author_name_first' => array('type' => 'text', 'label' => t('Author first name.')),
       'topic' => array('type' => 'text', 'label' => t('Topic')),
       'url' => array('type' => 'text', 'label' => t('Prayer URL')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'prayer' => array('type' => 'node', 'label' => t('Prayer')),
       'unsubscribe' => array('type' => 'text', 'label' => t('Unsubcribe link.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),
       'topic_owner' => array('type'=>'integer', 'label'=> t('Is Topic owner')),
       'code' => array('type' => 'text', 'label' => t('Invite token.')),

     ),
   ),
  'prayvine_send_mail_request_insert' => array(
     'label' => t('Insert Request event'),
     'group' => t('Prayvine'),
     'variables' => array(
       'subscriber' => array('type' => 'user', 'label' => t('Subscriber')),
       'author_name' => array('type' => 'text', 'label' => t('Author name')),
       'author_name_first' => array('type' => 'text', 'label' => t('Author first name.')),
       'topic' => array('type' => 'text', 'label' => t('Topic')),
       'url' => array('type' => 'text', 'label' => t('Request URL')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'request' => array('type' => 'node', 'label' => t('Request')),
       'access_link' => array('type' => 'uri', 'label' => t('Access.')),
       'mark_as_urgent' => array('type' => 'integer', 'label'=>t('Mark as urgent')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),

     ),
   ),
  'prayvine_send_mail_request_insert_un' => array(
     'label' => t('Insert Request event for unregistered users'),
     'group' => t('Prayvine'),
     'variables' => array(
       'subscriber_mail' => array('type' => 'text', 'label' => t('Subscriber mail')),
       'author_name' => array('type' => 'text', 'label' => t('Author name')),
       'author_name_first' => array('type' => 'text', 'label' => t('Author first name.')),
       'topic' => array('type' => 'text', 'label' => t('Topic title')),
       'url' => array('type' => 'text', 'label' => t('Request URL')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'request' => array('type' => 'node', 'label' => t('Request')),
       'mark_as_urgent' => array('type' => 'integer', 'label'=>t('Mark as urgent')),
       'unsubscribe' => array('type' => 'text', 'label' => t('Unsubcribe link.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),
       'topic_owner' => array('type'=>'integer', 'label'=> t('Is Topic owner')),
       'code' => array('type' => 'text', 'label' => t('Invite token.')),

     ),
   ),
  'prayvine_send_mail_prayer_comment_insert' => array(
    'label' => t('Insert Prayer comment event'),
    'group' => t('Prayvine'),
    'variables' => array(
      'subscriber' => array('type' => 'user', 'label' => t('Subscriber')),
      'author_name' => array('type' => 'text', 'label' => t('Author name')),
      'author_name_first' => array('type' => 'text', 'label' => t('Author first name')),
      'topic_author_name_' => array('type' => 'text', 'label' => t('Topic Author name')),
      'topic' => array('type' => 'text', 'label' => t('Topic')),
      'url' => array('type' => 'text', 'label' => t('Prayer URL')),
      'comment' => array('type' => 'comment', 'label' => t('Comment')),
      'footer' => array('type' => 'text', 'label' => t('Email footer.')),
      'access_link' => array('type' => 'uri', 'label' => t('Access link - pray silently.')),
      'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
      'topic_node' => array('type'=>'node', 'label'=> t('Topic node')),

    ),
   ),
   'prayvine_send_mail_prayer_comment_insert_un' => array(
    'label' => t('Insert Prayer comment event for unregistered users'),
    'group' => t('Prayvine'),
    'variables' => array(
      'subscriber_mail' => array('type' => 'text', 'label' => t('Subscriber mail')),
      'author_name' => array('type' => 'text', 'label' => t('Author name')),
      'author_name_first' => array('type' => 'text', 'label' => t('Author first name')),
      'topic_author_name_' => array('type' => 'text', 'label' => t('Topic Author name')),
      'topic' => array('type' => 'text', 'label' => t('Topic')),
      'url' => array('type' => 'text', 'label' => t('Prayer URL')),
      'comment' => array('type' => 'comment', 'label' => t('Comment')),
      'footer' => array('type' => 'text', 'label' => t('Email footer.')),
      'unsubscribe' => array('type' => 'text', 'label' => t('Unsubcribe link.')),
      'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
      'topic_node' => array('type' => 'node', 'label' => t('Topic node')),
      'topic_owner' => array('type'=>'integer', 'label'=> t('Is Topic owner')),
      'code' => array('type' => 'text', 'label' => t('Invite token.')),

    ),
   ),
   'prayvine_send_mail_send_invite' => array(
     'label' => t('Invite friend to Prayer event'),
     'group' => t('Prayvine'),
     'variables' => array(
       'user' => array('type' => 'user', 'label' => t('Subscriber')),
       'email' => array('type' => 'text', 'label' => t('Email')),
       'code' => array('type' => 'text', 'label' => t('Access code')),
       'inviter_name' => array('type' => 'text', 'label' => t('Inviter name')),
       'topic' => array('type' => 'text', 'label' => t('Topic')),
       'url' => array('type' => 'text', 'label' => t('Prayer URL')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'unsubscribe' => array('type' => 'text', 'label' => t('Unsubcribe link.')),
       'emails' => array('type' => 'text', 'label' => t('Invite emails.')),
       'message' => array('type' => 'text', 'label' => t('Invite message.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),

     ),
   ),
   'prayvine_send_mail_send_invite_update' => array(
     'label' => t('Invite friend to Prayer update event'),
     'group' => t('Prayvine'),
     'variables' => array(
       'user' => array('type' => 'user', 'label' => t('Subscriber')),
       'email' => array('type' => 'text', 'label' => t('Email')),
       'code' => array('type' => 'text', 'label' => t('Access code')),
       'author_mail' => array('type' => 'text', 'label' => t('Author mail')),
       'topic' => array('type' => 'text', 'label' => t('Topic')),
       'url' => array('type' => 'text', 'label' => t('Prayer URL')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'message' => array('type' => 'text', 'label' => t('Invite message.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),
     ),
   ),
   'prayvine_send_mail_add_subscription' => array(
     'label' => t('Add subsciption event'),
     'group' => t('Prayvine'),
     'variables' => array(
       'author' => array('type' => 'user', 'label' => t('Author')),
       'subscriber_name' => array('type' => 'text', 'label' => t('Subscriber name')),
       'user' => array('type' => 'user', 'label' => t('Subscriber')),
       'topic' => array('type' => 'text', 'label' => t('Topic')),
       'url' => array('type' => 'text', 'label' => t('Prayer URL')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),
     ),
   ),
   'prayvine_send_say_amen' => array(
     'label' => t('Say amen event'),
     'group' => t('Prayvine'),
     'variables' => array(
       'author' => array('type' => 'user', 'label' => t('Author')),
       'user_name' => array('type' => 'text', 'label' => t('User name')),
       'user' => array('type' => 'user', 'label' => t('User')),
       'topic' => array('type' => 'text', 'label' => t('Topic')),
       'url' => array('type' => 'text', 'label' => t('Prayer URL')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),
       'prayer' => array('type' => 'node', 'label' => t('Prayer node')),
     ),
   ),
   'prayvine_invite_reminder' => array(
     'label' => t('Invite Reminder'),
     'group' => t('Prayvine'),
     'variables' => array(
       'inviter' => array('type' => 'user', 'label' => t('Inviter')),
       'topic' => array('type' => 'node', 'label' => t('Topic')),
       'invite_mail' => array('type' => 'text', 'label' => t('Invite Mail')),
       'hour' => array('type' => 'integer', 'label' => t('Hours to expire')),
       'invite_link' => array('type' => 'text', 'label' => t('Invite Link')),
       'expire_date' => array('type' => 'text', 'label' => t('Expire date.')),
       'claimed_id' => array('type' => 'integer', 'label' => t('Claimed uid.')),
       'inviter_name' => array('type' => 'text', 'label' => t('Inviter name.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
     ),
   ),
   'prayvine_photo_reminder' => array(
     'label' => t('Photo reminder - execute where other events are not'),
     'group' => t('Prayvine'),
   ),
   'prayvine_private_message' => array(
     'label' => t('Send private message'),
     'group' => t('Prayvine'),
     'variables' => array(
       'recipient' => array('type' => 'user', 'label' => t('Recipient')),
       'message' => array('type' => 'text', 'label' => t('Message.')),
       'request' => array('type' => 'node', 'label' => t('Request')),
       'topic' => array('type' => 'node', 'label' => t('Topic')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
     ),
   ),
   'prayvine_private_message_comment' => array(
     'label' => t('Send private message on comment/update'),
     'group' => t('Prayvine'),
     'variables' => array(
       'recipient' => array('type' => 'user', 'label' => t('Recipient')),
       'message' => array('type' => 'text', 'label' => t('Message.')),
       'comment' => array('type' => 'comment', 'label' => t('Comment')),
       'topic' => array('type' => 'node', 'label' => t('Topic')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
     ),
   ),
   'prayvine_pray_verbaly_notify' => array(
     'label' => t('Pray verbaly notify author'),
     'group' => t('Prayvine'),
     'variables' => array(
       'request' => array('type' => 'node', 'label' => t('Request')),
       'author' => array('type' => 'user', 'label' => t('Prayer request author.')),
       'topic' => array('type' => 'node', 'label' => t('Topic')),
       'prayer' => array('type' => 'user', 'label' => t('Person how prays.')),
       'footer' => array('type' => 'text', 'label' => t('Email Footer.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
    ),
   ),
  'prayvine_pray_verbaly_notify_ministry_communicator' => array(
  	'label' => t('Pray verbaly notify author ministry communicators'),
	'group' => t('Prayvine'),
	'variables' => array(
		'request' => array('type' => 'node', 'label' => t('Request')),
		'author' => array('type' => 'user', 'label' => t('Prayer request author.')),
  		'topic' => array('type' => 'node', 'label' => t('Topic')),
		'prayer' => array('type' => 'user', 'label' => t('Person how prays.')),
		'footer' => array('type' => 'text', 'label' => t('Email Footer.')),
		'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
 		),
	),
   'prayvine_pray_verbaly_notify_comment' => array(
     'label' => t('Pray verbaly notify author - updates'),
     'group' => t('Prayvine'),
     'variables' => array(
       'comment' => array('type' => 'comment', 'label' => t('Request')),
       'author' => array('type' => 'user', 'label' => t('Prayer request author.')),
       'topic' => array('type' => 'node', 'label' => t('Topic')),
       'prayer' => array('type' => 'user', 'label' => t('Person how prays.')),
       'footer' => array('type' => 'text', 'label' => t('Email Footer.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
    ),
   ),
   'prayvine_pray_verbaly_secret' => array(
     'label' => t('Pray verbaly anonymously'),
     'group' => t('Prayvine'),
     'variables' => array(
       'request' => array('type' => 'node', 'label' => t('Request')),
       'author' => array('type' => 'user', 'label' => t('Prayer request author.')),
       'topic' => array('type' => 'node', 'label' => t('Topic')),
       'prayer' => array('type' => 'user', 'label' => t('Person how prays.')),
       'footer' => array('type' => 'text', 'label' => t('Email Footer.')),
       'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
    ),
   ),
  'prayvine_ministry_goal_reminder' => array(
	'label' => t('Prayvine Ministry Goal Reminder'),
  	'group' => t('Prayvine'),
  	'variables' => array(
	   'subscriber' => array('type' => 'user', 'label' => t('Subscriber')),
       'author_name' => array('type' => 'text', 'label' => t('Author name')),
       'author_name_first' => array('type' => 'text', 'label' => t('Author first name.')),
       'topic' => array('type' => 'text', 'label' => t('Topic')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),
  	   'days' => array('type'=>'integer', 'label'=> t('Days')),
 	   'freqdays' => array('type'=>'integer', 'label'=> t('Frequency days')),
		),
  	),
  'prayvine_notification_non_ministry_goal_reminder'=> array(
	'label' => t('Prayvine Notification Non Ministry Goal Reminder'),
  	'group' => t('Prayvine'),
  	'variables' => array(
	   'subscriber' => array('type' => 'user', 'label' => t('Subscriber')),
       'author_name' => array('type' => 'text', 'label' => t('Author name')),
       'author_name_first' => array('type' => 'text', 'label' => t('Author first name.')),
       'topic' => array('type' => 'text', 'label' => t('Topic')),
       'footer' => array('type' => 'text', 'label' => t('Email footer.')),
       'topic_node' => array('type' => 'node', 'label' => t('Topic node')),
  	   'days' => array('type'=>'integer', 'label'=> t('Days')),
 	   'freqdays' => array('type'=>'integer', 'label'=> t('Frequency days')),
		),
  	),
  	'prayvine_ministry_prayer_goal_reminder' => array(
  		'label' => t('Prayvine Ministry Prayer Goal Reminder'),
  		'group' => t('Prayvine'),
 		'variables' => array(
		'subscriber' => array('type' => 'user', 'label' => t('Subscriber')),
 			'author_name' => array('type' => 'text', 'label' => t('Author name')),
			'author_name_first' => array('type' => 'text', 'label' => t('Author first name.')),
			'topic' => array('type' => 'text', 'label' => t('Topic')),
			'footer' => array('type' => 'text', 'label' => t('Email footer.')),
			'topic_node' => array('type' => 'node', 'label' => t('Topic node')),
 			'prayer_node' => array('type' => 'node', 'label' => t('Prayer node')),
			'days' => array('type'=>'integer', 'label'=> t('Days')),
			'freqdays' => array('type'=>'integer', 'label'=> t('Frequency days')),
  			),
  		),
  	'prayvine_message_to_ministry_communicator' => array(
  		'label' => t('Send message to ministry communicator'),
  		'group' => t('Prayvine'),
  		'variables' => array(
  			'recipient' => array('type' => 'user', 'label' => t('Recipient')),
  			'message' => array('type' => 'text', 'label' => t('Message.')),
  			'topic' => array('type' => 'node', 'label' => t('Topic')),
  			'ministry' => array('type'=>'integer', 'label'=> t('Ministry')),
  		),
  	),
  );
}

/**
 * action rule hook
 */
function prayvine_rules_condition_info() {
  return array(
   'prayvine_photo_reminder' => array(
      'label' => t('Photo reminder has to fire'),
      'group' => t('Prayvine'),
      'parameter' => array(
        'user' => array('type' => 'user', 'label' => t('User')),
        'days' => array('type' => 'text', 'label'=>t('Days after reminder will be triggered'))
      ),
    ),
  );
}
/**
 * calculate reminder trigger
 * @param type $user
 */
function prayvine_photo_reminder($user,$days) {

  if (empty($user->picture->fid)) {//user don't have uploaded photo
    $reminder_name = 'prayvine_photo_reminder_'.$user->uid;
    $reminder = variable_get($reminder_name,0);

    if (empty($reminder)){//reminder is empty trigger event
      $time = time();//reset reminder
      variable_set($reminder_name, $time);
      return true;
    } else {
      $time = time();
      $float_days = (float)$days;
      if (($time-$reminder)>$float_days*24*60*60) {//reminder expired
        $time = time();//reset reminder
        variable_set($reminder_name, $time);intval($time);
        return true;
      } else {//reminder is not expired yet
        return false;
      }
    }
  } else {
    $reminder_name = 'prayvine_photo_reminder_'.$user->uid;
    $reminder = variable_del($reminder_name);
    return false;
  }
  return false;
}
