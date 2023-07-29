<?php

namespace Drupal\easy_slider\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'EasySliderBlock' block.
 *
 * @Block(
 *  id = "easy_slider_block",
 *  admin_label = @Translation("Easy slider block"),
 * )
 */
class EasySliderBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a EasySlider object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Entity type manager object.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Config factory object.
   */
  public function __construct($configuration, $plugin_id, $plugin_definition, $entityTypeManager, $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entityTypeManager;
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $easy_sliders = $this->entityTypeManager->getStorage('easy_slider')->loadMultiple();
    $dropdown_options = [];

    foreach ($easy_sliders as $slide) {
      $key = $slide->id();
      $value = $slide->label();
      $dropdown_options[$key] = $value;
    }

    $form['slides'] = [
      '#type' => 'select',
      '#title' => $this->t('Slides'),
      '#description' => $this->t('Choose from the list of slides to show'),
      '#default_value' => !empty($this->configuration['slides']) ?? '',
      '#options' => $dropdown_options,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['slides'] = $form_state->getValue('slides');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $slide_id = $this->configuration['slides'];
    $image_url = [];
    $build = [];

    if (!empty($slide_id)) {
      $easy_slide = $this->entityTypeManager->getStorage('easy_slider')->load($slide_id);
      $image_styles = $this->entityTypeManager->getStorage('image_style')->loadMultiple(['easy_slider_mobile', 'easy_slider_tablet', 'easy_slider_laptop', 'easy_slider_desktop']);
      $images = $easy_slide->getSlideImages();
      $captions = $easy_slide->getSlideCaptions();
      $settings = $easy_slide->getSlideSettings();

      if (!empty($images) && !empty($image_styles)) {
        foreach ($images as $key => $image_id) {
          foreach ($image_styles as $id => $image_style) {
            $file = $this->entityTypeManager->getStorage('file')->load($image_id);
            $image_url[$key][$id]['url'] = $image_style->buildUrl($file->getFileUri());
          }
        }
      }

      if (!empty($image_url) && !empty($captions) && !empty($settings)) {
        $build['#theme'] = 'easy_slider_block';
        $build['#images'] = $image_url;
        $build['#captions'] = $captions;
        $build['#settings'] = $settings;
      }
    }
    return $build;
  }

}
