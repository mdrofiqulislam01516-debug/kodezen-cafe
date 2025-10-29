<?php
namespace kodezen\cafe\Frontend;

/**
 * Shortcode class 
 */
class kz_cafe_Shortcode {

    /**
     * Shortcode register hook 
     */

    function __construct() {

        add_shortcode( 'kodezen-cafe', [ $this, 'render_menu_items' ] );

    }

    /**
     * shortcode register 
     */

    public function render_menu_items($atts) {

        ob_start();

        $args = [
            'post_type' => 'kodezen_cafe',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        $query = new \WP_Query( $args );

        if ( $query->have_posts() ) {

            echo '<div class="kodezen-cafe-wrap" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:20px;">';

            while ($query->have_posts()) {

                $query->the_post();

                $price          = get_post_meta(get_the_ID(), '_kz_cafe_price', true);
                $ingredients    = get_post_meta(get_the_ID(), '_kz_cafe_ingredients', true);
                $stock_value          = intval(get_post_meta(get_the_ID(), '_kz_cafe_stock_value', true));
                $thumbnail      = get_the_post_thumbnail(get_the_ID(), 'medium', ['style'=>'width:100%;border-radius:10px;']);

                ?>

                <div class="kz-cafe-item" style="border:1px solid #ddd;padding:15px;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.1);">

                    <?php echo $thumbnail; ?>
                    <h3 style="margin:10px 0;"><?php the_title(); ?></h3>

                    <?php if ( $price ) : ?>
                        <p><strong>Price:</strong> $<?php echo esc_html( $price ); ?></p>
                    <?php endif; ?>

                    <?php if ( $ingredients ) : ?>
                        <p><strong>Ingredients:</strong> <?php echo esc_html( $ingredients ); ?></p>
                    <?php endif; ?>

                    <p><strong>Status:</strong> 
                        <?php echo $stock_value > 0 ? '✅ Available (' . $stock_value .')' : '❌ Out of Stock'; ?>
                    </p>

                    <?php if (is_user_logged_in()) : ?>

                        <?php if ( $stock_value > 0  ) : ?>                            
                            <a href="<?php echo site_url('/order-form?item_id='. get_the_ID()); ?>">Order Now</a>
                        <?php else : ?>

                            <button disabled style="opacity:0.5;cursor:not-allowed;">Out of Stock</button>
                        <?php endif; ?>
                    <?php else : ?>

                        <a href="<?php echo wp_login_url(site_url('/order-form?item_id='. get_the_ID())); ?>">Login</a>                        
                    <?php endif; ?>
                </div>
                <?php
            }

            echo '</div>';

            wp_reset_postdata();

        } else {

            echo '<p>No menu items found.</p>';

        }

        return ob_get_clean();
    }
}
