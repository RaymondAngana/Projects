<?php

/**
 * action rule hook
 */
function prayvine_notification_rules_condition_info() {

  return array(
   'prayvine_notifications_posting' => array(
      'label' => t('Post prayer'),
      'group' => t('Prayvine'),
      'parameter' => array(
        'user' => array('type' => 'user', 'label' => t('User')),
        'topic' => array('type' => 'node', 'label'=>t('Topic'))
      ),
    ),
    'prayvine_notifications_amens' => array(
      'label' => t('Post Amens'),
      'group' => t('Prayvine'),
      'parameter' => array(
        'user' => array('type' => 'user', 'label' => t('User')),
        'topic' => array('type' => 'node', 'label'=>t('Topic'))
      ),
    ),
  );
}
/**
 * check what kind of notification user want
 * @param type $topic
 * @param type $user
 */
function prayvine_notifications_posting($subscriber, $topic) {
  global $user;
  $topic_settings = unserialize($topic->field_settings['und'][0]['value']);
  if ($user->uid == $topic->uid) {//it is topic owner - always send emails
    return true;
  }
  if (!empty($topic_settings['ministry_communicator'][$user->uid])) {//user has communicator permission - always send emails
    return true;
  }
  if (!isset($topic_settings['notification'][$subscriber->uid]['posting'])) {//if user didn't set posting - send email
    return false;
  }
  if (empty($topic_settings['notification'][$subscriber->uid]['posting'])) {//user set posting if subscriber allow -send email othervise not
    return true;
  } else {
    return false;
  }
  return false;
}


/**
 * check is amens want to be notify (0 = yes 1 = no)
 * @param type $topic
 * @param type $user
 * @return boolean
 */
function prayvine_notifications_amens($subscriber, $topic) {
  $topic_settings = unserialize($topic->field_settings['und'][0]['value']);
  if (!isset($topic_settings['notification'][$subscriber->uid]['amens'])) {
    return false;
  }

  if (empty($topic_settings['notification'][$subscriber->uid]['amens'])) {
    return true;
  } else {
    return false;
  }

}
