<?php

namespace Drupal\juicerio\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class JuicerAdminForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'juicer_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['juicerio.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('juicerio.settings');

    $form['juicer_feed_id'] = array(
      '#type' => 'textfield',
      '#title' => t('Juicer Username'),
      '#default_value' => $site_config->get('juicer_feed_id'),
      '#weight' => 1,
    );

    $form['juicer_blocks'] = array(
      '#type' => 'select',
      '#title' => t('Number of Juicer feed blocks'),
      '#options' => array(1 => t('One'), 2 => t('Two'), 3 => t('Three')),
      '#default_value' => $site_config->get('juicer_blocks'),
      '#description' => t('Only paid Juicer accounts can place more than one feed.'),
      '#weight' => 2,
    );

    $form['juicer_js_embed'] = array(
      '#type' => 'select',
      '#title' => t('Juicer Javascript to load'),
      '#description' => t('Juicer provides different javascript files in case you are having issues with a conflicting version of jQuery or Slick in their default embed.'),
      '#options' => array(
        'juicerio.embed' => t('Juicer default (embed.js)'),
        'juicerio.embed_no_jquery' => t('No jQuery (embed-no-jquery.js)'),
        'juicerio.embed_no_jquery_no_slick' => t('No jQuery and No Slick (embed-no-jquery-no-slick.js)'),
      ),
      '#default_value' => $site_config->get('juicer_js_embed', 'juicerio.embed_no_jquery'),
      '#weight' => 3,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('juicerio.settings')
      ->set('juicer_feed_id', $form_state->getValue('juicer_feed_id'))
      ->set('juicer_blocks', $form_state->getValue('juicer_blocks'))
      ->set('juicer_js_embed', $form_state->getValue('juicer_js_embed'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
