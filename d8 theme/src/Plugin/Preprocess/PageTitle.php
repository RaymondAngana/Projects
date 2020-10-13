<?php

/**
 * @file
 * Contains \Drupal\main\Plugin\Preprocess\PageTitle.
 */

namespace Drupal\main\Plugin\Preprocess;

use Drupal\main\Plugin\Preprocess\PreprocessBase;
use Drupal\main\PreprocessInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Preprocess for page title templates.
 *
 * @mainPreprocess("page_title")
 */
class PageTitle extends PreprocessBase implements PreprocessInterface, ContainerFactoryPluginInterface {

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
    if (($node = $this->routeMatch->getParameter('node')) && $node->getType() === 'case') {
      $variables['subtitle'] = $node->get('field_case_subtitle')->value;

      if (!$node->field_case_headimg->isEmpty()) {
        $variables['#attached']['drupalSettings']['caseStudyHeaderImage'] = file_create_url($node->field_case_headimg->entity->getFileUri());
      }
    }

    if ($user = $this->routeMatch->getParameter('user')) {
      if (is_array($variables['title'])) {
        $variables['title']['#markup'] = $user->get('field_user_first_name')->value . ' ' . $user->get('field_user_last_name')->value;
        $variables['subtitle'] = $user->get('field_user_subtitle')->value;
      }
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
