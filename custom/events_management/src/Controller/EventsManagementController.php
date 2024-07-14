<?php

namespace Drupal\events_management\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\views\Views;

/**
 * Returns responses for Events Management routes.
 */
class EventsManagementController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function listEvents(Request $request) {
    // Get the configuration.
    $config = $this->config('events_management.settings');
    $show_past_events = $config->get('show_past_events');
    $events_per_page = $config->get('events_per_page');

    // Create a View to list events.
    $view = Views::getView('events');
    if (is_object($view)) {
      $view->setDisplay('page');
      $view->setArguments([$show_past_events, $events_per_page]);
      $view->execute();
      return $view->render();
    }
    else {
      return [
        '#type' => 'markup',
        '#markup' => $this->t('No events found.'),
      ];
    }
  }
}
