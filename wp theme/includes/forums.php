<?php

/**
 * All forum-related fixes are consolidated in this plugin.
 */
class CareerSource_forum_fixes {
  /**
   * Constructor.
   */
  function __construct() {
    add_action('pending_to_publish',  array($this, 'bbpress_send_notification_after_publish'), 10, 1);

    add_action('bbp_approved_topic', function ($topic_id) {
      $forum_id = bbp_get_topic_forum_id($topic_id);
      bbp_notify_forum_subscribers($topic_id, $forum_id);
    }, 10, 1);

    add_action('bbp_approved_reply', function ($reply_id) {
      $topic_id = bbp_get_reply_topic_id($reply_id);
      $forum_id = bbp_get_topic_forum_id($topic_id);
      bbp_notify_topic_subscribers($reply_id, $topic_id, $forum_id);
    }, 10, 1);
  }

  function bbpress_send_notification_after_publish($post) {
    // Fire only on topic/reply post status.
    if (in_array($post->post_type, array('topic', 'reply'))) {
      if ($post->post_type == 'topic') {
        $forum_id = bbp_get_topic_forum_id($post_id);
        bbp_notify_forum_subscribers($post_id, $forum_id);
      }
      if ($post->post_type == 'reply') {
        $topic_id = bbp_get_reply_topic_id($post_id);
        $forum_id = bbp_get_topic_forum_id($topic_id);
        bbp_notify_topic_subscribers($post_id, $topic_id, $forum_id);
      }
    }
  }

// DO NOT DELETE.
}

$careersource_forums = new CareerSource_forum_fixes();
