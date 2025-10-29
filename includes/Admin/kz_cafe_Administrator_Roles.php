<?php
namespace kodezen\cafe\Admin;

/**
 * Administrator Role class 
 */

class kz_cafe_Administrator_Roles {

    /**
     * Register Hook
     */

    function __construct() {

        add_action( 'init', [ $this, 'kz_cafe_role_add' ] );

    }

    /**
     * Register Role 
     */

    public function kz_cafe_role_add() {

        add_role(
            'kz_cafe_administrator',              
            'Kz Cafe Administrator',              
            array(
                'activate_plugins'          => true,
                'delete_others_pages'       => true,
                'delete_others_posts'       => true,
                'delete_pages'              => true,
                'delete_posts'              => true,
                'delete_private_pages'      => true,
                'delete_private_posts'      => true,
                'delete_published_pages'    => true,
                'delete_published_posts'    => true,
                'edit_dashboard'            => true,
                'edit_others_pages'         => true,
                'edit_others_posts'         => true,
                'edit_pages'                => true,
                'edit_posts'                => true,
                'edit_private_pages'        => true,
                'edit_private_posts'        => true,
                'edit_published_pages'      => true,
                'edit_published_posts'      => true,
                'edit_theme_options'        => true,
                'export'                    => true,
                'import'                    => true,
                'list_users'                => true,
                'manage_categories'         => true,
                'manage_links'              => true,
                'manage_options'            => true,
                'moderate_comments'         => true,
                'promote_users'             => true,
                'publish_pages'             => true,
                'publish_posts'             => true,
                'read_private_pages'        => true,
                'read_private_posts'        => true,
                'read'                      => true,
                'remove_users'              => true,
                'switch_themes'             => true,
                'upload_files'              => true,
                'customize'                 => true,
                'delete_site'               => true,
            )
        );
    }
}
