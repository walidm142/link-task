<?php

namespace Drupal\events_management\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Event entity.
 *
 * @ContentEntityType(
 *   id = "event",
 *   label = @Translation("Event"),
 *   base_table = "event",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\events_management\EventListBuilder",
 *     "form" = {
 *       "add" = "Drupal\events_management\Form\EventForm",
 *       "edit" = "Drupal\events_management\Form\EventForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "access" = "Drupal\Core\Entity\EntityAccessControlHandler",
 *   },
 * )
 */
class Event extends ContentEntityBase {
  // Define fields and methods here.
  
  /**
   * Define base fields.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE);

    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Image'));

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'));

    $fields['start_time'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Start Time'))
      ->setRequired(TRUE);

    $fields['end_time'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('End Time'))
      ->setRequired(TRUE);

    $fields['category'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Category'))
      ->setSettings([
        'allowed_values' => [
          'conference' => 'Conference',
          'webinar' => 'Webinar',
          'workshop' => 'Workshop',
          'meeting' => 'Meeting',
        ],
      ]);

    return $fields;
  }
}
