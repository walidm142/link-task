<?php

namespace Drupal\events_management\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;

/**
 * Provides a 'LatestEventsBlock' block.
 *
 * @Block(
 *   id = "latest_events_block",
 *   admin_label = @Translation("Latest Events Block"),
 * )
 */
class LatestEventsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $query = Database::getConnection()->select('event', 'e')
      ->fields('e', ['id', 'title', 'start_time'])
      ->orderBy('e.created', 'DESC')
      ->range(0, 5);
    $results = $query->execute()->fetchAll();

    $items = [];
    foreach ($results as $result) {
      $items[] = [
        '#type' => 'markup',
        '#markup' => $this->t('@title (@start_time)', ['@title' => $result->title, '@start_time' => $result->start_time]),
      ];
    }

    return [
      '#theme' => 'item_list',
      '#items' => $items,
      '#title' => $this->t('Latest Events'),
    ];
  }

}
