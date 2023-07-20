<?php

namespace Drupal\easy_slider\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Easy slider entities.
 */
interface EasySliderInterface extends ConfigEntityInterface {

  // Add get/set methods for your configuration properties here.
  public function getSlideImages();

  public function getSlideCaptions();

  public function getSlideSettings($field);
}
