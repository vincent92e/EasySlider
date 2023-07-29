<?php

namespace Drupal\easy_slider\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Easy slider entity.
 *
 * @ConfigEntityType(
 *   id = "easy_slider",
 *   label = @Translation("Easy slider"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\easy_slider\EasySliderListBuilder",
 *     "form" = {
 *       "add" = "Drupal\easy_slider\Form\EasySliderForm",
 *       "edit" = "Drupal\easy_slider\Form\EasySliderForm",
 *       "delete" = "Drupal\easy_slider\Form\EasySliderDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\easy_slider\EasySliderHtmlRouteProvider",
 *     },
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "slide_images",
 *     "slide_captions",
 *     "slide_settings",
 *   },
 *   config_prefix = "easy_slider",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "slide_images" = "slide_images",
 *     "slide_captions" = "slide_captions",
 *     "slide_settings" = "slide_settings",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/easy_slider/{easy_slider}",
 *     "add-form" = "/admin/structure/easy_slider/add",
 *     "edit-form" = "/admin/structure/easy_slider/{easy_slider}/edit",
 *     "delete-form" = "/admin/structure/easy_slider/{easy_slider}/delete",
 *     "collection" = "/admin/structure/easy_slider"
 *   }
 * )
 */
class EasySlider extends ConfigEntityBase implements EasySliderInterface {

  /**
   * The Easy slider ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Easy slider label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Easy slider images.
   *
   * @var array
   */
  protected $slide_images;

  /**
   * The Easy slider captions.
   *
   * @var array
   */
  protected $slide_captions;

  /**
   * The Easy slider settings.
   *
   * @var array
   */
  protected $slide_settings;

  /**
   * Get images.
   */
  public function getSlideImages() {
    return $this->get('slide_images');
  }

  /**
   * Get captions.
   */
  public function getSlideCaptions() {
    return $this->get('slide_captions');
  }

  /**
   * Get slide settings.
   */
  public function getSlideSettings() {
    return $this->get('slide_settings');
  }

  /**
   * Set slide images.
   *
   * @param array $images
   */
  public function setSlideImages($images) {
    return $this->set('slide_images', $images);
  }

  /**
   * Set slide captions.
   *
   * @param array $captions
   */
  public function setSlideCaptions($captions) {
    return $this->set('slide_captions', $captions);
  }

  /**
   * Set slide settings.
   *
   * @param array $settings
   */
  public function setSlideSettings($settings) {
    return $this->set('slide_settings', $settings);
  }

}
