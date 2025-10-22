<?php
// namespace kodezen\cafe;

// class kz_cafe_Assets {
//     function __construct() {
//         add_action( 'wp_enqueue_scripts', [ $this, 'kz_cafe_enqueue' ] );

//         add_action( 'admin_enqueue_scripts', [ $this, 'kz_cafe_enqueue' ] );

        
//          add_action( 'wp_ajax_kz_cafe_submit_order', [ $this, 'submit_order' ] );
//         add_action( 'wp_ajax_nopriv_kz_cafe_submit_order', [ $this, 'submit_order' ] );

//         // Enqueue JS
//         add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );        
//     }

//      public function get_scripts() {
//         return [
//             'kz-cafe-order-script' => [
//                 'src'     => KZ_CAFE_ASSETS. 'js/frontend.js',
//                 'version' => filemtime( KZ_CAFE_PATH . '/assets/js/frontend.js'),
//                 'deps'    => ['jQuery'],
//             ]
//         ];
//     }

//      public function get_styles() {
//         return [
//             'kz-cafe-order-style' => [
//                 'src'     => KZ_CAFE_ASSETS. 'css/frontend.js',
//                 'version' => filemtime( KZ_CAFE_PATH . '/assets/css/frontend.css'),
//             ],
//             'kz-cafe-admin-style' => [
//                 'src'     => KZ_CAFE_ASSETS. 'css/frontend.js',
//                 'version' => filemtime( KZ_CAFE_PATH . '/assets/css/frontend.css'),
//             ]
//         ];
//     }

//       public function enqueue_scripts() {
//         $scripts = $this->get_scripts();
//         foreach ( $scripts as $handle => $script) {
//             $deps = isset( $script['deps' ] ) ? $script['deps'] : false;

//             wp_register_script( $handle, $script['src'], $deps, $script['version'] , true );
//         }

//         $styles = $this->get_styles();
//         foreach ( $styles as $handle => $style) {
//             $deps = isset( $style['deps' ] ) ? $style['deps'] : false;

//             wp_register_style( $handle, $style['src'], $deps, $style['version'] );
//         }



       
        
//         wp_enqueue_script( 'kz-cafe-order-script' );
//         wp_enqueue_style( 'kz-cafe-order-style' );

//         wp_localize_script( 'kz-cafe-order', 'kzCafeOrder', [
//             'ajax_url' => admin_url( 'admin-ajax.php' ),
//             'nonce'    => wp_create_nonce( 'kz_cafe_order_nonce' ),
//         ]);
//     }

// }