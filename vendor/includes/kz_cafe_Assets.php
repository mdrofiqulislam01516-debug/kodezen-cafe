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

//     /**
//      * Handle AJAX order submission
//      */
//     public function submit_order() {
//         check_ajax_referer( 'kz_cafe_order_nonce', 'nonce' );

//         $name  = sanitize_text_field( $_POST['customer_name'] ?? '' );
//         $email = sanitize_email( $_POST['customer_email'] ?? '' );
//         $items = isset($_POST['order_items']) ? sanitize_textarea_field($_POST['order_items']) : '';
//         $price = floatval( $_POST['total_price'] ?? 0 );
//         $quantity = intval( $_POST['quantity'] ?? 1 );


//         if ( empty( $name ) || empty( $email ) || empty( $items ) || $price <= 0 ||  $quantity < 1 )  {
//             wp_send_json_error( 'Please fill all required fields.' );
//         }

//         $order_id = wp_insert_post([
//             'post_type'   => 'kz_cafe_order',
//             'post_title'  => $name,
//             'post_status' => 'publish',
//         ]);

//         if ( ! $order_id ) {
//             wp_send_json_error( 'Order could not be created.' );
//         }

//         update_post_meta( $order_id, '_kz_cafe_customer_name', $name );
//         update_post_meta( $order_id, '_kz_cafe_customer_email', $email );
//         update_post_meta( $order_id, '_kz_cafe_order_items', $items );
//         update_post_meta( $order_id, '_kz_cafe_total_price', $price );
//         update_post_meta( $order_id, '_kz_cafe_order_quantity', $quantity );
//         update_post_meta( $order_id, '_kz_cafe_order_status', 'pending' );

//         wp_send_json_success( 'Your order has been placed successfully!' );
//     }

    // public function get_scripts() {
    //     return [
    //         'kz_cafe-script' => [
    //             'src'     => KZ_CAFE_ASSETS. 'js/kz_cafe_frontend.js',
    //             'version' => filemtime( KZ_CAFE_PATH . '/assets/js/frontend.js'),
    //         ]
    //     ];
    // }

    // public function get_styles() {
    //     return [
    //         'kz_cafe-style' => [
    //             'src'     => KZ_CAFE_ASSETS. 'css/kz_cafe_frontend.css',
    //             'version' => filemtime( KZ_CAFE_PATH . '/assets/css/frontend.css'),
    //         ]
    //     ];
    // }

//     public function kz_cafe_enqueue() {
        
//         wp_enqueue_script( 'kz_cafe-script', KZ_CAFE_ASSETS. 'js/kz_cafe_frontend.js', false, filemtime( KZ_CAFE_PATH . '/assets/js/frontend.js'), true);

//         wp_enqueue_style( 'kz_cafe-style', KZ_CAFE_ASSETS. 'css/kz_cafe_frontend.css', false, filemtime( KZ_CAFE_PATH . '/assets/css/frontend.css') );
//     }


// }

// // php
// // namespace kodezen\cafe\Frontend;

// class kz_cafe_Order_Form {

//     public function __construct() {
        


//          add_action( 'wp_ajax_kz_cafe_submit_order', [ $this, 'submit_order' ] );
//         add_action( 'wp_ajax_nopriv_kz_cafe_submit_order', [ $this, 'submit_order' ] );

//         // Enqueue JS
//         add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
//     }

//     public function enqueue_scripts() {
//         wp_enqueue_script( 'kz-cafe-order', plugin_dir_url( __DIR__ ) . 'Frontend/js/kz_cafe_Order.js', ['jquery'], '1.0', true );

//         wp_enqueue_script( 'kz-cafe-order', plugin_dir_url( __DIR__ ) . 'Frontend/js/kz_cafe_Order.js', ['jquery'], '1.0', true );

//         wp_localize_script( 'kz-cafe-order', 'kzCafeOrder', [
//             'ajax_url' => admin_url( 'admin-ajax.php' ),
//             'nonce'    => wp_create_nonce( 'kz_cafe_order_nonce' ),
//         ]);
//     }

   

//     /**
//      * Handle AJAX order submission
//      */
//     public function submit_order() {
//         check_ajax_referer( 'kz_cafe_order_nonce', 'nonce' );

//         $name  = sanitize_text_field( $_POST['customer_name'] ?? '' );
//         $email = sanitize_email( $_POST['customer_email'] ?? '' );
//         $items = isset($_POST['order_items']) ? sanitize_textarea_field($_POST['order_items']) : '';
//         $price = floatval( $_POST['total_price'] ?? 0 );
//         $quantity = intval( $_POST['quantity'] ?? 1 );


//         if ( empty( $name ) || empty( $email ) || empty( $items ) || $price <= 0 ||  $quantity < 1 )  {
//             wp_send_json_error( 'Please fill all required fields.' );
//         }

//         $order_id = wp_insert_post([
//             'post_type'   => 'kz_cafe_order',
//             'post_title'  => $name,
//             'post_status' => 'publish',
//         ]);

//         if ( ! $order_id ) {
//             wp_send_json_error( 'Order could not be created.' );
//         }

//         update_post_meta( $order_id, '_kz_cafe_customer_name', $name );
//         update_post_meta( $order_id, '_kz_cafe_customer_email', $email );
//         update_post_meta( $order_id, '_kz_cafe_order_items', $items );
//         update_post_meta( $order_id, '_kz_cafe_total_price', $price );
//         update_post_meta( $order_id, '_kz_cafe_order_quantity', $quantity );
//         update_post_meta( $order_id, '_kz_cafe_order_status', 'pending' );

//         wp_send_json_success( 'Your order has been placed successfully!' );
//     }
// }

 

       
    

    



