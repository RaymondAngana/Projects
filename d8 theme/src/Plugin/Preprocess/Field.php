<?php

namespace Drupal\main\Plugin\Preprocess;

use Drupal\Core\Url;
use Drupal\main\PreprocessInterface;

/**
 * Preprocess for page templates.
 *
 * @mainPreprocess("field")
 */
class Field extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook) {
    $variables['base_path'] = base_path();

    if ($variables['entity_type'] === 'paragraph') {
      if ($variables['field_name'] === 'field_client_image' &&
         !$variables['element']['#object']->get('field_client_link')->isEmpty()) {
        $link = $variables['element']['#object']
          ->get('field_client_link')
          ->first()
          ->getValue();

        $variables['link'] = Url::fromUri($link['uri'])->toString();
      }

      if ($variables['field_name'] === 'field_do_link' && !$variables['element']['#object']->get('field_do_link')->isEmpty()) {
        $variables['items'][0]['content']['#title'] = $this->t(
          '@title <i class="fa fa-chevron-right"></i>',
          ['@title' => $variables['items'][0]['content']['#title']]
        );

        $link = $variables['element']['#object']
          ->get('field_do_link')
          ->first()
          ->getValue();

        $variables['link'] = Url::fromUri($link['uri'])->toString();
      }
    }
  }

}
