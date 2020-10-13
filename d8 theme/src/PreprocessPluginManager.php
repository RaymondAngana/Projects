<?php

/**
 * @file
 * Contains \Drupal\main\PreprocessPluginManager.
 */

namespace Drupal\main;

use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages preprocess plugins.
 *
 * This handles preprocess hooks. An example to manage the preprocess variables
 * from Page is to define a new Plugin with a Plugin ID of 'page'.
 *
 * @todo This doesn't work if this is used as a base theme. Discovery is just
 * within this theme.
 *
 * @see \Drupal\bootstrap\Plugin\PreprocessManager.
 */
class PreprocessPluginManager extends DefaultPluginManager {

  /**
   * Creates the discovery object.
   *
   * Discovery just so happens to be within this theme. :D
   */
  public function __construct() {
    $this->subdir = 'Plugin/Preprocess';
    $this->pluginDefinitionAnnotationName = 'Drupal\main\Annotation\mainPreprocess';
    $this->pluginInterface = 'Drupal\main\PreprocessInterface';
    $this->themeHandler = \Drupal::service('theme_handler');
    $this->namespaces = new \ArrayObject([
      'Drupal\\main' => [DRUPAL_ROOT . '/' . $this->themeHandler->getTheme('main')->getPath() . '/src']
    ]);
  }

  /**
   * {@inheritdoc}
   */
  protected function providerExists($provider) {
    return $this->themeHandler->themeExists($provider);
  }

}
