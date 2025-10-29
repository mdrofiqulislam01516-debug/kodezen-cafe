<?php
namespace kodezen\cafe\Admin;

    /**
     * customer role class 
     */

class kz_cafe_Customer_Role {

    /**
    * Role register hook 
    */

    function __construct() {

        add_action( 'init', [ $this, 'kz_cafe_customer_role_add' ] );

    }

    /**
     * Register Role
     */

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
