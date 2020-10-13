<?php

namespace Drupal\main\Plugin\Preprocess;

use Drupal\Core\Template\Attribute;
use Drupal\main\Plugin\Preprocess\PreprocessBase;
use Drupal\main\PreprocessInterface;
use Drupal\views\Views;

/**
 * Preprocess for pager templates.
 *
 * @mainPreprocess("pager")
 */
class Pager extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook) {
    // Checks if we have several pages of results.
    if (isset($variables['items']) && is_array($variables['items']['pages'])) {
      $variables['items']['prev']['attributes'] = new Attribute(['class' => ['prev']]);
      $variables['items']['next']['attributes'] = new Attribute(['class' => ['next']]);

      foreach ($variables['items']['pages'] as $key => &$item) {
        if ($key !== $variables['current']) {
          continue;
        }

        $item['attributes'] = new Attribute(['class' => ['current']]);
      }
    }
  }

}
