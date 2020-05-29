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
      $(document).ready(function(){
        alert("estoy!");
        var cookieProducts = null, cookies = null;
        var products = null;
        cookies = Cookies.get('products');
        if (cookies !== undefined) {
          cookieProducts = cookies.split(",");
          $("[for^='check-product']").each(function( index ) {
            if (cookieProducts.includes( $(this).attr("for") )) {
              $(this).html("Remove from cart");
              $(this).addClass("remove-product");
            }
          });
        }
      });
    }
  }

  function addCookies(nid) {
    var cookieProducts = null, cookies = null;
    cookies = Cookies.get('products');
    if (cookies === undefined) {
      cookieProducts = new Array(nid);
      Cookies.set('products', cookieProducts.join(","));
    }
    else {
      cookieProducts = cookies.split(",");
      if(cookieProducts.indexOf(nid) == -1){
        // Avoids adding duplicated values.
          cookieProducts.push(nid);
      }
      Cookies.set('products', cookieProducts.join(","));
    }
  }

  function removeCookies(nid) {
    var cookieProducts = null, cookies = null;
    cookies = Cookies.get('products');
    if (cookies === undefined) {
      Cookies.remove('products');
    }
    else {
      cookieProducts = cookies.split(",");
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
        Cookies.set('products', cookieProducts.join(","));
      }
    }
  }
})(jQuery, Drupal);
