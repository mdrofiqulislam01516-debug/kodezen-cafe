<?php
namespace kodezen\cafe\Admin;

/**
 * Order Action class
 */

class kz_cafe_Order_Actions {

    /**
    * Add custom column
    */

    function __construct() {

        add_filter( 'manage_kz_cafe_order_posts_columns', [ $this, 'kz_cafe_add_order_columns' ] );
        add_action( 'manage_kz_cafe_order_posts_custom_column', [ $this, 'render_kz_cafe_order_columns' ], 10, 2 );

        /**
         * Handle approve/cancel action
         */

        add_action( 'admin_init', [ $this, 'handle_kz_cafe_order_actions' ] );
        
    }

    /**
     * Add custom column for Status Actions
     */

    public function kz_cafe_add_order_columns( $columns ) {

        $columns[ 'product' ]      = __( 'Product', 'kodezen-cafe' );
        $columns[ 'quantity' ]     = __( 'Quantity', 'kodezen-cafe' );
        $columns[ 'order_items' ]  = __( 'Order Items', 'kodezen-cafe' );
        $columns[ 'total_price' ]  = __( 'Total Price ($)', 'kodezen-cafe' );
        $columns[ 'order_status' ] = __( 'Status / Action', 'kodezen-cafe' );

        return $columns;
    }

    /**
     * Render custom column content
     */

    public function render_kz_cafe_order_columns( $column, $post_id ) {

        if ( 'product' === $column ) {
            $product_id = get_post_meta( $post_id, '_kz_cafe_product_id', true );

            if ( $product_id ) {
                echo esc_html( get_the_title($product_id) ) . ' (ID: ' . intval($product_id) . ')';
            } else {
                echo '<em>No Product</em>';
            }
        }

        if ( 'quantity' === $column ) {
            $quantity = get_post_meta( $post_id, '_kz_cafe_order_quantity', true );
            echo intval( $quantity );
        }

        if ( 'order_items' === $column ) {
            $order_items = get_post_meta( $post_id, '_kz_cafe_order_items', true );
            echo ( $order_items );
        }

        if ( 'total_price' === $column ) {
            $total_price = get_post_meta( $post_id, '_kz_cafe_total_price', true );
            echo number_format( floatval( $total_price ), 2 );
        }

        if ( 'order_status' === $column ) {
            $status = get_post_meta( $post_id, '_kz_cafe_order_status', true );

            echo '<strong>' . ucfirst( $status ) . '</strong><br>';

            if ( $status === 'pending' ) {
                $approve_url = wp_nonce_url( admin_url( 'edit.php?post_type=kz_cafe_order&kz_action=approve&order_id=' . $post_id ), 'kz_cafe_order_action' );
                $cancel_url  = wp_nonce_url( admin_url( 'edit.php?post_type=kz_cafe_order&kz_action=cancel&order_id=' . $post_id ), 'kz_cafe_order_action' );

                echo '<a href="' . esc_url( $approve_url ) . '" class="button button-primary button-small">Approve</a> ';
                echo '<a href="' . esc_url( $cancel_url ) . '" class="button button-secondary button-small">Cancel</a>';
            }
        }
    }

    /**
     * Handle Approve/Cancel actions
    */


    public function handle_kz_cafe_order_actions() {

        if ( ! isset( $_GET[ 'kz_action' ], $_GET['order_id'] ) ) return;

        if ( ! current_user_can( 'edit_posts' ) ) return;

        if ( ! wp_verify_nonce( $_GET[ '_wpnonce' ], 'kz_cafe_order_action' ) ) return;

            $order_id = intval( $_GET[ 'order_id' ] );            
            $product_id = get_post_meta( $order_id, '_kz_cafe_product_id', true ); 
            $quantity = intval( get_post_meta( $order_id, '_kz_cafe_order_quantity', true ) );
            $current_stock = intval( get_post_meta( $product_id, '_kz_cafe_stock_value', true ) );

        /**
         * Approve order 
         */  

        if ( $_GET['kz_action'] === 'approve' ) {

                update_post_meta( $order_id, '_kz_cafe_order_status', 'approved' );
                
        }

        /**
         *  Cancel order 
         */

        if ( $_GET['kz_action'] === 'cancel' ) {
            update_post_meta( $order_id, '_kz_cafe_order_status', 'cancelled' );

            $new_stock = $current_stock + $quantity;
            update_post_meta( $product_id, '_kz_cafe_stock_value', $new_stock );
        }

        wp_redirect( remove_query_arg( [ 'kz_action', 'order_id', '_wpnonce' ] ) );
        exit;

    }
}



