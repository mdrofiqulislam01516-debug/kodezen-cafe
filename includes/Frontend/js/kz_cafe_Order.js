jQuery(document).ready(function ($) {
  $("#kz-cafe-order-form").on("submit", function (e) {
    e.preventDefault();

    // Clear previous messages
    $("#kz-cafe-order-message").html("");

    // Gather form data
    var data = {
      action: "kz_cafe_submit_order",
      nonce: kzCafeOrder.nonce,
      customer_name: $("#kz-cafe-customer-name").val(),
      customer_email: $("#kz-cafe-customer-email").val(),
      order_items: $("#kz-cafe-order-items").val(),
      total_price: $("#kz-cafe-total-price").val(),
      quantity: $("#kz-cafe-quantity").val(),
    };

    // Disable submit button to prevent multiple clicks
    var $btn = $(this).find('button[type="submit"]');
    $btn.prop("disabled", true).text("Placing order...");

    // AJAX request
    $.post(kzCafeOrder.ajax_url, data, function (response) {
      if (response.success) {
        $("#kz-cafe-order-message").html(
          '<div class="kz-success">' + response.data.message + "</div>"
        );
        $("#kz-cafe-order-form")[0].reset(); // Reset form
      } else {
        $("#kz-cafe-order-message").html(
          '<div class="kz-error">' + response.data.message + "</div>"
        );
      }
    })
      .fail(function () {
        $("#kz-cafe-order-message").html(
          '<div class="kz-error">Something went wrong. Please try again.</div>'
        );
      })
      .always(function () {
        $btn.prop("disabled", false).text("Place Order");
      });
  });
});
