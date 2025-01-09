<?php
/**
 * Template Name: Sample Box
 *
 * The template file for displaying service page.
 *
 * @package Supglove
 */

get_header();
?>
<div class="formobile">
<?php 

echo do_shortcode( '[do_widget "+ Product Filter"]' );
?>
</div>
	<aside id="primary-sidebar" class="widgets-area primary-sidebar <?php if (isset($sidebar)) { echo esc_attr( $sidebar ); } ?> attribute-page col-xs-12 col-sm-12 col-md-3">
        <?php
        //Product Filter Custom HOOK
        //do_action( 'woocommerce_filter_before_shop_sidebar');
        ?>


        <?php
        /*
         * supro_open_wrapper_catalog_content_sidebar -10
         *
         */
        //do_action( 'supro_before_sidebar_content' );

        if (is_active_sidebar('sample-box-product')) {
            dynamic_sidebar('sample-box-product');
        }

        /*
         * supro_open_wrapper_catalog_content_sidebar -100
         *
         */
        do_action( 'supro_after_sidebar_content' );

        ?>
	</aside><!-- #secondary -->
	<div id="primary" class="content-area col-md-9 col-sm-12 col-xs-12" role="main">
		<main id="main" class="site-main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				if ( supro_is_maintenance_page() ) {
					the_content();
				} else {
					get_template_part( 'parts/content', 'sample-box' );
				}
				?>
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>