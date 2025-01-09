<?php

/**
	List Item
**/

// Register Shortcode
if( ! function_exists( 'shortcode_boc_list_item' ) ) {
	function shortcode_boc_list_item( $atts, $content = null ) {
		

		$atts = vc_map_get_attributes('boc_list_item', $atts );
		extract( $atts );

		$icon_css = $icon_bgr_css = '';

		if($has_icon_color){
			if($icon_solid) {
				$icon_bgr_css = "background: ". esc_attr($icon_color) .";";
			}else {
				$icon_css = "color: ". esc_attr($icon_color) .";";
			}
		}

		//$css_animation = $this->getCSSAnimation($css_animation);
		
		$css_animation_classes = "";
		if ( $css_animation !== '' ) {
			$css_animation_classes = 'boc_animate_when_almost_visible boc_'. $css_animation .'';
		}
		if($margin_bottom){
			$margin_bottom_css = ' style="margin-bottom: '.esc_attr($margin_bottom).';"';
		}		
		
		$str = '<div class="boc_list_item '. esc_attr($css_animation_classes) .' '.esc_attr($css_classes).'" '.(isset($margin_bottom_css) ? $margin_bottom_css : "").'>
					<span class="li_icon '.esc_attr($icon_size).' '.($icon_solid ? ' icon_solid': '').'" style="'.$icon_bgr_css.'"><i class="' . esc_attr($icon) . '" style="'.$icon_css.'"></i></span>
					<div class="boc_list_item_text '.esc_attr($icon_size).'">'. do_shortcode($content) .'</div>
				   </div>';
		return $str;
	}
	
	add_shortcode('boc_list_item', 'shortcode_boc_list_item');
}


// Map Shortcode in Visual Composer
vc_map( array(
   "name" 			=> __("List Item", 'SuperiorGlove'),
   "description" 	=> __("Custom Icon List Item", 'SuperiorGlove'),
   "base" 			=> "boc_list_item",
   "category" 		=> "SuperiorGlove Shortcodes",
   "icon" 			=> "boc_list_item",
   "weight"			=> 68,
   "params" 		=> array(
        // added by valkilmar #1 :: START
		array(
			"type"          => "iconpicker",
			"heading"       => "Icon",
			"param_name"    => "icon",
			"admin_label"   => true,
			"settings" => array(
				'type' => 'ogsicons',
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
            ),
			'description' => __( 'Select icon from library.', 'SuperiorGlove'),
		),
		array(
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __( "Icon Size", 'SuperiorGlove'),
			"param_name"		=> "icon_size",
			"description"		=> __( "Select an icon size.", 'SuperiorGlove'),
			"value"			=> array(
				__( "Small", "SuperiorGlove")			=> "small",
				__( "Normal", "SuperiorGlove" )		=> "normal",
				__( "Large", "SuperiorGlove" )		=> "large",
			),
			"std"			=> 'normal',
		),		
		array(
			"type"		=> 'checkbox',
			"heading"	=> __("Overwrite Icon Color", "SuperiorGlove"),
			"param_name"	=> "has_icon_color",
			"value"		=> Array(__("Yes", "SuperiorGlove") => 'yes'),
			"description"	=> __("If not checked Icon will inherit your main theme color", "SuperiorGlove"),
		),
		array(
			"type"			=> "colorpicker",
			"heading"		=> "Icon Color",
			"param_name"	=> "icon_color",
			"value"			=> "#333333",
			"dependency"	=> Array( 'element'	=> "has_icon_color", 'not_empty' => true ),				
		),
		array(
			"type" 			=> "checkbox",
			"heading" 		=> __("Icon Solid", 'SuperiorGlove'),
			"param_name" 	=> "icon_solid",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
			"description"	=> __("Do you want your icon to be a solid Background color and white icon", 'SuperiorGlove'),
		),   
		array(
			"type" 			=> "textarea_html",
			"heading" 		=> __("Text", 'SuperiorGlove'),
			"param_name" 	=> "content",
			"value" 		=> __("List Item Text", 'SuperiorGlove'),
		),
		array(
			"type"			=> "textfield",
			"heading"		=> "Margin Bottom",
			"param_name"	=> "margin_bottom",
			"value"			=> "",
			"description"	=> "Add a bottom margin if you want one. Default is (4px)",			
		),
		array(
			"type"		=> "dropdown",
			"heading"	=> __("CSS Animation", "SuperiorGlove"),
			"param_name"	=> "css_animation",
			"admin_label"	=> true,				
			"value"			=> array(
				__("None", "SuperiorGlove")					=> '',
				__("Top to bottom", "SuperiorGlove")			=> "top-to-bottom",
				__("Bottom to top", "SuperiorGlove")			=> "bottom-to-top",
				__("Left to right", "SuperiorGlove")			=> "left-to-right",
				__("Right to left", "SuperiorGlove")			=> "right-to-left",
				__("Fade In", "SuperiorGlove")				=> "fade-in"),
			"description"	=> __("Select one if you want this element to be animated once it enters the browsers viewport.", "SuperiorGlove"),
		),		
		array(
			"type" 		=> "textfield",
			"heading" 	=> __("Extra class name", 'SuperiorGlove'),
			"param_name" => "css_classes",
			"value" 	=> "",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'SuperiorGlove'),
		),	
	)
));