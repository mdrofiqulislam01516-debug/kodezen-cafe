<?php
namespace kodezen\cafe\Admin;

class kz_cafe{

    /**
     * Main CPT class
     */

    public function __construct() {
   
        add_action( 'init', [ $this, 'kz_cafe_register' ] );
       add_action( 'admin_head', [ $this, 'hide_add_new_button' ] );
    }

    /**
     * CPT register
     */

    public function kz_cafe_register() {

            
    $kz_cafe_labels = [
            'name'                  => __( 'Kodezen Cafe', 'kodezen-cafe' ),
            'singular_name'         => __( 'Kodezen Cafes', 'kodezen-cafe' ),
            'menu_name'             => __( 'Kodezen Cafe', 'kodezen-cafe' ),
            'name_admin_bar'        => __( 'Kodezen Cafe', 'kodezen-cafe' ),
            'add_new'               => __( 'Add New', 'kodezen-cafe' ),
            'add_new_item'          => __( 'Add New Menu Item', 'kodezen-cafe' ),
            'edit_item'             => __( 'Edit Menu Item', 'kodezen-cafe' ),
            'new_item'              => __( 'New Menu Item', 'kodezen-cafe' ),
            'view_item'             => __( 'View Menu Item', 'kodezen-cafe' ),
            'search_items'          => __( 'Search Menu Items', 'kodezen-cafe' ),
            'not_found'             => __( 'No menu items found', 'kodezen-cafe' ),
            'not_found_in_trash'    => __( 'No menu items found in Trash', 'kodezen-cafe' ),
            'all_items'             => __( 'All Menu Items', 'kodezen-cafe' ),
            'archives'              => __( 'Menu Item Archives', 'kodezen-cafe' ),
            'insert_into_item'      => __( 'Insert into Menu Item', 'kodezen-cafe' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Menu Item', 'kodezen-cafe' ),
            'featured_image'        => __( 'Featured Image', 'kodezen-cafe' ),
            'set_featured_image'    => __( 'Set featured image', 'kodezen-cafe' ),
            'remove_featured_image' => __( 'Remove featured image', 'kodezen-cafe' ),
            'use_featured_image'    => __( 'Use as featured image', 'kodezen-cafe' ),
            'parent_item_colon'     => __( 'Parent Menu Item:', 'kodezen-cafe' ),
            'filter_items_list'     => __( 'Filter Menu Items list', 'kodezen-cafe' ),
            'items_list_navigation' => __( 'Menu Items list navigation', 'kodezen-cafe' ),
            'items_list'            => __( 'Menu Items list', 'kodezen-cafe' ),
        ];

        $args = [
            'labels'             => $kz_cafe_labels,
            'public'             => true,               
            'show_in_menu'       => true,
            'taxonomies'         => ['kz_cafe_category'],               
            'capability_type'    => 'post',
            'capabilities'       => [
               
            ],
            'map_meta_cap'       => true,                   
            'has_archive'        => true,               
            'rewrite'            => [ 'slug' => 'kodezen-cafe' ], 
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-coffee', 
            'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        ];

        register_post_type( 'kodezen_cafe', $args );
    }

    /**
     * Add_menu Button Hide
     */

    public function hide_add_new_button() {
        $screen = get_current_screen();
        
        if ( $screen && $screen->post_type === 'kodezen_cafe' && $screen->base === 'edit' ) {
            echo '<style>.page-title-action { display: none !important; }</style>';
        }
    }

    // public function enqueue_assets() {
    //     wp_enqueue_style( 'kz-cafe-admin-style' );
    // }
}


