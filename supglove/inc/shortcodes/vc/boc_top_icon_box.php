<?php

/**
	Top Icon Featured Text
**/

// Register Shortcode
if( ! function_exists( 'shortcode_boc_top_icon_box' ) ) {
	function shortcode_boc_top_icon_box( $atts, $content = null ) {
		
		$atts = vc_map_get_attributes('boc_top_icon_box', $atts );
		extract( $atts );
		
		$link = '';
		if($href){
			$link = '<a href="'.esc_url($href).'" target="'.esc_attr($target).'">';
		}
		
		$unique_id = rand(1,100000);


  
   if($icon_color != ""){
   	$icioncolornew = ' style="color: '.$icon_color.'" '; 
   }
   
   
   $icionshould = '';
   if($icon != "none"){
   	$icionshould = '<div class="icon_holder"><i class="'.esc_attr($icon).'" '.$icioncolornew.' ></i></div>'; 
   }
    
    

    
    
			
		$content = (isset($custom_css) ? $custom_css : '').'<div id="top_icon_box_'.$unique_id.'" class="top_icon_box type '.esc_attr($css_classes).'  '.esc_attr($box_color).' "   >'.($href ? $link : ''). $icionshould .($href ? '</a>' : '').'<h3>'.($href ? $link : '').wp_kses_post($title).($href ? '</a>' : '').'</h3>'.do_shortcode($content).'<div class="qodef-info-box-holder-outer"></div></div>';
		return $content;
	}
	
	add_shortcode('boc_top_icon_box', 'shortcode_boc_top_icon_box');
}




// Map Shortcode in Visual Composer
vc_map( array(
   "name" => __("Top Icon Box", 'SuperiorGlove'),
   "description" => __("Top Icon Box", 'SuperiorGlove'),
   "base" 	=> "boc_top_icon_box",
   "category" => "SuperiorGlove Shortcodes",
   "icon" 	=> "boc_top_icon_box",
   "weight"	=> 72,
   "params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Heading", "SuperiorGlove"),
			"param_name" => "title",
			"admin_label"=> true,
			"value" => __("Featured Title", "SuperiorGlove"),
			"description" => __("Enter the Heading for your Icon Box", "SuperiorGlove"),
		),
		array(
			"type" 		=> "textarea_html",
			"heading" 	=> __("Text Below Title", "SuperiorGlove"),
			"param_name" => "content",
			"value" 	=> __("Featured Text", "SuperiorGlove"),
			"description"=> __("Enter the text to go below your Heading", "SuperiorGlove")
		),			
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "SuperiorGlove"),
			"param_name" => "css_classes",
			"value" => "",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "SuperiorGlove")
		),
		array(
			"type"          => "iconpicker",
			"heading"       => "Icon",
			"param_name"    => "icon",
			"admin_label"   => true,
			"settings" => array(
				'type' => 'ogsicons',
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'description'   => __( 'Select icon from library.', 'SuperiorGlove' ),
			"group"         => __( 'Icon', 'SuperiorGlove' ),
		),
		
		
		array(
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __( "Box Colour", 'SuperiorGlove' ),
			"param_name"		=> "box_color",
			"description"		=> __( "Select a Color", 'SuperiorGlove' ),
			"value"			=> array(
				__( "None", "SuperiorGlove" )		=> "normal",
				__( "red", "SuperiorGlove" )		=> "red",
				__( "green", "SuperiorGlove" )		=> "green",
				__( "blue", "SuperiorGlove" )		=> "blue",
				__( "purple", "SuperiorGlove" )		=> "purple",
				__( "orange", "SuperiorGlove" )		=> "orange",
				__( "pink", "SuperiorGlove" )		=> "pink",
				__( "yellow", "SuperiorGlove" )		=> "yellow",
				__( "brown", "SuperiorGlove" )		=> "brown",
				__( "white with border", "SuperiorGlove" )		=> "white_border",
			),
			"group"		=> __( 'Icon', 'SuperiorGlove' ),
		),	
		
		
		array(
			"type"		=> 'checkbox',
			"heading"	=> __("Overwrite Icon Color", "SuperiorGlove"),
			"param_name"	=> "has_icon_color",
			"value"		=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
			"description"	=> __("If not checked Icon will inherit your main theme color",	"SuperiorGlove"),
			"group"		=> __( 'Icon', 'SuperiorGlove' ),
		),				
		array(
			"type"		=> "colorpicker",
			"heading"	=> "Icon Color",
			"param_name"	=> "icon_color",
			"value"		=> "#333333",
			"group"		=> __( 'Icon', 'SuperiorGlove' ),
			"dependency"	=> Array( 'element'	=> "has_icon_color", 'not_empty' => true ),				
		),				
		array(
			"type" => "textfield",
			"heading" => __("URL Link", "SuperiorGlove"),
			"param_name" => "href",
			"value" => "",
			"description" => __("Enter a link if you want one. Don't forget the http:// in front.", "SuperiorGlove"),
			"group"		=> __( 'Link', 'SuperiorGlove' ),	
		),
		array(
			"type" => "dropdown",
			"heading" => __("Target", "SuperiorGlove"),
			"param_name" => "target",
			"value" => array('_self','_blank'),
			"description" => __("Pick '_blank' if you want the link to open in a new tab.", "SuperiorGlove"),
			"group"		=> __( 'Link', 'SuperiorGlove'),	
		),				

   )
));
