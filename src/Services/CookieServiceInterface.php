<?php

namespace Drupal\products\Services;

/**
 * Interface CookieServiceInterface.
 */
interface CookieServiceInterface {

  /**
   * Gets the cookie with a given name.
   *
   * @param string $name
   *   String containing the name of the cookie.
   *
   * @return array
   *   Return array containing the data of the cookie.
   */
   function getCookie(string $name);

   /**
    * Removes the cookie with a given name.
    *
    * @param string $name
    *   String containing the name of the cookie.
    *
    */
    function removeCookie(string $name);

}
