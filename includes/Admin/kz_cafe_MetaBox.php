<?php
namespace kodezen\cafe\Admin;

/**
 * Meta Box Class
 */

class kz_cafe_MetaBox {

    /**
     * register hook
     */

    function __construct() {

        add_action( 'add_meta_boxes', [ $this, 'kz_cafe_add_metabox' ] );
        add_action( 'save_post', [ $this, 'kz_cafe_save_metabox' ] );

    }

    /**
     * Register meta box
     */

    public function kz_cafe_add_metabox() {
        
        add_meta_box(
            'kz_cafe_menu_details',
            __( 'Menu Item Details', 'kodezen-cafe' ),
            [ $this, 'render_metabox' ],
            'kodezen_cafe',
            'side',
            'default'
        );
    }

    /**
     * Display field
     */

    public function render_metabox( $post ) {

        /**
         * Nonce
         */ 

        wp_nonce_field( 'kz_cafe_save_meta', 'kz_cafe_meta_nonce' );

        $price       = get_post_meta( $post->ID, '_kz_cafe_price', true );
        $ingredients = get_post_meta( $post->ID, '_kz_cafe_ingredients', true );
        $available   = get_post_meta( $post->ID, '_kz_cafe_available', true );

        ?>

        <table class="form-table">
            <tr>
                <th><label for="kz_cafe_price"><?php _e( 'Price ($)', 'kodezen-cafe' ); ?></label></th>
                <td><input type="number" name="kz_cafe_price" id="kz_cafe_price" value="<?php echo esc_attr( $price ); ?>" step="0.01" /></td>
            </tr>
            <tr>
                <th><label for="kz_cafe_ingredients"><?php _e( 'Ingredients', 'kodezen-cafe' ); ?></label></th>
                <td><textarea name="kz_cafe_ingredients" id="kz_cafe_ingredients" rows="3"><?php echo esc_textarea( $ingredients ); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="kz_cafe_available"><?php _e( 'Available', 'kodezen-cafe' ); ?></label></th>
                <td>
                    <select name="kz_cafe_available" id="kz_cafe_available">
                        <option value="yes" <?php selected( $available, 'yes' ); ?>><?php _e( 'Yes', 'kodezen-cafe' ); ?></option>
                        <option value="no"  <?php selected( $available, 'no' ); ?>><?php _e( 'No', 'kodezen-cafe' ); ?></option>
                    </select>
                </td>
            </tr>
        </table>

        <?php
    }

    /**
     * Save meta box data
     */

    public function kz_cafe_save_metabox( $post_id ) {

        /**
         * Verify nonce
         */

        if ( ! isset( $_POST[ 'kz_cafe_meta_nonce' ] ) ||
             ! wp_verify_nonce( $_POST[ 'kz_cafe_meta_nonce' ], 'kz_cafe_save_meta' ) ) {
            return;
        }

        /**
         * Check
         */ 

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        /**
         * save values 
         */
        
        if ( isset( $_POST[ 'kz_cafe_price' ] ) ) {
            update_post_meta( $post_id, '_kz_cafe_price', sanitize_text_field( $_POST[ 'kz_cafe_price' ] ) );
        }

        if ( isset( $_POST[ 'kz_cafe_ingredients' ] ) ) {
            update_post_meta( $post_id, '_kz_cafe_ingredients', sanitize_textarea_field( $_POST[ 'kz_cafe_ingredients' ] ) );
        }

        if ( isset( $_POST[ 'kz_cafe_available' ] ) ) {
            update_post_meta( $post_id, '_kz_cafe_available', sanitize_text_field( $_POST[ 'kz_cafe_available' ] ) );
        }
    }
}
