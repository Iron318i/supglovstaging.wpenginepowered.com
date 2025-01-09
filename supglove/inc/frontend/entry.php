<?php
/**
 * Hooks for template archive
 *
 * @package Supglove
 */


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @since 1.0
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function supro_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

add_action( 'wp', 'supro_setup_author' );

/**
 * Add CSS classes to posts
 *
 * @param array $classes
 *
 * @return array
 */
function supro_post_class( $classes ) {

	$classes[] = has_post_thumbnail() ? '' : 'no-thumb';

	return $classes;
}

add_filter( 'post_class', 'supro_post_class' );

/**
 * Open tag after start site content
 */
if ( ! function_exists( 'supro_site_content_open' ) ) :

	function supro_site_content_open() {
		$container       = 'container';

		if ( supro_is_page_template() ) {
			$container = 'container-fluid';
		}


		
		if ( is_home() || is_archive() ) { //checking if on blog page
			$container = 'container-fluid';
		}
		
		if ( supro_is_catalog() ) {
			$container = 'container';
		}

		if ( supro_is_catalog() && intval( supro_get_option( 'catalog_full_width' ) ) ) {
			$container = 'container-fluid';
		}




		
		


		

		echo '<div class="' . esc_attr( apply_filters( 'supro_site_content_container_class', $container ) ) . ' maincontfirst">';
		echo '<div class="row">';
		
		
		if ( supro_is_catalog() ) {
			do_action( 'woocommerce_before_main_content_above');
		}
		
	}

endif;

add_action( 'supro_site_content_open', 'supro_site_content_open', 20 );

/**
 * Close tag before end site content
 */
if ( ! function_exists( 'supro_site_content_close' ) ) :

	function supro_site_content_close() {
		echo '</div>';
		echo '</div>';
	}

endif;

add_action( 'supro_site_content_close', 'supro_site_content_close', 100 );




/**
 * Filter to archive title and add page title for singular pages
 *
 * @param string $title
 *
 * @return string
 */
function supro_the_archive_title( $title ) {
	if ( is_search() ) {
		$title = esc_html__( 'Search Results', 'supro' );
	} elseif ( is_404() ) {
		$title = esc_html__( 'Page Not Found', 'supro' );

	} elseif ( is_page() ) {
		$title = get_the_title();
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$title = get_the_title( wc_get_page_id( 'shop' ) );
	} elseif ( function_exists( 'is_product' ) && is_product() ) {
		$cats = get_the_terms( get_the_ID(), 'product_cat' );
		if ( ! is_wp_error( $cats ) && $cats ) {
			$title = $cats[0]->name;
		} else {
			$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		}

	} elseif ( is_tax() || is_category() ) {
		$title = single_term_title( '', false );

	} elseif ( is_singular( 'post' ) ) {
		$terms = get_the_category();
		if ( $terms && ! is_wp_error( $terms ) ) {
			$title = $terms[0]->name;
		} else {
			$title = get_the_title( get_option( 'page_for_posts' ) );
		}
	} elseif ( is_home() && is_front_page() ) {
		$title = esc_html__( 'The Latest Posts', 'supro' );

	} elseif ( is_home() && ! is_front_page() ) {

		if ( empty( $title ) ) {
			$title = get_the_title( get_option( 'page_for_posts' ) );
		}
	}

	if ( get_option( 'woocommerce_shop_page_id' ) ) {
		if ( is_front_page() && ( get_option( 'woocommerce_shop_page_id' ) == get_option( 'page_on_front' ) ) ) {
			$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		}
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'supro_the_archive_title' );

/**
 * Open wrapper for catalog content sidebar
 */
function supro_open_wrapper_catalog_content_sidebar() {
	if ( ! supro_is_catalog() ) {
		return;
	}

	?>
	<div class="widget-canvas-content">
	<div class="widget-panel-header hidden-lg">
		<a href="#" class="close-canvas-panel"><span class="icon icon-cross"></span></a>
	</div>
	<div class="widget-panel-content">
	<?php
}

add_action( 'supro_before_sidebar_content', 'supro_open_wrapper_catalog_content_sidebar', 10 );

/**
 * Close wrapper for catalog content sidebar
 */
function supro_close_wrapper_catalog_content_sidebar() {
	if ( ! supro_is_catalog() ) {
		return;
	}

	?>
	</div> <!-- .widget-panel-content -->
	</div> <!-- .widget-canvas-content -->
	<?php
}

add_action( 'supro_after_sidebar_content', 'supro_close_wrapper_catalog_content_sidebar', 100 );

