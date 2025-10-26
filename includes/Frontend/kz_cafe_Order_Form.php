<?php
namespace kodezen\cafe\Frontend;

class KZ_Cafe_Order_Form {

    function __construct() {
        add_shortcode('kodezen-cafe-order', [$this, 'render_order_form']); 

        add_action('admin_post_kz_cafe_submit_order', [$this, 'handle_order_submission']);
      
    }

    /** * Render Order Form */ 
    public function render_order_form() {
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url(get_permalink()));
            exit;
        }

        $current_user = wp_get_current_user();

        $item_id = isset($_GET['item_id']) ? intval($_GET['item_id']) : '';

        // var_dump($order_item_title);
        // exit;          

        ob_start(); ?>

        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">

            <input type="hidden" name="action" value="kz_cafe_submit_order">
            <?php wp_nonce_field('kz_cafe_order_nonce'); ?>


            <p><label>Name: <input type="text" name="customer_name" value="<?php echo esc_attr($current_user->display_name); ?>" required></label></p> 
            <p><label>Email: <input type="email" name="customer_email" value="<?php echo esc_attr($current_user->user_email); ?>" required></label></p> 
            <p><label>Order Items: <input name="order_items" required><?php echo esc_textarea($item_id); ?></label></p>
            <p><label>Quantity: <input type="number" name="quantity" min="1" step="1" required></label></p>
            
            

            <input type="hidden" name="user_id" value="<?php echo esc_attr($current_user->ID); ?>">
            
            <button type="submit">ORDER NOW</button>
        </form>
        <?php
        return ob_get_clean();
    }

    public function handle_order_submission() {

        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'kz_cafe_order_nonce')) {
            wp_die('Security check failed!');
        }

        $user_id  = intval($_POST['user_id']);
        $name     = sanitize_text_field($_POST['customer_name']);
        $email    = sanitize_email($_POST['customer_email']);
        $item_id    = sanitize_textarea_field($_POST['order_items']);
        $qty      = intval($_POST['quantity']);
        $price    = floatval($_POST['_kz_cafe_price']);

    
        

        $post_id = wp_insert_post([
            'post_title'  => $name . ' - ' . current_time('Y-m-d H:i:s'),
            'post_type'   => 'kz_cafe_order',
            'post_status' => 'publish',
            'post_author' => $user_id,
        ]);

        if ($post_id) {
            update_post_meta($post_id, '_kz_cafe_customer_name', $name);
            update_post_meta($post_id, '_kz_cafe_customer_email', $email);
            update_post_meta($post_id, '_kz_cafe_order_items', $item_id);
            update_post_meta($post_id, '_kz_cafe_order_quantity', $qty);
            update_post_meta($post_id, '_kz_cafe_price', $price);
            update_post_meta($post_id, '_kz_cafe_order_status', 'pending');
            update_post_meta($post_id, '_kz_cafe_user_id', $user_id);

            wp_redirect( admin_url( 'admin.php?page=my-success-page' ) );
            exit;
        }
    }
}