<?php
namespace Kodezen\Cafe\Frontend;

class KZ_Cafe_Order_Form {

    public function __construct() {

        // Handle AJAX requests (logged in + guest)
        add_action('wp_ajax_kz_cafe_submit_order', [$this, 'submit_order']);
        add_action('wp_ajax_nopriv_kz_cafe_submit_order', [$this, 'submit_order']);

        // Enqueue JS
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Enqueue front-end script
     */
    public function enqueue_scripts() {
        $script_path = KZ_CAFE_PATH . '/includes/Frontend/js/kz_cafe_Order.js';
        wp_enqueue_script(
            'kz-cafe-order',
            plugin_dir_url(__DIR__) . 'Frontend/js/kz_cafe_Order.js',
            ['jquery'],
            filemtime($script_path),
            true
        );

        wp_localize_script('kz-cafe-order', 'kzCafeOrder', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('kz_cafe_order_nonce'),
        ]);
    }

    /**
     * Handle AJAX order submission
     */
    public function submit_order() {
        check_ajax_referer('kz_cafe_order_nonce', 'nonce');

        $name     = sanitize_text_field($_POST['customer_name'] ?? '');
        $email    = sanitize_email($_POST['customer_email'] ?? '');
        $items    = sanitize_textarea_field($_POST['order_items'] ?? '');
        $price    = floatval($_POST['total_price'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);

        // Validate input
        if (empty($name) || empty($email) || empty($items) || $price <= 0 || $quantity < 1) {
            wp_send_json_error(['message' => 'Please fill in all required fields.']);
        }

        // Create order post
        $order_id = wp_insert_post([
            'post_type'   => 'kz_cafe_order',
            'post_title'  => sprintf('%s - %s', $name, current_time('Y-m-d H:i:s')),
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
        ]);

        if (!$order_id) {
            wp_send_json_error(['message' => 'Order could not be created.']);
        }

        // Save meta data
        update_post_meta($order_id, '_kz_cafe_customer_name', $name);
        update_post_meta($order_id, '_kz_cafe_customer_email', $email);
        update_post_meta($order_id, '_kz_cafe_order_items', $items);
        update_post_meta($order_id, '_kz_cafe_total_price', $price);
        update_post_meta($order_id, '_kz_cafe_quantity', $quantity);
        update_post_meta($order_id, '_kz_cafe_order_status', 'pending');
        update_post_meta($order_id, '_kz_cafe_created_at', current_time('mysql'));

        // Optionally, add logged-in user info
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            update_post_meta($order_id, '_kz_cafe_user_id', $user->ID);
            update_post_meta($order_id, '_kz_cafe_user_email', $user->user_email);
        }

        wp_send_json_success([
            'message' => 'Your order has been placed successfully!',
            'order_id' => $order_id,
        ]);

        wp_die();
    }
}
