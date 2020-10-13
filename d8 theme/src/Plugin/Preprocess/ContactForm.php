<?php

namespace Drupal\main\Plugin\Preprocess;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Render\Element;
use Drupal\Core\Url;
use Drupal\main\PreprocessInterface;

/**
 * Preprocess for contact form template.
 *
 * @mainPreprocess("contact_form")
 */
class ContactForm extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook) {
    // This is exactly from template_preprocess_form().
    $element = $variables['element'];
    if (isset($element['#action'])) {
      $element['#attributes']['action'] = UrlHelper::stripDangerousProtocols($element['#action']);
    }
    Element::setAttributes($element, array('method', 'id'));
    if (empty($element['#attributes']['accept-charset'])) {
      $element['#attributes']['accept-charset'] = "UTF-8";
    }
    $variables['attributes'] = $element['#attributes'];
    $variables['children'] = $element['#children'];

    // @todo Make the rest configurable next time.
    $variables['team_link'] = [
      '#type' => 'link',
      '#title' => $this->t('Learn more about our team.'),
      '#url' => Url::fromRoute('view.team_landing.page_1'),
    ];

    $variables['address'] = [
      '#markup' => implode('<br />', [
        'main Source',
        '4809 N. Ravenswood Ave.',
        'Suite 126',
        'Chicago, IL 60640',
      ]),
    ];

    $variables['phone'] = [
      '#markup' => implode('<br />', [
        'Phone number:',
        '773-525-8255',
      ]),
    ];
  }

}
