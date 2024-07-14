<?php

namespace Drupal\events_management\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for Events Management settings.
 */
class EventsManagementSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['events_management.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'events_management_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('events_management.settings');

    $form['show_past_events'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show past events'),
      '#default_value' => $config->get('show_past_events'),
    ];

    $form['events_per_page'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of events per page'),
      '#default_value' => $config->get('events_per_page'),
      '#min' => 1,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array $form, FormStateInterface $form_state) {
    $this->config('events_management.settings')
      ->set('show_past_events', $form_state->getValue('show_past_events'))
      ->set('events_per_page', $form_state->getValue('events_per_page'))
      ->save();

    // Log the configuration change.
    $this->logConfigurationChange($form_state->getValue('show_past_events'), $form_state->getValue('events_per_page'));

    parent::submitForm($form, $form_state);
  }

  /**
   * Log configuration changes.
   */
  protected function logConfigurationChange($show_past_events, $events_per_page) {
    $connection = \Drupal::database();
    $connection->insert('events_management_log')
      ->fields([
        'uid' => \Drupal::currentUser()->id(),
        'config' => json_encode([
          'show_past_events' => $show_past_events,
          'events_per_page' => $events_per_page,
        ]),
        'timestamp' => REQUEST_TIME,
      ])
      ->execute();
  }
}
