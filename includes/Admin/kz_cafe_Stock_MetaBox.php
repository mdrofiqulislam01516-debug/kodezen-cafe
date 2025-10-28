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
            'kz_cafe_stock_metabox',
            __( 'Product Stock', 'kodezen-cafe' ),
            [ $this, 'render_stock_metabox' ],
            'kodezen_cafe', 
            'side',
            'default'
        );
    }

    /**
     * Display field
     */

    public function render_stock_metabox( $post ) {

        /**
         * Nonce field for security
         */

        wp_nonce_field( 'kz_cafe_save_stock', 'kz_cafe_stock_nonce' );

        /**
         * Get existing values
         */

        $stock = get_post_meta( $post->ID, '_kz_cafe_stock_value', true );

        ?>

        <label for="kz_cafe_stock_value"><?php _e('Stock Quantity:', 'kodezen-cafe'); ?></label>
        <input type="number" name="kz_cafe_stock_value" id="kz_cafe_stock_value" value="<?php echo esc_attr($stock); ?>" min="0" style="width:100%;">
        
        <?php
    }

    /**
     * Save meta box data
     */

    public function save_stock_metabox( $post_id ) {

        /**
         * Verify nonce
         */

        if ( ! isset( $_POST[ 'kz_cafe_stock_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'kz_cafe_stock_nonce' ], 'kz_cafe_save_stock' ) ) {
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

        if ( isset( $_POST[ 'kz_cafe_stock_value' ] ) ) {
            update_post_meta( $post_id, '_kz_cafe_stock_value', intval( $_POST['kz_cafe_stock_value' ] ) );

        }
    }
}

