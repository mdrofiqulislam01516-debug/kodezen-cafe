<?php
namespace kodezen\cafe\Admin;

class kz_cafe_Customer_Role {
    function __construct() {
         add_action( 'init', [ $this, 'kz_cafe_customer_role_add' ] );
    }

    public function kz_cafe_customer_role_add() {
            add_role(
                'kz_cafe_customer',              
                'Kz Cafe Customer',              
                array(
                    'read' => true,
                )
            );
    }
}
