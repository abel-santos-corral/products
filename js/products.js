(function($, Drupal) {
  Drupal.behaviors.cart = {
    attach: function(context, settings) {
      // This will only get ran once
      $("[for^='check-product']").once("cart").click(function() {
        // Get the id of the label of product clicked.
        var elementId = $(this).attr("for");
        if ($(this).html() == "Add to cart") {
          // If the product has not been already added to cart.
          $(this).html("Remove from cart");
          $(this).addClass("remove-product");
          // Set the input part of the check as 'checked'.
          $('#' + elementId).attr('checked', true);
          addCookies(elementId);
        } else {
          // If the product is going to be removed from cart.
          $(this).html("Add to cart");
          $(this).removeClass("remove-product");
          // Uncheck the product.
          $('#' + elementId).attr('checked', false);
          removeCookies(elementId);
        }
      });
    }
  }

  function addCookies(nid) {
    var cookieProducts = null, cookies = null;
    cookies = Cookies.get('products');
    if (cookies === undefined) {
      cookieProducts = new Array(nid);
      var json_str = JSON.stringify(cookieProducts);
      Cookies.set('products', json_str);
    }
    else {
      cookieProducts = JSON.parse(cookies);
      cookieProducts.push(nid);
      var json_str = JSON.stringify(cookieProducts);
      Cookies.set('products', json_str);
    }
  }

  function removeCookies(nid) {
    var cookieProducts = null, cookies = null;
    cookies = Cookies.get('products');
    if (cookies === undefined) {
      Cookies.remove('products');
    }
    else {
      cookieProducts = JSON.parse(cookies);
      var i = 0;
      while (i < cookieProducts.length) {
        if(cookieProducts[i] === nid) {
            cookieProducts.splice(i, 1);
        } else {
            ++i;
        }
      }
      if (cookieProducts.length == 0) {
        Cookies.remove('products');
      }
      else {
        var json_str = JSON.stringify(cookieProducts);
        Cookies.set('products', json_str);
      }
    }
  }
})(jQuery, Drupal);
