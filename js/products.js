(function($, Drupal) {
  var numberProductsSelected =0;

  Drupal.behaviors.cart = {
    attach: function(context, settings) {
      // This will only get ran once
      $("[for^='check-product']").once("cart").click(function() {
        // Get number of elments in cookie to update number of products selected.
        var cookies = Cookies.get('products');
        if (cookies !== undefined) {
          var cookieProducts = cookies.split(",");
          if (cookieProducts.length > 0) {
            numberProductsSelected = cookieProducts.length;
          }
        }
        // Get the id of the label of product clicked.
        var elementId = $(this).attr("for");
        if ($(this).html() == "Add to cart") {
          numberProductsSelected = numberProductsSelected + 1;
          // If the product has not been already added to cart.
          $(this).html("Remove from cart");
          $(this).addClass("remove-product");
          // Set the input part of the check as 'checked'.
          $('#' + elementId).attr('checked', true);
          addCookies(elementId);
        } else {
          numberProductsSelected = numberProductsSelected - 1;
          // If the product is going to be removed from cart.
          $(this).html("Add to cart");
          $(this).removeClass("remove-product");
          // Uncheck the product.
          $('#' + elementId).attr('checked', false);
          removeCookies(elementId);
        }
        if (numberProductsSelected > 0) {
          $('button#button-checkout-block').removeClass("button-hidden");
          $('#span-checkout-block').attr('data-content',numberProductsSelected);
        }
        else {
          $('button#button-checkout-block').addClass("button-hidden");
          $('#span-checkout-block').attr('data-content',"");
        }
      });
      $(document).ready(function(){
        var cookieProducts = null, cookies = null;
        var products = null;
        cookies = Cookies.get('products');
        if (cookies !== undefined) {
          cookieProducts = cookies.split(",");
          $("[for^='check-product']").each(function( index ) {
            if (cookieProducts.includes( $(this).attr("for") )) {
              $(this).html("Remove from cart");
              $(this).addClass("remove-product");
              // numberProductsSelected = numberProductsSelected + 1;
            }
            if (cookieProducts.length > 0) {
              $('button#button-checkout-block').removeClass("button-hidden");
              $('#span-checkout-block').attr('data-content', cookieProducts.length);
            }
            else {
              $('button#button-checkout-block').addClass("button-hidden");
            }
          });
          // if (cookieProducts.length > 0) {
          //   $('#span-checkout-block').attr('data-content', cookieProducts.length);
          // }
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
