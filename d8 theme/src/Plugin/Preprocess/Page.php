<?php

/**
 * @file
 * Contains \Drupal\main\Plugin\Preprocess\Page.
 */

namespace Drupal\main\Plugin\Preprocess;

use Drupal\main\Plugin\Preprocess\PreprocessBase;
use Drupal\main\PreprocessInterface;

/**
 * Preprocess for page templates.
 *
 * @mainPreprocess("page")
 */
class Page extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook) {
    if ($variables['is_front']) {
      $variables['#attached']['library'][] = 'main/homepage';
      $variables['icon'] = [
        '#theme' => 'image',
        '#uri' => $variables['base_path'] . $variables['directory'] . '/img/flame.png',
      ];
    }
  }

}
