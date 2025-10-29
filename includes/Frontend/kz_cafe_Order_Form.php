<?php
namespace kodezen\cafe\Frontend;

/**
 * Handle Order Form 
 */

class kz_cafe_Order_Form {

    /**
     * Register Hook  
     */

    function __construct() {

        /**
         * AJAX hooks
         */

        add_action( 'wp_ajax_kz_cafe_submit_order', [ $this, 'submit_order' ] );
        add_action( 'wp_ajax_nopriv_kz_cafe_submit_order', [ $this, 'submit_order' ] );

        /**
         * Enqueue
         */ 

        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Enqueue  AJAX order
     */

    public function enqueue_scripts() {

        wp_enqueue_script(
            'kz-cafe-order',
            plugin_dir_url(__DIR__) . 'Frontend/js/kz_cafe_Order.js',
            ['jquery'],
            filemtime(KZ_CAFE_PATH . '/includes/Frontend/js/kz_cafe_Order.js'),
            true
        );

        wp_localize_script( 'kz-cafe-order', 'kzCafeOrder', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'kz_cafe_order_nonce' ),
        ]);
    }

    /**
     * Handle AJAX 
     */

    public function submit_order() {

        /**
         * Verify nonce
         */

        check_ajax_referer( 'kz_cafe_order_nonce', 'nonce' );

        /**
         * Sanitize fields
         */

        $name       = sanitize_text_field($_POST['customer_name'] ?? '');
        $email      = sanitize_email($_POST['customer_email'] ?? '');
        $items      = sanitize_textarea_field($_POST['order_items'] ?? '');
        $price      = floatval($_POST['total_price'] ?? 0);
        $product_id = intval($_POST['product_id'] ?? 0);
        $quantity   = intval($_POST['quantity'] ?? 1);

        
        if ( empty( $name ) || empty( $email ) || empty( $items ) || $price <= 0 || $quantity < 1) {
            wp_send_json_error( 'Please fill all required fields.' );
        }

        /**
         * Stock check creating order
         */

        if ( $product_id > 0 ) {
            $current_stock = intval( get_post_meta( $product_id, '_kz_cafe_stock_value', true ) );

            if ( $current_stock <= 0 ) {
                wp_send_json_error( 'Sorry, this item is out of stock.' );
            }

            if ( $quantity > $current_stock ) {
                wp_send_json_error( 'Only ' . $current_stock . ' items available in stock.' );
            }
        }

        /**
         * Create order post
         */

        $order_id = wp_insert_post( [
            'post_type'   => 'kz_cafe_order',
            'post_title'  => $name,
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
        ] );

        if ( ! $order_id ) {
            wp_send_json_error( 'Order could not be created.' );
        }

        /**
         * Save order 
         */

        update_post_meta( $order_id, '_kz_cafe_customer_name', $name );
        update_post_meta( $order_id, '_kz_cafe_customer_email', $email );
        update_post_meta( $order_id, '_kz_cafe_order_items', $items );
        update_post_meta( $order_id, '_kz_cafe_total_price', $price );
        update_post_meta( $order_id, '_kz_cafe_order_quantity', $quantity );
        update_post_meta( $order_id, '_kz_cafe_order_status', 'pending' );

        /**
         * Logged-in user 
         */

        update_post_meta( $order_id, '_kz_cafe_user_id', get_current_user_id() );
        update_post_meta( $order_id, '_kz_cafe_user_email', wp_get_current_user()->user_email );

        /**
         * Update stock 
         */
        
        if ( $product_id > 0 ) {
            $new_stock = max(0, $current_stock - $quantity);
            update_post_meta( $product_id, '_kz_cafe_stock_value', $new_stock );
        }

            $product_id = intval($_POST[ 'product_id' ] ?? 0 );

        if ( $product_id > 0 ) {
            update_post_meta( $order_id, '_kz_cafe_product_id', $product_id );
        }

        wp_send_json_success( 'Your order has been placed successfully!' );
    }
}
