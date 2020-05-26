<?php

namespace Drupal\products\Services;

use \Symfony\Component\HttpFoundation\Cookie;

/**
 * Class CookieService.
 */
class CookieService implements CookieServiceInterface {

  /**
   * Constructs a new CookieService object.
   */
  public function __construct() {

  }


  /**
   * {@inheritdoc}
   */
  function getCookie(string $name) {
    if (empty($name)) {
      return FALSE;
    }
    $hasCookie = \Drupal::request()->cookies->has($name);
    if ($hasCookie) {
      $cookie = \Drupal::request()->cookies->get($name);
      return json_decode($cookie,true);
    }
    else {
      return FALSE;
    }
  }
   /**
    * {@inheritdoc}
    */
  function removeCookie(string $name) {
    if (empty($name)) {
      return FALSE;
    }
  }
}
