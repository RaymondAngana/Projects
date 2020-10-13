<?php

/**
 * @file
 * Contains \Drupal\main\Plugin\Preprocess\ViewsViewFieldsCaseStudyTop.
 */

namespace Drupal\main\Plugin\Preprocess;

use Drupal\main\Plugin\Preprocess\PreprocessBase;
use Drupal\main\PreprocessInterface;

/**
 * Preprocess for views view fields.
 *
 * @mainPreprocess("views_view_fields__case_study__top")
 */
class ViewsViewFieldsCaseStudyTop extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook) {
    $variables['base_path'] = base_path();
    $variables['fields']['field_case_challenges']->image_path = 'icon-3.png';
    $variables['fields']['field_case_challenges']->wrapper_attributes->addClass('csd-box-2', 'csd-color-1');

    $variables['fields']['field_case_solutions']->image_path = 'icon-4.png';
    $variables['fields']['field_case_solutions']->wrapper_attributes->addClass('csd-box-2', 'csd-color-2');
  }

}
