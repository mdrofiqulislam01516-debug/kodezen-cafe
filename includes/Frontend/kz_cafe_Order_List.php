<?php
namespace kodezen\cafe\Frontend;

/**
 * Order   list Show Class
 */

class kz_cafe_Order_List {

    /**
     * Shortcode register hook 
     */

    function __construct() {

        add_shortcode( 'kodezen-cafe-order-list', [ $this, 'render_order_list' ] );

    }

    /**
     * Render user's orders
     */

    public function render_order_list( $atts ) {

        if ( ! is_user_logged_in() ) {
            return '<p>Please login to view your orders.</p>';
        }

        $current_user   = wp_get_current_user();
        $email          = $current_user->user_email;
        $args           = [
                            'post_type'      => 'kz_cafe_order',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish',
                            'meta_query'     => [
                                [
                                    'key'   => '_kz_cafe_customer_email',
                                    'value' => $email,
                                ]
                            ]
                        ];

        $query = new \WP_Query( $args );

        ob_start();

        if ( $query->have_posts() ) {

            echo '<table style="width:100%;border-collapse:collapse;">';

            echo '<tr style="background:#f7f7f7;">
            
                <th>Order</th>
                <th>Items</th>
                <th>Quantity</th>
                <th>Total Price ($)</th>
                <th>Status</th>

            </tr>';

            while ( $query->have_posts() ) {

                $query->the_post();

                $items      = get_post_meta( get_the_ID(), '_kz_cafe_order_items', true );
                $quantity   = get_post_meta( get_the_ID(), '_kz_cafe_order_quantity', true );
                $price      = get_post_meta( get_the_ID(), '_kz_cafe_total_price', true );
                $status     = get_post_meta( get_the_ID(), '_kz_cafe_order_status', true );

                echo '<tr style="border-bottom:1px solid #ddd;">';

                echo '<td>' . get_the_title() . '</td>';
                echo '<td>' . esc_html( $items ) . '</td>';
                echo '<td>' . esc_html( $quantity ) . '</td>';
                echo '<td>' . esc_html( $price ) . '</td>';
                echo '<td>' . ucfirst( esc_html( $status ) ) . '</td>';
                echo '</tr>';
            }

            echo '</table>';
            
            wp_reset_postdata();

        } else {
            echo '<p>No orders found.</p>';
        }

        return ob_get_clean();
    }
}


