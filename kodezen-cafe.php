<?php
/*
 * Plugin Name:       Kodezen Cafe
 * Plugin URI:        https://kodezen.com/kodezen-cafe/
 * Description:       Kodezen Cafe is a stylish and lightweight WordPress plugin designed for cafe websites.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Kodezen Team
 * Author URI:        https://kodezen.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       kodezen-cafe
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH') ) {
    exit;
}

require_once  __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */

final class Kodezen_Cafe {

    /**
     * plugin version 
     */

    const version = '1.0.0';

    /**
     * The construct 
     */

    private function __construct() {

        $this->define_construct();

        register_activation_hook( __FILE__, [ $this, 'kz_activate' ] );

        add_action( 'plugins_loaded', [ $this, 'kz_cafe_init' ] );
    }

    /**
     * The instance 
     * 
     * @return \Kodezen_Cafe
     */

    public static function init() {

        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define construct
     */

    public function define_construct() {

        define( 'KZ_CAFE_VERSION', self::version );
        define( 'KZ_CAFE_FILE', __FILE__ );
        define( 'KZ_CAFE_PATH', __DIR__ );
        define( 'KZ_CAFE_URL', plugins_url( '', KZ_CAFE_FILE ) );
       
    }

    /**
     * plugin init
     * 
     * @return vioid
     */

    public function kz_cafe_init() {

            /**
            * Backend 
            */
            
            new \kodezen\cafe\Admin\kz_cafe_CPT();
            new \kodezen\cafe\Admin\kz_cafe_Taxonomy();
            new \kodezen\cafe\Admin\kz_cafe_MetaBox();
            new \kodezen\cafe\Admin\kz_cafe_Stock_MetaBox();
            new \kodezen\cafe\Admin\kz_cafe_Order_CPT();
            new \kodezen\cafe\Admin\kz_cafe_Order_Actions();
            new \kodezen\cafe\Admin\kz_cafe_Customer_Role();
                    
            /**
             * Frontend
             */

            new \kodezen\cafe\Frontend\kz_cafe_Shortcode();
            new \kodezen\cafe\Frontend\kz_cafe_Form_Shortcode();
            new \kodezen\cafe\Frontend\kz_cafe_Order_Form();            
            new \kodezen\cafe\Frontend\kz_cafe_Order_List();

    }
    
    /**
     * Install time and update version 
     * 
     * @return void
     */

    public function kz_activate() {

        $installed = get_option( 'kz_cafe_installed' );

        if ( ! $installed ) {
            update_option( 'kz_cafe_installed', time() );
        }
        update_option( 'kz_cafe_version', KZ_CAFE_VERSION );
    }    
}

/**
 * Initialize plugin 
 * 
 * @return \Kodezen_Cafe
 */

function Kodezen_Cafe() {
    return Kodezen_Cafe::init();
}

/**
 * Excess key 
 */
Kodezen_Cafe();

