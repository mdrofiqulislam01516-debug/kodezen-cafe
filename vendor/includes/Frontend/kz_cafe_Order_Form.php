<?php
namespace kodezen\cafe\Frontend;

/**
 * Order F
 */
class kz_cafe_Order_Form {

    function __construct() {

        
        
        add_action( 'wp_ajax_kz_cafe_submit_order', [ $this, 'submit_order' ] );
        add_action( 'wp_ajax_nopriv_kz_cafe_submit_order', [ $this, 'submit_order' ] );

        // Enqueue JS
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );


    }

    public function enqueue_scripts() {

        wp_enqueue_script( 'kz-cafe-order', plugin_dir_url( __DIR__ ) . 'Frontend/js/kz_cafe_Order.js', ['jquery'], filemtime( KZ_CAFE_PATH . '/includes/Frontend/js/kz_cafe_Order.js'), true );

        wp_localize_script( 'kz-cafe-order', 'kzCafeOrder', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'kz_cafe_order_nonce' ),
        ]);
    }

   

    /**
     * Handle AJAX order submission
     */
    public function submit_order() {
        check_ajax_referer( 'kz_cafe_order_nonce', 'nonce' );

        error_log('submit_order');

        $name  = sanitize_text_field( $_POST['customer_name'] ?? '' );
        $email = sanitize_email( $_POST['customer_email'] ?? '' );
        $items = isset($_POST['order_items']) ? sanitize_textarea_field($_POST['order_items'] ?? '') :  '';
        $price = floatval( $_POST['total_price'] ?? 0 );
        $quantity = intval( $_POST['quantity'] ?? 1 );


        if ( empty( $name ) || empty( $email ) || empty( $items ) || $price <= 0 ||  $quantity < 1 )  {
            wp_send_json_error( 'Please fill all required fields.' );
        }

        $order_id = wp_insert_post([
            'post_type'   => 'kz_cafe_order',
            'post_title'  => $name,
            'post_status' => 'publish',
            'post_author' => get_current_user_id()
        ]);

        if ( ! $order_id ) {
            wp_send_json_error( 'Order could not be created.' );
        }

        update_post_meta( $order_id, '_kz_cafe_customer_name', $name );
        update_post_meta( $order_id, '_kz_cafe_customer_email', $email );
        update_post_meta( $order_id, '_kz_cafe_order_items', $items );
        update_post_meta( $order_id, '_kz_cafe_total_price', $price );
        update_post_meta( $order_id, '_kz_cafe_order_quantity', $quantity );

        // Logged-in user info
        update_post_meta( $order_id, '_kz_cafe_user_id', get_current_user_id() );
        update_post_meta( $order_id, '_kz_cafe_user_email', wp_get_current_user()->user_email );

        update_post_meta( $order_id, '_kz_cafe_order_status', 'pending' );

        wp_send_json_success( 'Your order has been placed successfully!' );
        
    }
}

 
