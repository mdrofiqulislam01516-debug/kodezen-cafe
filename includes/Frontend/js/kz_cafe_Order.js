jQuery(document).ready(function($){
    $('#kz-cafe-order-form').on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        $('#kz-order-response').html('Processing...');

        $.ajax({
            url: kzCafeOrder.ajax_url,
            method: 'POST',
            data: {
                action: 'kz_cafe_submit_order',
                nonce: kzCafeOrder.nonce,
                customer_name: form.find('[name="customer_name"]').val(),
                customer_email: form.find('[name="customer_email"]').val(),
                order_items: form.find('[name="order_items"]').val(),
                total_price: form.find('[name="total_price"]').val(),
                quantity: form.find('[name="quantity"]').val(),

            },
            success: function(res){
                if(res.success){
                    form[0].reset();
                    $('#kz-order-response').html('<span style="color:green;">'+res.data+'</span>');
                } else {
                    $('#kz-order-response').html('<span style="color:red;">'+res.data+'</span>');
                }
            }
        });
    });
});




// ;(function($){
//     $('#kz-cafe-order-form form').on('submit', function(e) {
//         e.preventDefault();

//         var data = $(this).serialize();

//         $.post('')

//     });
// })(jQuery);


// jQuery(document).ready(function ($) {
//     $("#kz-cafe-order-form").on("submit", function (e) {
//         e.preventDefault();

//         $("#kz-order-response").html("<span style='color: blue;'>Processing your order...</span>");

//         var formData = {
//             action: "kz_cafe_submit_order",
//             nonce: kzCafeOrder.nonce,
//             customer_name: $("#kz-cafe-customer-name").val(),
//             customer_email: $("#kz-cafe-customer-email").val(),
//             order_items: $("#kz-cafe-order-items").val(),
//             total_price: $("#kz-cafe-total-price").val(),
//             quantity: $("#kz-cafe-order-quantity").val(),
//             user_id: $("input[name='user_id']").val(),
//         };

//         $.post(kzCafeOrder.ajax_url, formData, function (response) {
//             if (response.success) {
//                 $("#kz-order-response").html("<span style='color: green;'>" + response.data.message + "</span>");
//                 $("#kz-cafe-order-form")[0].reset();
//             } else {
//                 $("#kz-order-response").html("<span style='color: red;'>" + response.data.message + "</span>");
//             }
//         }).fail(function () {
//             $("#kz-order-response").html("<span style='color: red;'>Error submitting your order. Please try again.</span>");
//         });
//     });
// });


// jQuery(document).ready(function ($) {
//   $("#kz-cafe-order-form").on("submit", function (e) {
//     e.preventDefault();

//     // Clear previous messages
//     $("#kz-cafe-order-message").html("Processing");

//     // Gather form data
//     var data = {
//       action: "kz_cafe_submit_order",
//       nonce: kzCafeOrder.nonce,
//       customer_name: $("#kz-cafe-customer-name").val(),
//       customer_email: $("#kz-cafe-customer-email").val(),
//       order_items: $("#kz-cafe-order-items").val(),
//       total_price: $("#kz-cafe-total-price").val(),
//       quantity: $("#kz-cafe-order-quantity").val(),
//     };

//     // Disable submit button to prevent multiple clicks
//     var $btn = $(this).find('button[type="submit"]');
//     $btn.prop("disabled", true).text("Order submit");

//     // AJAX request
//     $.post(kzCafeOrder.ajax_url, data, function (response) {
//       if (response.success) {
//         $("#kz-cafe-order-message").html(
//           '<div class="kz-success">' + response.data.message + "</div>"
//         );
//         $("#kz-cafe-order-form")[0].reset(); // Reset form
//       } else {
//         $("#kz-cafe-order-message").html(
//           '<div class="kz-error">' + response.data.message + "</div>"
//         );
//       }
//     })
//       .fail(function () {
//         $("#kz-cafe-order-message").html(
//           '<div class="kz-error">Something went wrong. Please try again.</div>'
//         );
//       })
//       .always(function () {
//         $btn.prop("disabled", false).text("Order Submit");
//       });
//   });
// });
