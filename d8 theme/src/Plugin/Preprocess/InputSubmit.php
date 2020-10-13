<?php

/**
 * @file
 * Contains \Drupal\main\Plugin\Preprocess\InputSubmit.
 */

namespace Drupal\main\Plugin\Preprocess;

use Drupal\main\Plugin\Preprocess\PreprocessBase;
use Drupal\main\PreprocessInterface;
use Drupal\Core\Template\Attribute;

/**
 * Preprocess for input submit templates.
 *
 * @mainPreprocess("input__submit")
 */
class InputSubmit extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook) {
    $variables['label'] = $variables['element']['#value'];
    $variables['attributes']['class'][] = 'btn';
    $variables['attributes']['class'][] = 'btn-default';
  }
}
