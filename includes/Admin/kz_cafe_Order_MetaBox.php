<?php
namespace kodezen\cafe\Admin;

/**
 * Order Meta Box
 */

class kz_cafe_Order_MetaBox {

    function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add_order_metabox' ] );
        add_action( 'save_post', [ $this, 'save_order_metabox' ] );
    }

    /**
     * Register Order Meta Box
     */
    public function add_order_metabox() {
        add_meta_box(
            'kz_cafe_order_details',
            __( 'Order Details', 'kodezen-cafe' ),
            [ $this, 'render_order_metabox' ],
            'kz_cafe_order',
            'normal',
            'high'
        );
    }

    /**
     * Display fields
     */
    public function render_order_metabox( $post ) {
        wp_nonce_field( 'kz_cafe_save_order_meta', 'kz_cafe_order_nonce' );

        $customer_name  = get_post_meta( $post->ID, '_kz_cafe_customer_name', true );
        $customer_email = get_post_meta( $post->ID, '_kz_cafe_customer_email', true );
        $order_items    = get_post_meta( $post->ID, '_kz_cafe_order_items', true );
        $total_price    = get_post_meta( $post->ID, '_kz_cafe_price', true );
        $quantity       = get_post_meta( $post->ID, '_kz_cafe_order_quantity', true );
        $status         = get_post_meta( $post->ID, '_kz_cafe_order_status', true );
        $user_id        = get_post_meta( $post->ID, '_kz_cafe_user_id', true );
        $user_email     = get_post_meta( $post->ID, '_kz_cafe_user_email', true );

        ?>
        <table class="form-table">
            <tr>
                <th><label for="kz_cafe_customer_name"><?php _e( 'Customer Name', 'kodezen-cafe' ); ?></label></th>
                <td><input type="text" name="kz_cafe_customer_name" id="kz_cafe_customer_name" value="<?php echo esc_attr( $customer_name ); ?>" style="width:100%;" /></td>
            </tr>
            <tr>
                <th><label for="kz_cafe_customer_email"><?php _e( 'Customer Email', 'kodezen-cafe' ); ?></label></th>
                <td><input type="email" name="kz_cafe_customer_email" id="kz_cafe_customer_email" value="<?php echo esc_attr( $customer_email ); ?>" style="width:100%;" /></td>
            </tr>
            <tr>
                <th><label for="kz_cafe_order_items"><?php _e( 'Order Items', 'kodezen-cafe' ); ?></label></th>
                <td><textarea name="kz_cafe_order_items" id="kz_cafe_order_items" rows="4" style="width:100%;"><?php echo esc_textarea( $order_items ); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="_kz_cafe_price"><?php _e( 'Total Price ($)', 'kodezen-cafe' ); ?></label></th>
                <td><input type="number" name="_kz_cafe_price" id="_kz_cafe_price" value="<?php echo esc_attr( $total_price ); ?>" step="0.01" /></td>
            </tr>
            <tr>
                <th><label for="kz_cafe_order_quantity"><?php _e( 'Quantity', 'kodezen-cafe' ); ?></label></th>
                <td><input type="number" name="kz_cafe_order_quantity" id="kz_cafe_order_quantity" value="<?php echo esc_attr( $quantity ); ?>" step="1" min="1" /></td>
            </tr>

            <tr>
                <th><label for="kz_cafe_order_status"><?php _e( 'Order Status', 'kodezen-cafe' ); ?></label></th>
                <td>
                    <select name="kz_cafe_order_status" id="kz_cafe_order_status">
                        <option value="pending" <?php selected( $status, 'pending' ); ?>><?php _e( 'Pending', 'kodezen-cafe' ); ?></option>
                        <option value="approved" <?php selected( $status, 'approved' ); ?>><?php _e( 'Approved', 'kodezen-cafe' ); ?></option>
                        <option value="cancelled" <?php selected( $status, 'cancelled' ); ?>><?php _e( 'Cancelled', 'kodezen-cafe' ); ?></option>
                    </select>
                </td>
            </tr>
        </table>
        <?php

        if ( $user_id ) {
    echo '<p><strong>User ID:</strong> ' . esc_html( $user_id ) . '</p>';
    echo '<p><strong>User Email:</strong> ' . esc_html( $user_email ) . '</p>';
}
    }

    /**
     * Save Meta Box Data
     */
    public function save_order_metabox( $post_id ) {

        if ( ! isset( $_POST['kz_cafe_order_nonce'] ) || ! wp_verify_nonce( $_POST['kz_cafe_order_nonce'], 'kz_cafe_save_order_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        // Save fields
        if ( isset( $_POST['kz_cafe_customer_name'] ) ) {
            update_post_meta( $post_id, '_kz_cafe_customer_name', sanitize_text_field( $_POST['kz_cafe_customer_name'] ) );
        }

        if ( isset( $_POST['kz_cafe_customer_email'] ) ) {
            update_post_meta( $post_id, '_kz_cafe_customer_email', sanitize_email( $_POST['kz_cafe_customer_email'] ) );
        }

        if ( isset( $_POST['kz_cafe_order_items'] ) ) {
            update_post_meta( $post_id, '_kz_cafe_order_items', sanitize_textarea_field( $_POST['kz_cafe_order_items'] ) );
        }

        if ( isset( $_POST['_kz_cafe_price'] ) ) {
            update_post_meta( $post_id, '_kz_cafe_price', sanitize_text_field( $_POST['_kz_cafe_price'] ) );
        }

        if ( isset( $_POST['kz_cafe_order_quantity'] ) ) {
            update_post_meta( $post_id, '_kz_cafe_order_quantity', intval( $_POST['kz_cafe_order_quantity'] ) );
        }


        if ( isset( $_POST['kz_cafe_order_status'] ) ) {
            update_post_meta( $post_id, '_kz_cafe_order_status', sanitize_text_field( $_POST['kz_cafe_order_status'] ) );
        }
    }

}

