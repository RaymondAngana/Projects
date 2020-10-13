<?php

/**
 * @file
 * Contains \Drupal\main\Plugin\Preprocess\Block.
 */

namespace Drupal\main\Plugin\Preprocess;

use Drupal\main\Plugin\Preprocess\PreprocessBase;
use Drupal\main\PreprocessInterface;
use Drupal\block\Entity\Block as BlockEntityConfiguration;
use Drupal\Core\Render\Element;
use Drupal\Component\Utility\Html;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Preprocess for block templates.
 *
 * @mainPreprocess("block")
 */
class Block extends PreprocessBase implements PreprocessInterface, ContainerFactoryPluginInterface {

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public function preprocess(array &$variables, $hook) {
    $block = BlockEntityConfiguration::load($variables['elements']['#id']);

    switch ($block->getRegion()) {
      // @todo This adds bootstrap classes to blocks. If this gets longer, it
      // might be a better idea to provide a template for a block per region.
      // Dunno.
      case 'footer_before':
        $block_id = $block->getPluginId();

        $variables['attributes']['class'][] = 'col-md-3';
        $variables['attributes']['class'][] = ($block_id != 'system_branding_block') ? 'col-sm-4' : '';
        $variables['attributes']['class'][] = ($block_id != 'mainsource_social') ? 'col-xs-12' : '';
        break;
    }

    switch ($variables['plugin_id']) {
      // Traverse through each element from the mainsource_social block to convert
      // them to 'fontawesome' elements.
      case 'mainsource_social':
        foreach (Element::children($variables['content']['social']) as $key) {
          $icon = [
            'icon' => [
              '#type' => 'html_tag',
              '#tag' => 'i',
              '#attributes' => ['class' => ['fa fab', 'fa-' . Html::getClass($key)]],
            ],
            'visually_hidden_text' => [
              '#type' => 'html_tag',
              '#tag' => 'span',
              '#value' => ucfirst($key),
              '#attributes' => ['class' => 'visually-hidden'],
            ]
          ];
          $variables['content']['social'][$key] = [
            '#type' => 'html_tag',
            '#tag' => 'a',
            '#value' => drupal_render($icon),
            '#attributes' => [
              'href' => $variables['content']['social'][$key]['#url']->toString(),
              'alt' => (string) $variables['content']['social'][$key]['#title'],
              'title' => (string) $variables['content']['social'][$key]['#title'],
              'target' => '_blank',
              'class' => "{$key}",
            ],
          ];
        }

        break;

      case 'system_main_block':
        if ($node = $this->routeMatch->getParameter('node')) {
          $variables['node'] = $node;
        }

        break;
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match')
    );
  }

}
