<?php
/**
 * Hooks for frontend display
 *
 * @package Supglove
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function supro_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$custom_header = supro_get_post_meta( 'custom_header' );

	if ( intval( supro_get_option( 'topbar_enable' ) ) ) {
		$classes[] = 'topbar-enable';
	}

	if ( is_page_template( 'template-home-left-sidebar.php' ) ) {
		$classes[] = 'header-left-sidebar';
	} else {
		$classes[] = 'header-layout-1';
	}

	if ( is_singular( 'post' ) ) {
		$classes[] = supro_get_option( 'single_post_layout' );

	} elseif ( supro_is_blog() ) {
		$classes[] = 'supro-blog-page';
		$classes[] = 'blog-' . supro_get_option( 'blog_style' );
		$classes[] = supro_get_option( 'blog_layout' );

	} elseif ( is_search() ) {

	} else {
		$classes[] = supro_get_layout();
	}

	if ( supro_is_catalog() ) {
		$layout = supro_get_option( 'catalog_layout' );

		if ( $layout == 'masonry-content' ) {
			$classes[] = 'catalog-masonry';
		}
    $classes[] = 'sidebar-content'; // for search
		$classes[] = 'supro-catalog-page';
		$classes[] = 'supro-catalog-mobile-' . intval( supro_get_option( 'catalog_mobile_columns' ) ) . '-columns';

		$view      = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : supro_get_option( 'shop_view' );
		$classes[] = 'shop-view-' . $view;



		if ( intval( supro_get_option( 'catalog_full_width' ) ) ) {
			$classes[] = 'catalog-full-width-layout';
		}

	}

	if ( function_exists( 'is_product' ) && is_product() ) {
		$classes[] = 'single-product-layout-1';

 	$classes[] = supro_get_option( 'single_product_sidebar' );
		

		if ( intval( supro_get_option( 'product_add_to_cart_sticky' ) ) ) {
			$classes[] = 'add-to-cart-sticky';
		}
	}

	if ( supro_header_transparent() ) {
		$classes[] = 'header-transparent';

		if ( $custom_header ) {
			$text_color = supro_get_post_meta( 'header_text_color' );
		} else {
			$text_color = supro_get_option( 'header_text_color' );
		}

		$classes[] = 'header-color-' . $text_color;
	}

	if ( supro_header_sticky() ) {
		$classes[] = 'header-sticky';
	}

	$header_border = supro_get_post_meta( 'header_border' );

	if (
		( supro_is_home() && ! is_page_template( 'template-home-left-sidebar.php' ) ) ||
		( $custom_header && $header_border )
	) {
		$classes[] = 'header-no-border';
	}

	if ( is_page_template( 'template-home-boxed.php' ) ) {
		$id       = get_post_meta( get_the_ID(), 'image', true );
		$bg_color = get_post_meta( get_the_ID(), 'color', true );

		if ( ! $id && ! $bg_color ) {
			$classes[] = 'no-background';
		}
	}





	return $classes;
}

add_filter( 'body_class', 'supro_body_classes' );
