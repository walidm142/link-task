<?php

namespace Drupal\events_management;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the event entity type.
 */
class EventListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['title'] = $this->t('Title');
    $header['start_time'] = $this->t('Start Time');
    $header['end_time'] = $this->t('End Time');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\events_management\Entity\Event $entity */
    $row['id'] = $entity->id();
    $row['title'] = $entity->label();
    $row['start_time'] = $entity->get('start_time')->value;
    $row['end_time'] = $entity->get('end_time')->value;
    return $row + parent::buildRow($entity);
  }
}
