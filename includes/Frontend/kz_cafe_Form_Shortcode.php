<?php
namespace kodezen\cafe\Frontend;

class kz_cafe_Form_Shortcode {

    function __construct() {
         add_shortcode('kodezen-cafe-order', [$this, 'render_order_form']);
    }
    
    /**
     * Render Order Form
     */
    public function render_order_form() {
        ob_start();

        $current_user = wp_get_current_user();
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url(get_permalink()));
            exit;
        }

        $order_item_title = '';
        if (isset($_GET['item_id'])) {
            $post_id = intval($_GET['item_id']);
            $order_item_title = get_the_title($post_id);
        }
        ?>
        <form id="kz-cafe-order-form" class="kz_cafe_css">
            <?php wp_nonce_field('kz_cafe_order_nonce', 'kz_cafe_order_nonce'); ?>

            <p><label>Name:
                <input type="text" name="customer_name" id="kz-cafe-customer-name" value="<?php echo esc_attr($current_user->display_name); ?>" required>
            </label></p>

            <p><label>Email:
                <input type="email" name="customer_email" id="kz-cafe-customer-email" value="<?php echo esc_attr($current_user->user_email); ?>" required>
            </label></p>

            <p><label>Order Items:
                <textarea name="order_items" id="kz-cafe-order-items" required><?php echo esc_textarea($order_item_title); ?></textarea>
            </label></p>

            <p><label>Total Price ($):
                <input type="number" name="total_price" id="kz-cafe-total-price" step="0.01" required>
            </label></p>

            <p><label>Quantity:
                <input type="number" name="quantity" id="kz-cafe-order-quantity" step="1" min="1" required>
            </label></p>

            <input type="hidden" name="user_id" value="<?php echo esc_attr($current_user->ID); ?>">
            <button type="submit">ORDER NOW</button>
            <div id="kz-order-response"></div>
        </form>
        <p style="margin-top:10px;">
            <a href="<?php echo wp_logout_url(site_url()); ?>">Log Out</a>
        </p>
        <?php
        return ob_get_clean();
    }

}


