<?php
namespace kodezen\cafe\Admin;

/**
 * Meta Box Class 
 */

class kz_cafe_Stock_MetaBox {

    /**
     * Stock Metabox hook 
     */

    function __construct() {

        add_action( 'add_meta_boxes', [ $this, 'add_stock_metabox' ] );
        add_action( 'save_post', [ $this, 'save_stock_metabox' ] );

    }

    /**
     * Register meta box
     */

    public function add_stock_metabox() {

        add_meta_box(
            'kz_cafe_stock_box',
            __( 'Product Stock Info', 'kodezen-cafe' ),
            [ $this, 'render_stock_metabox' ],
            'kodezen_cafe',
            'side',
            'default'
        );
    }

    /**
     * Render meta box fields
     */

    public function render_stock_metabox( $post ) {

        $stock_value      = get_post_meta( $post->ID, '_kz_cafe_stock_value', true );

        wp_nonce_field( 'kz_cafe_stock_save', 'kz_cafe_stock_nonce' );

        ?>
        
        <p>
            <label for="kz_cafe_stock_value"><strong><?php _e( 'Current Stock', 'kodezen-cafe' ); ?></strong></label><br>
            <input type="number" name="kz_cafe_stock_value" id="kz_cafe_stock_value" 
            value="<?php echo esc_attr( $stock_value ); ?>" min="0" style="width:100%;">
        </p>       

        <?php
    }

    /**
     * Save meta box data
     */
    
    public function save_stock_metabox( $post_id ) {

        /**
         * Verify nonce
         */

        if ( ! isset( $_POST['kz_cafe_stock_nonce'] ) ||
             ! wp_verify_nonce( $_POST['kz_cafe_stock_nonce'], 'kz_cafe_stock_save' ) ) {
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

        $stock_value      = isset( $_POST['kz_cafe_stock_value'] ) ? intval( $_POST['kz_cafe_stock_value'] ) : 0;

        update_post_meta( $post_id, '_kz_cafe_stock_value', $stock_value );

    }
}
