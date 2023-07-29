<?php

namespace Drupal\easy_slider\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Easy slider entities.
 */
interface EasySliderInterface extends ConfigEntityInterface {

  /**
   * Get images.
   */
  public function getSlideImages();

  /**
   * Get captions.
   */
  public function getSlideCaptions();

  /**
   * Get slide settings.
   */
  public function getSlideSettings();

  /**
   * Set slide images.
   *
   * @param array $images
   */
  public function setSlideImages($image);

  /**
   * Set slide captions.
   *
   * @param array $captions
   */
  public function setSlideCaptions($caption);

  /**
   * Set slide settings.
   *
   * @param array $settings
   */
  public function setSlideSettings($settings);

}
