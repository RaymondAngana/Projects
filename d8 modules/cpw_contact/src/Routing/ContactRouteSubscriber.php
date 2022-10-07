<?php 

namespace Drupal\cpw_contact\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;
/**
 * Listens to the dynamic route events.
 */
class ContactRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Remove '/contact_us' route.
    // This gives security issue during scans.
    if ($route = $collection->get('dsu_engage.form')) {
      $collection->remove('dsu_engage.form');
    }
  }
}