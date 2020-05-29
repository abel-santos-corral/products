<?php

namespace Drupal\products\Services;

use \Symfony\Component\HttpFoundation\Cookie;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;

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
      return explode(",", $cookie);
    }
    else {
      return FALSE;
    }
  }
  /**
   * {@inheritdoc}
   */
  public function setCookie(string $name, array $arrayProducts = NULL){
    if (empty($name)) {
      \Drupal::logger('products')->error($this->t('Field name is not correct. Please check!'));
      return FALSE;
    }
    if (is_null($arrayProducts)) {
      \Drupal::logger('products')->error(t('Field jsonProducts is not correct. Please check!'));
      return FALSE;
    }
    if (!is_Array($arrayProducts)) {
      \Drupal::logger('products')->error(t('Field arrayProducts is not an array. Please check!'));
      return FALSE;
    }
    $response = new Response();
    $cookie = new Cookie($name,join(",",$arrayProducts), 0, '/' , NULL, FALSE);
    $response->headers->setCookie($cookie);
    $response->send();
  }
}
