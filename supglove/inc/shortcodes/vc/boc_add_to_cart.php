<?php

/**
	Button Shortcode - part of the Theme Base -> shortcodes.php
**/



// Map Shortcode in Visual Composer
	
vc_map( array(
	"name" 		=> __("SuperiorGlove Add To Cart", 'SuperiorGlove'),
	"base" 		=> "boc_add_to_cart",
	"class" 	=> "boc_add_to_cart",
	"icon" 		=> "boc_add_to_cart",
	"category" 	=> "SuperiorGlove Shortcodes",
	"weight"	=> 73,
	"params" 	=> array(
		array(
			 "type" => "textfield",
			 "heading" => __("Text", 'SuperiorGlove'),
			 "param_name" => "btn_content",
			 "value" => "Add To Cart",
			 "admin_label"	=> true,
			 "description" => __("Enter the text for your Button", 'SuperiorGlove'),
		),
		array(
			 "type" => "textfield",
			 "heading" => __("URL Link", 'SuperiorGlove'),
			 "param_name" => "href",
			 "admin_label"	=> true,
			 "value" => "",
			 "description" => __("Enter the link you want your button to take you to once clicked.", 'SuperiorGlove'),
		),
		array(
			 "type" => "dropdown",
			 "heading" => __("Target", 'SuperiorGlove'),
			 "param_name" => "target",
			 "value" => array('_self','_blank'),
			 "description" => __("Pick '_blank' if you want the button link to open in a new tab.", 'SuperiorGlove'),
		),	
		array(
			 "type" => "textfield",
			 "heading" => __("Extra class name", 'SuperiorGlove'),
			 "param_name" => "css_classes",
			 "value" => "",
			 "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'SuperiorGlove'),
		),		  
		array(
			"type"			=> "dropdown",
			"heading"		=> "Button Size",
			"param_name"		=> "size",
			"value"			=> array(
				"Small" => "btn_small",
				"Medium"=> "btn_medium",
				"Large" => "btn_large"
			),
			"std"		=> "btn_medium",
			"description"	=> "Select a size",
			'group'		=> 'Button Design',
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> "Button Color",
			"param_name"		=> "color",
			"admin_label"	=> true,
			"value"			=> array(
				"Theme Color"=> "btn_theme_color",
				"Border Box White" 		=> "btn_dark", // Default
				"Border Box Dark" 		=> "btn_dark2", // Default
				"Miniture Dark" 		=> "btn_white",
				"Miniture Light" 		=> "btn_white2",
			),
			"description"	=> "Select a button color. They are predefined for a number of reasons, like text color, hover effects etc. Use the CSS class option to define your own.",
			'group'			=> 'Button Design',
		),	
   array(
			"type"          => "iconpicker",
			"heading"       => "Add Button Icon",
			"param_name"    => "icon",
			"admin_label"   => true,
			"settings" 		=> array(
				'type'      => 'ogsicons',
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'description'   => __( 'Select icon from library.', 'SuperiorGlove' ),
			"group"         => __( 'Button Icon', 'SuperiorGlove' ),
		),

		array(
			 "type" 		=> "dropdown",
			 "heading" 		=> "Icon Position",
			 "param_name" 	=> "icon_pos",
			 "value"		=> array(
				"Before Text" 	=> "icon_pos_before",
				"After Text" 	=> "icon_pos_after",
			 ),
			 "description" 	=> "Choose a position for the icon",
			 'group'		=> 'Button Icon',
			 "dependency"	=> Array(
				'element'	=> "icon",
				'not_empty'	=> true,
				)
		),
		
		)

));	


if (function_exists('vc_map')) {
    add_filter('vc_autocomplete_boc_add_to_cart_product_id_callback', 'vc_product_search', 10, 1);
    add_filter('vc_autocomplete_boc_add_to_cart_product_id_render', 'vc_product_render', 10, 1);
}

function vc_product_search($search_string) {
    $args = array(
        's' => $search_string,
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 20,
    );

    $products = get_posts($args);
    $results = array();

    foreach ($products as $product) {
        $results[] = array(
            'value' => $product->ID,
            'label' => $product->post_title,
        );
    }

    return $results;
}

function vc_product_render($value) {
    $post = get_post($value['value']);
    return array(
        'label' => $post ? $post->post_title : '',
        'value' => $value['value']
    );
}
