<?php
namespace Kodezen\Cafe\Frontend;

class KZ_Cafe_Order_Form {

    public function __construct() {

         // AJAX actions
        add_action('wp_ajax_kz_cafe_submit_order', [$this, 'handle_order_submission']);
        add_action('wp_ajax_nopriv_kz_cafe_submit_order', [$this, 'handle_order_submission']);

        // Enqueue JS
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Enqueue front-end script
     */
    public function enqueue_scripts() {
        wp_enqueue_script('kz-cafe-frontend',plugins_url('js/kz_cafe_Order.js', __FILE__ ), ['jquery'], false, true);

        wp_localize_script('kz-cafe-frontend', 'kzCafeOrder', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('kz_cafe_order_nonce')
        ]);
    }

    /**
     * Handle AJAX order submission
     */
     public function handle_order_submission() {
        check_ajax_referer('kz_cafe_order_nonce', 'nonce');

        $name  = sanitize_text_field($_POST['customer_name']);
        $email = sanitize_email($_POST['customer_email']);
        $items = sanitize_textarea_field($_POST['order_items']);
        $price = floatval($_POST['total_price']);
        $qty   = intval($_POST['quantity']);
        $user_id = intval($_POST['user_id']);

        // Create a custom post type 'kz_cafe_order' (make sure it's registered)
        $post_id = wp_insert_post([
            'post_title'  => $name,
            'post_type'   => 'kz_cafe_order',
            'post_status' => 'publish',
        ]);

        if ($post_id) {
            update_post_meta($post_id, 'customer_name', $name);
            update_post_meta($post_id, 'customer_email', $email);
            update_post_meta($post_id, 'order_items', $items);
            update_post_meta($post_id, 'total_price', $price);
            update_post_meta($post_id, 'quantity', $qty);
            update_post_meta($post_id, 'user_id', $user_id);

            wp_send_json_success('Order submitted successfully!');
        } else {
            wp_send_json_error('Failed to submit order.');
        }
    }
}

