<?php

/**
 * @file
 * Contains \Drupal\main\PreprocessInterface.
 */

namespace Drupal\main;

/**
 * Interface for preprocesses.
 */
interface PreprocessInterface {

  /**
   * Preprocess theme hook variables.
   *
   * @param $variables
   *   The variables array (modify in place).
   * @param $hook
   *   The name of the theme hook.
   */
  public function preprocess(array &$variables, $hook);
}
