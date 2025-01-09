<?php

/**
	Icon Shortcode - part of the Theme Base -> shortcodes.php
**/



// Map Shortcode in Visual Composer
vc_map( array(
	"name"		=> "SuperiorGlove Icon",
	"base"		=> "boc_icon",
	"icon"		=> "boc_icon",
	"category" 	=> "SuperiorGlove Shortcodes",
	"weight"	=> 74,
	"params"	=> array(
		array(
			"type"          => "iconpicker",
			"heading"       => "Icon",
			"param_name"    => "icon",
			"admin_label"   => true,
			"settings" => array(
				'type' 		=> 'ogsicons',
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'description' 	=> __( 'Select icon from library.', 'SuperiorGlove' ),
		),
		array(
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __( "Icon Size", 'SuperiorGlove' ),
			"param_name"	=> "size",
			"description"	=> __( "Select an icon size.", 'SuperiorGlove' ),
			"value"			=> array(
				__( "Tiny", "SuperiorGlove" )		=> "tiny",
				__( "Small", "SuperiorGlove")		=> "small",
				__( "Normal", "SuperiorGlove" )		=> "normal",
				__( "Large", "SuperiorGlove" )		=> "large",
				__( "Huge", "SuperiorGlove" )		=> "huge",
			),
			"std"			=> "normal",
		),
		array(
			"type"		=> "dropdown",
			"heading"	=> "Icon Position",
			"param_name"	=> "icon_position",
			"value"		=> array(
				"Left"	=> "left",
				"Center"	=> "center",
				"Right"	=> "right",
			),
			"std"			=> "left",
			"description"	=> "Select your icon position",
		),
		array(
			"type"		=> "colorpicker",
			"heading"	=> "Icon Color",
			"param_name"	=> "icon_color",
			"value"		=> "#333333",
		),
		array(
			"type"		=> 'checkbox',
			"heading"	=> __("Add Background Color?", "SuperiorGlove"),
			"param_name"	=> "has_icon_bg",
			"description"	=> __("If selected, your icon will have a background color", "SuperiorGlove"),
			"value"		=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
		),
		array(
			"type"		=> "colorpicker",
			"heading"	=> "Icon Background",
			"param_name"	=> "icon_bg",
			"value"		=> "#ffffff",
			"dependency"	=> Array( 'element'	=> "has_icon_bg", 'not_empty' => true ),
		),
		array(
			"type"		=> "colorpicker",
			"heading"	=> "Icon Background Border",
			"param_name"	=> "icon_bg_border",
			"value"		=> "#ffffff",
			"dependency"	=> Array( 'element'	=> "has_icon_bg", 'not_empty' => true ),
		),
		array(
			"type"			=> "textfield",
			"class"			=> "",
			"heading"		=> __( "Border Radius", 'SuperiorGlove' ),
			"param_name"		=> "border_radius",
			"value"			=> "100%",
			"description"		=> __( "Change the background border radius/roundness (px/%).", 'SuperiorGlove' ),
			"dependency"	=> Array( 'element'	=> "has_icon_bg", 'not_empty' => true ),
		),
		array(
			"type"		=> "textfield",
			"heading"	=> "Margin Top",
			"param_name"	=> "margin_top",
			"value"		=> "",
			"description"	=> "Add a top margin if you want one. For example (10px)",			
		),
		array(
			"type"		=> "textfield",
			"heading"	=> "Margin Bottom",
			"param_name"	=> "margin_bottom",
			"value"		=> "",
			"description"	=> "Add a bottom margin if you want one. For example (10px)",			
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
			"type" => "textfield",
			"heading" => __("Extra class name", 'SuperiorGlove'),
			"param_name" => "css_classes",
			"value" => "",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'SuperiorGlove'),
		),				
	)
));
