<?php

namespace Drupal\easy_slider\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EasySliderForm.
 */
class EasySliderForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /**
     * @var \Drupal\easy_slider\Entity\EasySlider $easy_slider
     */
    $easy_slider = $this->entity;
    // dump($easy_slider->getSlideSettings('effect'));
    // dump($easy_slider->getSlideSettings('speed'));.
    $form['name'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Name'),
      '#open' => TRUE,
    ];

    $form['name']['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $easy_slider->label(),
      '#description' => $this->t("Label for the Easy slider."),
      '#required' => TRUE,
    ];

    $form['name']['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $easy_slider->id(),
      '#machine_name' => [
        'exists' => '\Drupal\easy_slider\Entity\EasySlider::load',
      ],
      '#disabled' => !$easy_slider->isNew(),
    ];

    // Image settings.
    $form['image'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Images'),
      '#open' => TRUE,
    ];

    $form['image']['slide_one'] = [
      '#type' => 'media_library',
      '#allowed_bundles' => ['image'],
      '#title' => $this->t('Slide image one'),
      '#description' => $this->t('Select image for slide one'),
      '#default_value' => !empty($easy_slider->getSlideImages()) ? $easy_slider->getSlideImages()[0] : NULL,
    ];

    $form['image']['slide_one_caption'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Slide one caption'),
      '#description' => $this->t('Add caption for slide one'),
      '#default_value' => !empty($easy_slider->getSlideCaptions()) ? $easy_slider->getSlideCaptions()[0] : NULL,
    ];

    $form['image']['slide_two'] = [
      '#type' => 'media_library',
      '#allowed_bundles' => ['image'],
      '#title' => $this->t('Slide image two'),
      '#description' => $this->t('Select image for slide two'),
      '#default_value' => !empty($easy_slider->getSlideImages()) ? $easy_slider->getSlideImages()[1] : NULL,
    ];

    $form['image']['slide_two_caption'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Slide two caption'),
      '#description' => $this->t('Add caption for slide two'),
      '#default_value' => !empty($easy_slider->getSlideCaptions()) ? $easy_slider->getSlideCaptions()[1] : NULL,
    ];

    $form['image']['slide_three'] = [
      '#type' => 'media_library',
      '#allowed_bundles' => ['image'],
      '#title' => $this->t('Slide image three'),
      '#description' => $this->t('Select image for slide three'),
      '#default_value' => !empty($easy_slider->getSlideImages()) ? $easy_slider->getSlideImages()[2] : NULL,
    ];

    $form['image']['slide_three_caption'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Slide three caption'),
      '#description' => $this->t('Add caption for slide three'),
      '#default_value' => !empty($easy_slider->getSlideCaptions()) ? $easy_slider->getSlideCaptions()[2] : NULL,
    ];

    $form['slide_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Settings'),
      '#open' => TRUE,
    ];

    $effects = [
      'normal' => $this->t('Normal'),
      'fade' => $this->t('Fade'),
      'ripple' => $this->t('Ripple'),
    ];

    $form['slide_settings']['effect'] = [
      '#type' => 'select',
      '#title' => $this->t('Slide effect'),
      '#description' => $this->t('Choose a slide effect'),
      '#options' => $effects,
      '#default_value' => !empty($easy_slider->getSlideSettings()) ? $easy_slider->getSlideSettings()['effect'] : NULL,
    ];

    $form['slide_settings']['speed'] = [
      '#type' => 'number',
      '#title' => $this->t('Slide animation/fade speed'),
      '#description' => $this->t('Choose a slide animation or fade speed, e.g 300'),
      '#default_value' => !empty($easy_slider->getSlideSettings()) ? intval($easy_slider->getSlideSettings()['speed']) : NULL,
    ];

    $form['slide_settings']['arrows'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Slide arrows'),
      '#description' => $this->t('Enable/disable slide arrows'),
      '#default_value' => !empty($easy_slider->getSlideSettings()) ? $easy_slider->getSlideSettings()['arrows'] : NULL,
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /**
     * @var \Drupal\easy_slider\Entity\EasySlider $easy_slider
     */
    $easy_slider = $this->entity;

    $captions = [];
    $captions[0] = $form_state->getValue('slide_one_caption');
    $captions[1] = $form_state->getValue('slide_two_caption');
    $captions[2] = $form_state->getValue('slide_three_caption');

    $images = [];
    $images[0] = $form_state->getValue('slide_one');
    $images[1] = $form_state->getValue('slide_two');
    $images[2] = $form_state->getValue('slide_three');

    $settings = [];
    $settings['effect'] = $form_state->getValue('effect');
    $settings['speed'] = $form_state->getValue('speed');
    $settings['arrows'] = $form_state->getValue('arrows');

    $easy_slider->setSlideCaptions($captions);
    $easy_slider->setSlideImages($images);
    $easy_slider->setSlideSettings($settings);
    $status = $easy_slider->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Easy slider.', [
          '%label' => $easy_slider->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Easy slider.', [
          '%label' => $easy_slider->label(),
        ]));
    }
    $form_state->setRedirectUrl($easy_slider->toUrl('collection'));
  }

}
