<?php
namespace kodezen\cafe\Frontend;

class kz_cafe_Form_Shortcode {

    function __construct() {
        add_shortcode( 'kodezen-cafe-order', [ $this, 'render_order_form' ] );
    }
    
    /**
     * Render Order Form
     */
    public function render_order_form() {
    ob_start();

   
        

   // Login check

    $current_user = wp_get_current_user();
    if ( ! is_user_logged_in() ) {
        wp_redirect( wp_login_url( get_permalink() ) );
        
    }

    // Auto-fill menu item title
    $order_item_title = '';
    if ( isset($_GET['item_id']) ) {
        $post_id = intval($_GET['item_id']);
        $order_item_title = get_the_title($post_id);
    }

    $total_price = '';
if ( isset($_GET['item_id']) ) {
    $post_id = floatval($_GET['item_id']);
    $total_price = get_post_meta($post_id, '_kz_cafe_price', true);
}

    ?>
    <form id="kz-cafe-order-form" class="kz_cafe_css">
        <p><label>Name: 
            <input type="text" name="customer_name" value="<?php echo esc_attr( $current_user->display_name ); ?>" required>
        </label></p>

        <p><label>Email: 
            <input type="email" name="customer_email" value="<?php echo esc_attr( $current_user->user_email ); ?>" required>
        </label></p>

        <p><label>Order Items:
            <input name="order_items" value="<?php echo esc_attr( $order_item_title ); ?>" required>
        </label></p>

        <p><label>Total Price ($): 
            <input type="number" name="total_price" value="<?php echo esc_attr( $total_price ); ?>" required>
        </label></p>

        <p><label>Quantity: 
            <input type="number" name="quantity" step="1" min="1" required>
        </label></p>

        <input type="hidden" name="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>">
        
        <button id="kz_cafe_submit_order" type="submit">CHECKOUT</button>
        <div id="kz-order-response"></div>
    </form>

    <p style="margin-top:10px;">
        <a href="<?php echo wp_logout_url( site_url() ); ?>">Log Out</a>
    </p>
    <?php
    return ob_get_clean();
}

}


