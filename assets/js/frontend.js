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
