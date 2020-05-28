<?php

namespace Drupal\products\Services;

use \Symfony\Component\HttpFoundation\Cookie;
use \Symfony\Component\HttpFoundation\Response;

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
  public function getCookie(string $name) {
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
  public function removeCookie(string $name) {
    if (empty($name)) {
      return FALSE;
    }
  }
  /**
   * {@inheritdoc}
   */
  public function setCookie(string $name, string $jsonProducts = NULL){
    if (empty($name)) {
      \Drupal::logger('products')->error($this->t('Field name is not correct. Please check!'));
      return FALSE;
    }
    if (is_null($jsonProducts)) {
      \Drupal::logger('products')->error(t('Field jsonProducts is not correct. Please check!'));
      return FALSE;
    }
    if (is_null(json_decode($jsonProducts))) {
      \Drupal::logger('products')->error(t('Field jsonProducts has not correct JSON format. Please check!'));
      return FALSE;
    }
    // user_cookie_save([$name => $jsonProducts]);
    $response = new Response();
    $cookie = new Cookie($name,$jsonProducts, 0, '/' , NULL, FALSE);
    // $cookie = new Cookie('Test','Derp', 0, '/' , NULL, FALSE);
    $response->headers->setCookie($cookie);
    $response->send();
  }
}
