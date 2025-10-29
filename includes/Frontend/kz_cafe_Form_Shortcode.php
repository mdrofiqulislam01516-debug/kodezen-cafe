<?php
namespace kodezen\cafe\Frontend;

/**
 * From Shortcode Class 
 */

class kz_cafe_Form_Shortcode {

    /**
     * Register Hook 
     */

    function __construct() {

        add_shortcode( 'kodezen_cafe_order', [ $this, 'render_kz_cafe_order_form' ] );

    }

    /**
     * Render Order Form
     */

    public function render_kz_cafe_order_form() {

        ob_start();

        /**
         * Login check
         */

        if ( ! is_user_logged_in() ) {
            wp_redirect( wp_login_url(get_permalink() ) );
            exit;
        }

        $current_user = wp_get_current_user();

        /**
         * Auto-fill
         */ 

        $order_item_title   = '';
        $total_price        = '';
        $stock_value        = '';

        if ( isset( $_GET[ 'item_id' ] ) ) {

            $post_id            = intval( $_GET[ 'item_id' ] );
            $order_item_title   = get_the_title( $post_id );
            $total_price        = get_post_meta( $post_id, '_kz_cafe_price', true );
            $stock_value        = intval( get_post_meta( $post_id, '_kz_cafe_stock_value', true ) );
        }

        ?>

        <form id="kz-cafe-order-form" class="kz_cafe_css">

            <p><label>Name:
                <input type="text" name="customer_name" value="<?php echo esc_attr( $current_user->display_name ); ?>" required>
            </label></p>

            <p><label>Email:
                <input type="email" name="customer_email" value="<?php echo esc_attr( $current_user->user_email ); ?>" required>
            </label></p>

            <p><label>Order Item:
                <input name="order_items" value="<?php echo esc_attr( $order_item_title ); ?>" required readonly>
            </label></p>

            <p><label>Total Price ($):
                <input type="number" name="total_price" value="<?php echo esc_attr( $total_price ); ?>" required readonly>
            </label></p>

            <?php if ( $stock_value <= 0 && isset( $_GET[ 'item_id' ] ) ) : ?>
                <p style="color:red;font-weight:bold;">Out of Stock</p>
            <?php else : ?>
                 
                <p><label>Quantity:
                    <input type="number" name="quantity" step="1" min="1" max="<?php echo esc_attr( $stock_value ); ?>" required>
                </label></p>

                <input type="hidden" name="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>">
                <input type="hidden" name="product_id" value="<?php echo isset( $post_id ) ? esc_attr( $post_id ) : ''; ?>">

                <button id="kz_cafe_submit_order" type="submit">CHECKOUT</button>
                <div id="kz-order-response"></div>
            <?php endif; ?>
        </form>

        <p style="margin-top:10px;">
            <a href="<?php echo wp_logout_url(site_url()); ?>">Log Out</a>
        </p>

        <?php
        return ob_get_clean();
    }
}
