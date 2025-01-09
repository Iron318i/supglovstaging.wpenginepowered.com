<?php

/**
	Heading Shortcode
**/

// Register Shortcode
if( ! function_exists( 'boc_shortcode_heading' ) ) {
	function boc_shortcode_heading( $atts, $content = null ) {

		$atts = vc_map_get_attributes('boc_heading', $atts );
		extract( $atts );


		$custom_styles = array();
		
		if( $margin_bottom ) {
			$custom_styles[] = 'margin-bottom: '. $margin_bottom .';';
		}
		if ( $margin_top ) {
			$custom_styles[] = 'margin-top: '. $margin_top .';';
		}

		if ( $alignment ) {
			if($alignment == "left"){
				// $custom_styles[] = 'text-align: left;';
				$css_classes .= ' al_left ';
			}elseif($alignment == "center"){
				// $custom_styles[] = 'text-align: center;';
				$css_classes .= ' center ';
			}elseif($alignment == "right"){
				// $custom_styles[] = 'text-align: right;';
				$css_classes .= ' al_right ';
			}
		}

		if ( $color ) {
			$custom_styles[] = 'color: '. $color .';';
		}
		if ( $font_size ) {
			$custom_styles[] = 'font-size: '. $font_size .';';
			if($html_element == 'div' || $html_element == 'p'){
				$custom_styles[] = 'line-height: 1.7em;';
			}
		}

		
		if ( $subheadmargin ) {
			$css_classes .= ' boc_subheadmargin';
		}
		

		$custom_styles = implode('', $custom_styles);

		if ( $custom_styles ) {
			$custom_styles = wp_kses( $custom_styles, array() );
			$custom_styles = ' style="' . esc_attr($custom_styles) . '"';
		}
		
		
		
		if($fakehtag && ( ($html_element != "p" ) || ($html_element != "div" )  )  ){
			return '<div class="boc_heading ' .  $html_element .'-look '     . esc_attr($css_classes) .' " ' .$custom_styles.'><span>'.do_shortcode($content).'</span></div>';
		}else{
			return '<'.wp_kses_post($html_element).' class="boc_heading '. esc_attr($css_classes) .' " ' .$custom_styles.'><span>'.do_shortcode($content).'</span></'.wp_kses_post($html_element).'>';
		}
	}

	add_shortcode('boc_heading', 'boc_shortcode_heading');
}



// Map Shortcode in Visual Composer
vc_map( array(
	"name" 		=> __("SuperiorGlove Heading", 'SuperiorGlove'),
	"base" 		=> "boc_heading",
	"icon" 		=> "boc_heading",
	"category" 	=> "SuperiorGlove Shortcodes",
	"weight"	=> 76,
	"params" => array(
		array(
		 "type" 		=> "textfield",
		 "heading" 		=> "Text",
		 "param_name"	=> "content",
		 "admin_label"	=> true,
		 "value" 		=> "SuperiorGlove <strong>Heading</strong>  Text",
		 "description"=> "Heading Text. Wrap in a &lt;strong&gt; tag for accent color of heading elements H1-H5"
		),
		array(
			"type"		=> "dropdown",
			"heading"	=> "HTML Element",
			"param_name"	=> "html_element",
			"admin_label"	=> true,
			"value"		=> array(
				"h1"	=> "h1",
				"h2"	=> "h2",
				"h3"	=> "h3",
				"h4"	=> "h4",
				"h5"	=> "h5",
				"h6"	=> "h6",
				"div"=> "div",
				"p"	=> "p",
			),
			"std"         => "h2",
			"description"	=> "Select your Heading element type (H1 - H5, etc). To change default design of the element click on Design tab",
		),
		array(
			"type"			=> 'checkbox',
			"heading" 		=> __("Fake H1, H2, etc...", 'SuperiorGlove'),
			"param_name" 	=> "fakehtag",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
			"description" 	=> __("If selecting an H tag style, then this will actually fake the tag useful for SEO purposes if you don't want to have too many H tags on the page.", 'SuperiorGlove')
		),	
		
		
		
		array(
			"type"		=> "dropdown",
			"heading"	=> "Alignment",
			"param_name"	=> "alignment",
			"value"		=> array(
				"Left"	=> "left",
				"Center"=> "center",
				"Right"	=> "right",
			),
			"std"         => "left",
			"description"	=> "Select your Heading alignment",
		),
		array(
			"type" 		=> "textfield",
			"heading" 	=> "Extra class name",
			"param_name" 	=> "css_classes",
			"description"=> "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file"
		),			
		array(
			"type"		=> "colorpicker",
			"heading"	=> "Heading Color",
			"param_name"	=> "color",
			"value"		=> "#58585A",
			"description"	=> "Select your Heading text color. Defaults to dark grey (#333)",
			"group"		=> "Design",	
		),
		array(
			"type"		=> "textfield",
			"heading"	=> "Font size",
			"param_name"	=> "font_size",
			"description"	=> "Overwrite default font-size (px), leave out empty for default value of the HTML element you picked",
			"group"		=> "Design",
		),
		array(
			"type"			=> 'checkbox',
			"heading" 		=> __("Adjust top margin for Subheading?", 'SuperiorGlove'),
			"param_name" 	=> "subheadmargin",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'yes' ),
			"description" 	=> __("When using Oswald font, as your main title then check this.", 'SuperiorGlove'),
			"group"			=> "Design",
		),					
		array(
			"type"			=> "textfield",
			"heading"		=> "Margin Top",
			"param_name"	=> "margin_top",
			"std"			=> "0px",
			"description"	=> "Overwrite default top margin (px), leave out empty for default value of the HTML element you picked",
			"group"			=> "Design",
		),
		array(
			"type"			=> "textfield",
			"heading"		=> "Margin Bottom",
			"param_name"	=> "margin_bottom",
			"std"			=> "20px",
			"description"	=> "Overwrite default bottom margin (px), leave out empty for default value of the HTML element you picked",
			"group"			=> "Design",				
		),
   )
));
