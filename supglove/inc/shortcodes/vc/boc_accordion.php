<?php

/**
	Accordion
**/

// Register Shortcodes
if( ! function_exists( 'shortcode_boc_accordion_section' ) ) {
	function shortcode_boc_accordion_section( $atts, $content = null ) {

		$atts = vc_map_get_attributes('boc_accordion_section', $atts );
		extract( $atts );
		
		if($no_sibling_toggle){
			$css_classes .= " no_sibling_toggle";
		}

		$content = '<div class="acc_holder '.esc_attr($css_classes).' '.($rounded ? "rounded" : "").' '.($with_bgr ? "with_bgr" : "").' '.($border ? "border" : "").'">'.do_shortcode($content).'</div>';
		return $content;
	}
	
	add_shortcode('boc_accordion_section', 'shortcode_boc_accordion_section');
}

if( ! function_exists( 'shortcode_boc_accordion' ) ) {
	function shortcode_boc_accordion( $atts, $content = null ) {
	
		$atts = vc_map_get_attributes('boc_accordion', $atts );
		extract( $atts );		

		$content = '<div class="acc_item"><h4 class="accordion"><span class="acc_control '.($is_open ? "acc_is_open" : "").'"></span><span class="acc_heading">'.wp_kses_post($title).'</span></h4><div class="accordion_content">'.do_shortcode($content).'</div></div>';
		return $content;
	}
	add_shortcode('boc_accordion', 'shortcode_boc_accordion');
}

// Map Shortcodes in Visual Composer
vc_map( array(
	"name" 			=> __("Accordion", 'SuperiorGlove'),
	"base" 			=> "boc_accordion_section",
	"as_parent" 	=> array('only' => 'boc_accordion'), //limit child shortcodes
	"content_element" => true,
	"icon" 			=> "boc_accordion_section",
	"category" 		=> "SuperiorGlove Shortcodes",
	"show_settings_on_create" => true,
	"js_view" 		=> 'VcColumnView',
	"weight"		=> 38,
	"params" 		=> array(
		array(
			"type"			=> 'checkbox',
			"heading" 		=> __("Circular Buttons?", 'SuperiorGlove'),
			"param_name" 	=> "rounded",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
			"description" 	=> __("Circular buttons or squared", 'SuperiorGlove'),
		),
		array(
			"type"			=> 'checkbox',
			"heading" 		=> __("Background Style", 'SuperiorGlove'),
			"param_name" 	=> "with_bgr",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
			"description" 	=> __("Use style with Background", 'SuperiorGlove'),
		),
		array(
			"type"			=> 'checkbox',
			"heading" 		=> __("Add Border between Items?", 'SuperiorGlove'),
			"param_name" 	=> "border",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
			"description" 	=> __("Divide Accordion items with a grey border", 'SuperiorGlove'),
		),
		array(
			"type" 			=> "checkbox",
			"heading" 		=> __("Do not toggle siblings?", 'SuperiorGlove'),
			"param_name" 	=> "no_sibling_toggle",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
			"description" 	=> __("Set if you don't want to close siblings when clicking on an item", 'SuperiorGlove'),
		),
		array(
			"type" 			=> "textfield",
			"heading" 		=> __("Extra class name", 'SuperiorGlove'),
			"param_name" 	=> "css_classes",
			"description" 	=> __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'SuperiorGlove'),
		),
	)
) );

vc_map( array(
	"name" => __("Accordion Item", 'SuperiorGlove'),
	"base" => "boc_accordion",
	"icon" 	=> "boc_accordion_section",
	"as_child" => array('only' => 'boc_accordion_section'), // Use only|except attributes to limit parent (separate multiple values with comma)
	"params" => array(
		array(
			"type" 			=> "textfield",
			"heading" 		=> __("Title", 'SuperiorGlove'),
			"param_name" 	=> "title",
			"value" 		=> __("Accordion Title Text", 'SuperiorGlove'),
			"description" 	=> __("Set your Accordion Title", 'SuperiorGlove'),
		),
		array(
			"type" 			=> "textarea_html",
			"heading" 		=> __("Accordion Text", 'SuperiorGlove'),
			"param_name" 	=> "content",
			"value" 		=> __("Accordion Content Text", 'SuperiorGlove'),
			"description" 	=> __("Enter the text for your accordion item.", 'SuperiorGlove'),
		),
		array(
			"type" 			=> "checkbox",
			"heading" 		=> __("Open By Default", 'SuperiorGlove'),
			"param_name" 	=> "is_open",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
			"description" 	=> __("Set if you want this Item to be Open by default at Page load. Only one item per accordion should be open.", 'SuperiorGlove'),
		),	
	)
));

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_boc_accordion_section extends WPBakeryShortCodesContainer {
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_boc_accordion extends WPBakeryShortCode {
	}
}