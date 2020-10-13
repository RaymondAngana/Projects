<?php

namespace Drupal\main\Plugin\Preprocess;

use Drupal\main\PreprocessInterface;

/**
 * Preprocess for views view fields.
 *
 * @mainPreprocess("views_view")
 */
class ViewsView extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook) {
    if ($variables['view']->id() === 'homepage' &&
        $variables['view']->current_display === 'block_1' &&
        !empty($variables['more'])) {
      $variables['more']['#prefix'] = '<div class="col-sm-12">';
      $variables['more']['#attributes']['class'][] = 'exp-in';
      $variables['more']['#suffix'] = '</div>';
      $variables['more']['#title'] = $this->t(
        '@title <i class="fa fa-chevron-right"></i>',
        ['@title' => $variables['more']['#title']]
      );
    }
  }

}
