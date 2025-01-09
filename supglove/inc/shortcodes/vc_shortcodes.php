<?php

// SuperiorGlove shortcode initializations for Visual Composer
if ( !function_exists( 'boc_extend_VC_shortcodes' )) {
	function boc_extend_VC_shortcodes() {

		// Add Custom CSS for Theme Shortcodes in VC 
		if ( !function_exists( 'boc_load_admin_scripts' ) ) {
			function boc_load_admin_scripts() {
				wp_enqueue_style( 'boc-admin-css-icons', get_template_directory_uri().'/css/linearicons.css');
				wp_enqueue_style( 'boc-admin-css', get_template_directory_uri().'/inc/shortcodes/assets/css/admin.css');
			}
		}
		add_action( 'admin_enqueue_scripts', 'boc_load_admin_scripts' );

		// Include Icon Font array
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_heading.php');
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_button.php');	
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_mobilespacer.php');	
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_iconpicker.php');
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_divider.php');
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_icon.php');
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_top_icon_box.php');
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_list_item.php');
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_accordion.php');
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_tabs.php');
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_content_slider.php');		
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_spacing.php');	
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_side_icon_box.php');
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_side_img_box.php');	
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_flip_card.php');	
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_floatpic.php');		
		load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_three_cards.php');		
				load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_careers.php');		
				load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_fullback.php');	
				load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_ctacard.php');		
				load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_listblock.php');
				load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc/boc_timeline.php');

	}
}


// Remove stuff from default Visual Composer if set in Theme Options
if ( !function_exists( 'boc_modify_default_VC_modules' )) {
	function boc_modify_default_VC_modules(){

	
		// Remove Default VC templates
		add_filter( 'vc_load_default_templates', 'boc_custom_VC_templates' );
		function boc_custom_VC_templates( $data ) {
			return array(); // This will remove all default templates. 
		}	
	
	
		if ( function_exists('vc_remove_element') ) {
			if ( !function_exists( 'boc_vc_modules_remove' )) {
				function boc_vc_modules_remove() {
					vc_remove_element('vc_wp_tagcloud');
					vc_remove_element('vc_wp_archives');
					vc_remove_element('vc_wp_calendar');
					vc_remove_element('vc_wp_pages');
					vc_remove_element('vc_wp_links');
					vc_remove_element('vc_wp_posts');
					vc_remove_element('vc_wp_custommenu');
					vc_remove_element('vc_wp_search');
					vc_remove_element('vc_wp_recentcomments');
					vc_remove_element('vc_facebook');
					vc_remove_element('vc_gmaps');
					vc_remove_element('vc_pinterest');
					vc_remove_element('vc_googleplus');
					vc_remove_element('vc_tweetmeme');
					vc_remove_element('vc_posts_grid');
					vc_remove_element('vc_posts_slider');
					vc_remove_element('vc_carousel');
					vc_remove_element('vc_separator');
					vc_remove_element('vc_gallery');
					vc_remove_element('vc_pie');
					vc_remove_element('vc_flickr');
					vc_remove_element('vc_progress_bar');
					vc_remove_element('vc_widget_sidebar');
					vc_remove_element('vc_toggle');
					vc_remove_element('vc_accordion');
					vc_remove_element('vc_cta');
					vc_remove_element('vc_btn');
					vc_remove_element('vc_button');
					vc_remove_element('vc_button2');
					vc_remove_element('vc_cta_button');
					vc_remove_element('vc_cta_button2');
					vc_remove_element('rev_slider_vc');
					vc_remove_element('vc_wp_categories');
					vc_remove_element('vc_wp_rss');
					vc_remove_element('vc_wp_text');
					vc_remove_element('vc_wp_meta');
					vc_remove_element('vc_custom_heading');
					vc_remove_element('vc_icon');
					vc_remove_element('vc_empty_space');
					vc_remove_element('vc_tabs');
					vc_remove_element('vc_tour');
					vc_remove_element('vc_message');
					vc_remove_element('vc_tta_pageable');					
					vc_remove_element('vc_basic_grid');
					vc_remove_element('vc_media_grid');
					vc_remove_element('vc_masonry_grid');
					vc_remove_element('vc_masonry_media_grid');
					vc_remove_element('vc_images_carousel');
					vc_remove_element('layerslider_vc');
					vc_remove_element('vc_text_separator');					
					vc_remove_element('vc_tta_tabs');
					vc_remove_element('vc_tta_tour');
					vc_remove_element('vc_tta_accordion');
					vc_remove_element('vc_round_chart');
					vc_remove_element('vc_line_chart');
					vc_remove_element('vc_hoverbox');
					vc_remove_element('vc_zigzag');
					
					
					//vc_remove_element('add_to_cart_url');
					//vc_remove_element('product_attribute');
				
					
				} // End function
			} 
			
		
			add_action( 'init', 'boc_vc_modules_remove' );
			add_action( 'init', 'boc_modify_VC_elements' );
			
		} 

		
		if ( !function_exists( 'boc_modify_VC_elements' )) {
			function boc_modify_VC_elements() {
				
				// Rearrange element Weight a bit
				if ( function_exists('vc_map_update') ) {
					// Row
					$settings = array (
					  'weight' => 100
					);
					vc_map_update( 'vc_row', $settings );
					
					// Image
					$settings = array (
					  'weight' => 75
					);
					vc_map_update( 'vc_single_image', $settings );
					
					// Text
					$settings = array (
					  'weight' => 74
					);
					vc_map_update( 'vc_column_text', $settings );
				}


				// Modify Animations to be custom for column and image elements
				vc_remove_param( 'vc_single_image', 'css_animation' );
				vc_remove_param( 'vc_column_text', 'css_animation' );
				
				$attributes = array(
					"type"		=> "dropdown",
					"heading"	=> __("CSS Animation", "SuperiorGlove"),
					"param_name"	=> "css_animation",
					"admin_label"	=> true,				
					"value"			=> array(
						__("None", "SuperiorGlove")					=> '',
						__("Top to bottom", "SuperiorGlove")			=> "boc_animate_when_almost_visible boc_top-to-bottom",
						__("Bottom to top", "SuperiorGlove")			=> "boc_animate_when_almost_visible boc_bottom-to-top",
						__("Left to right", "SuperiorGlove")			=> "boc_animate_when_almost_visible boc_left-to-right",
						__("Right to left", "SuperiorGlove")			=> "boc_animate_when_almost_visible boc_right-to-left",
						__("Fade In", "SuperiorGlove")				=> "boc_animate_when_almost_visible boc_fade-in"),
					"description"	=> __("Select one if you want this element to be animated once it enters the browsers viewport.", "SuperiorGlove"),
				);
				vc_add_param( 'vc_single_image', $attributes ); 
				vc_add_param( 'vc_column_text', $attributes ); 
				
				
				// Mofidy Image Element
				vc_remove_param( 'vc_single_image', 'img_size' );
				vc_remove_param( 'vc_single_image', 'title' );
				vc_remove_param( 'vc_single_image', 'image' );
				

				$attributes = array(
					"type" => "attach_image",
					"heading" => __("Image", "SuperiorGlove"),
					"param_name" => "image",
					"description" => __("Select image from media library.", "SuperiorGlove"),
					"weight"		=> 1,
				);
				vc_add_param( 'vc_single_image', $attributes );
				
				$attributes = array(
					"type"		=> "dropdown",
					"heading"	=> __("Image Size", "SuperiorGlove"),
					"param_name"	=> "img_size",			
					"value"			=> array(
						__("Full Size", "SuperiorGlove")				=> 'full',
						__("Large", "SuperiorGlove")				=> "large",
						__("Medium", "SuperiorGlove")				=> "boc_medium",
						__("Small", "SuperiorGlove")				=> "medium",
						__("Thumbnail", "SuperiorGlove")				=> "thumbnail"),
					"weight"		=> 1,
				);
				vc_add_param( 'vc_single_image', $attributes ); 

				
				$attributes = array(
					"type"		=> "dropdown",
					"heading"	=> __("Lity Popup (Link should be video)", "Samko"),
					"param_name"	=> "lity",			
					"value"			=> array(
						__("No", "Samko")				=> 'no',
						__("Yes", "Samko")				=> "yes"),
					"weight"		=> 1,
				);
				vc_add_param( 'vc_single_image', $attributes ); 
				
				
				
				
				// change Row icon
				$settings = array (
				  "icon"   => "boc_row",
				);
				vc_map_update( 'vc_row', $settings );	
				
				// change vc_widget_sidebar icon
				$settings = array (
				  "icon"   => "boc_widget_area",
				);
				vc_map_update( 'vc_widget_sidebar', $settings );					
			
				// change IMG icon
				$settings = array (
				  "icon"   => "boc_img",
				);
				vc_map_update( 'vc_single_image', $settings );				
			
				// change Text Block icon
				$settings = array (
				  "icon"   => "boc_text",
				);
				vc_map_update( 'vc_column_text', $settings );			
				
				// change soc btn icons
				$settings = array (
				  "icon"   => "boc_facebook",
				);
				vc_map_update( 'vc_facebook', $settings );

				$settings = array (
				  "icon"   => "boc_twitter",
				);
				vc_map_update( 'vc_tweetmeme', $settings );

				$settings = array (
				  "icon"   => "boc_google",
				);
				vc_map_update( 'vc_googleplus', $settings );

				$settings = array (
				  "icon"   => "boc_pinterest",
				);
				vc_map_update( 'vc_pinterest', $settings );

				
				// change other icons
				$settings = array (
				  "icon"   => "boc_video",
				);
				vc_map_update( 'vc_video', $settings );
				
				$settings = array (
				  "icon"   => "boc_gmaps",
				);
				vc_map_update( 'vc_gmaps', $settings );
				
				$settings = array (
				  "icon"   => "boc_html",
				);
				vc_map_update( 'vc_raw_html', $settings );
				
				$settings = array (
				  "icon"   => "boc_js",
				);
				vc_map_update( 'vc_raw_js', $settings );
				
				$settings = array (
				  "icon"   => "boc_cf7",
				);
				@vc_map_update( 'contact-form-7', $settings );
				
				/*$settings = array (
				  "icon"   => "boc_rev_slider",
				);
				@vc_map_update( 'rev_slider_vc', $settings );*/
				
				
				$settings = array (
				  "icon"   => "boc_woocommerce",
				);
				@vc_map_update( 'woocommerce_cart', $settings );
				@vc_map_update( 'woocommerce_checkout', $settings );
				@vc_map_update( 'woocommerce_order_tracking', $settings );
				@vc_map_update( 'woocommerce_my_account', $settings );
				@vc_map_update( 'featured_products', $settings );
				@vc_map_update( 'product', $settings );
				@vc_map_update( 'products', $settings );
				@vc_map_update( 'add_to_cart', $settings );
				@vc_map_update( 'add_to_cart_url', $settings );
				@vc_map_update( 'recent_products', $settings );
				@vc_map_update( 'product_page', $settings );
				@vc_map_update( 'product_category', $settings );
				@vc_map_update( 'product_categories', $settings );
				@vc_map_update( 'sale_products', $settings );
				@vc_map_update( 'best_selling_products', $settings );
				@vc_map_update( 'top_rated_products', $settings );
				@vc_map_update( 'product_attribute', $settings );
				
			}
		}
		
		
		// Remove 'Grid Elements' from Admin menu
		function boc_remove_grid_elements_menu(){
		  remove_menu_page( 'edit.php?post_type=vc_grid_item' );
		}
		add_action( 'admin_menu', 'boc_remove_grid_elements_menu' );


		// Remove teaser metabox
		if (is_admin()) {
			function boc_remove_meta_boxes() {
				remove_meta_box( 'vc_teaser', 'page', 		'side' );
				remove_meta_box( 'vc_teaser', 'post', 		'side' );
				remove_meta_box( 'vc_teaser', 'portfolio', 	'side' );
				remove_meta_box( 'vc_teaser', 'product', 	'side' );
			}
			add_action( 'admin_init', 'boc_remove_meta_boxes' );
		}
	}
}