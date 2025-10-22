<?php
namespace kodezen\cafe\Admin;

/**
 * Order CPT class
 */
class kz_cafe_Order {

    function __construct() {
        add_action( 'init', [ $this, 'register_order_cpt' ] );
    }

    /**
     * Order CPT register
     */

    public function register_order_cpt() {

        $labels = [
            'name'               => __( 'Orders', 'kodezen-cafe' ),
            'singular_name'      => __( 'Order', 'kodezen-cafe' ),
            'add_new'            => __( 'Add New', 'kodezen-cafe' ),
            'add_new_item'       => __( 'Add New Order', 'kodezen-cafe' ),
            'edit_item'          => __( 'Edit Order', 'kodezen-cafe' ),
            'new_item'           => __( 'New Order', 'kodezen-cafe' ),
            'view_item'          => __( 'View Order', 'kodezen-cafe' ),
            'search_items'       => __( 'Search Orders', 'kodezen-cafe' ),
            'not_found'          => __( 'No orders found', 'kodezen-cafe' ),
            'not_found_in_trash' => __( 'No orders found in Trash', 'kodezen-cafe' ),
            'menu_name'          => __( 'Cafe Orders', 'kodezen-cafe' ),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => false,            
            'show_ui'            => true,             
            'show_in_menu'       => 'edit.php?post_type=kodezen_cafe',
            'capability_type'    => 'post',
            'capabilities'       => [
               'create_posts'    => 'do_not_allow',
            ],
            'map_meta_cap'       => true,
            'has_archive'        => false,           
            'supports'           => [ 'title', 'editor' ], 
        ];

        register_post_type( 'kz_cafe_order', $args );
    }
}
