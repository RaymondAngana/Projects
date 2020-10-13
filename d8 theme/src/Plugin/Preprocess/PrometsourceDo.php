<?php

/**
 * @file
 * Contains \Drupal\main\Plugin\Preprocess\mainsourceDo.
 */

namespace Drupal\main\Plugin\Preprocess;

use Drupal\main\Plugin\Preprocess\PreprocessBase;
use Drupal\main\PreprocessInterface;

/**
 * Preprocess for page templates.
 *
 * @mainPreprocess("mainsource_do")
 */
class mainsourceDo extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook) {
    $variables['link']['#title'] = t('Learn More <i class="fa fa-chevron-right"></i>');
  }

}
