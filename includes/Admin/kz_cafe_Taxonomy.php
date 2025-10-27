<?php
namespace kodezen\cafe\Admin;

/**
* Taxonomy class
*/
class kz_cafe_Taxonomy {

    /**
    * Register Taxonomy Hook 
    */

    function __construct() {
        add_action( 'init', [ $this, 'kz_cafe_register_taxonomy' ] );
    }

    /**
    * Taxonomy register
    */

    public function kz_cafe_register_taxonomy() {

        $kz_cafe_labels = [
            'name'              => __( 'Menu Categories', 'kodezen-cafe' ),
            'singular_name'     => __( 'Menu Category', 'kodezen-cafe' ),
            'search_items'      => __( 'Search Menu Categories', 'kodezen-cafe' ),
            'all_items'         => __( 'All Menu Categories', 'kodezen-cafe' ),
            'parent_item'       => __( 'Parent Category', 'kodezen-cafe' ),
            'parent_item_colon' => __( 'Parent Category:', 'kodezen-cafe' ),
            'edit_item'         => __( 'Edit Category', 'kodezen-cafe' ),
            'update_item'       => __( 'Update Category', 'kodezen-cafe' ),
            'add_new_item'      => __( 'Add New Category', 'kodezen-cafe' ),
            'new_item_name'     => __( 'New Category Name', 'kodezen-cafe' ),
            'menu_name'         => __( 'Categories', 'kodezen-cafe' ),
        ];

        $args = [
            'hierarchical'      => true,  
            'labels'            => $kz_cafe_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'menu-category' ],
        ];

        register_taxonomy( 'kz_cafe_category', [ 'kodezen_cafe' ], $args );
    }
}
