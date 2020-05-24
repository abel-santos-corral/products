(function ($, Drupal) {
  Drupal.behaviors.cart = {
    attach: function (context, settings) {
      // This will only get ran once
      $("[for^='check-product']").once("cart").click(function() {
        // Get the id of the label of product clicked.
        var elementId = $(this).attr("for");
        if ($(this).html() == "Add to cart") {
          // If the product has not been already added to cart.
          $(this).html("Remove from cart");
          $(this).addClass("remove-product");
          // Set the input part of the check as 'checked'.
          $('#' + elementId).attr('checked',true);
        }
        else {
          // If the product is going to be removed from cart.
          $(this).html("Add to cart");
          $(this).removeClass("remove-product");
          // Uncheck the product.
          $('#' + elementId).attr('checked',false);
        }
      });

    }
  }
})(jQuery, Drupal);
