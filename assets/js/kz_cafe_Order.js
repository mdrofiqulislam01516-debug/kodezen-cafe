jQuery(document).ready(function($) {
    $('#kz-cafe-order-form').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var responseBox = $('#kz-order-response');

        responseBox.html('<span style="color:#555;">Processing your order...</span>');

        $.ajax({
            url: kzCafeOrder.ajax_url,
            method: 'POST',
            data: {
                action: 'kz_cafe_submit_order',
                nonce: kzCafeOrder.nonce,
                customer_name:  form.find('[name="customer_name"]').val(),
                customer_email: form.find('[name="customer_email"]').val(),
                order_items:    form.find('[name="order_items"]').val(),
                total_price:    form.find('[name="total_price"]').val(),
                quantity:       form.find('[name="quantity"]').val(),
                product_id:     form.find('[name="product_id"]').val(), 
            },
            success: function(res) {
                if (res.success) {
                    form[0].reset();
                    responseBox.html('<span style="color:green;">' + res.data + '</span>');
                } else {
                    responseBox.html('<span style="color:red;">' + res.data + '</span>');
                }
            },
            error: function() {
                responseBox.html('<span style="color:red;">Something went wrong. Please try again.</span>');
            }
        });
    });
});
