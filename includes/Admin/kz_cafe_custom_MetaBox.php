<?php
namespace kodezen\cafe\Admin;

/**
 * Meta Box Class
 */
class kz_cafe_custom_MetaBox {

    function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add_stock_metabox' ] );
        add_action( 'save_post', [ $this, 'save_stock_metabox' ] );
    }

    /**
     * Register meta box
     */
    
    public function add_stock_metabox() {
        add_meta_box(
            'kz_cafe_stock_details',
            __( 'Custom Fields', 'kodezen-cafe' ),
            [ $this, 'render_custom_metabox' ],
            'kodezen_cafe',
            'normal',
            'high'
        );
    }

    /**
     * Display field
     */

    public function render_custom_metabox( $post ) {

        /**
         * Nonce field for security
         */

        wp_nonce_field( 'kz_cafe__stock_save_meta', 'kz_cafe_stock_meta_nonce' );

        /**
         * Get existing values
         */

        $value = get_post_meta($post->ID, '_kz_cafe_stock_value', true);

        ?>
        <table class="form-table">
            
            <tr>
                <th><label for="kz_cafe_stock_value"><?php _e( 'value', 'kodezen-cafe' ); ?></label></th>
                <td><input type="number" name="kz_cafe_stock_value" id="kz_cafe_stock_value" value="<?php echo esc_attr( $value ); ?>" /></td>
            </tr>
        </table>
        <?php
    }

    /**
     * Save meta box data
     */

    public function save_stock_metabox( $post_id ) {

        /**
         * Verify nonce
         */

        if ( ! isset( $_POST['kz_cafe_stock_meta_nonce'] ) ||
             ! wp_verify_nonce( $_POST['kz_cafe_stock_meta_nonce'], 'kz_cafe__stock_save_meta' ) ) {
            return;
        }

        /**
         * Check
         */

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        /**
         * Save values
         */

        if ( isset( $_POST['kz_cafe_stock_value'] ) ) {
            update_post_meta($post_id, '_kz_cafe_stock_value', intval($_POST['kz_cafe_stock_value']));

        }
    }
}
