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
   public function getCookie(string $name);

    /**
     * Sets the cookie with a given name and a given content.
     *
     * @param string $name
     *   String containing the name of the cookie.
     * @param array $arrayProducts
     *   Array containing a list with products.
     *
     * @return boolean
     *   Return boolean containing the result of the operation.
     *     Values:
     *       0 - KO
     *       1 - OK
     */
     public function setCookie(string $name, array $arrayProducts = NULL);

}
