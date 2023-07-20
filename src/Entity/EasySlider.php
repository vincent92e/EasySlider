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
 *     "slide_images" = "slide_images",
 *     "slide_captions" = "slide_captions",
 *     "slide_settings" = "slide_settings",
 *     "uuid" = "uuid",
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
  protected $slider_images;

  public function getSlideImages() {
    return $this->get('slide_images');
  }

  public function getSlideCaptions() {
    return $this->get('slide_captions');
  }

  public function getSlideSettings($field) {
    return $this->get("slide_settings.{$field}");
  }

}
