<?php
/*
* Add-on Name: Adjustable Spacer for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists("SuperiorGlove_Spacer")){
	class SuperiorGlove_Spacer{
		function __construct(){
			add_action("init",array($this,"artsmarket_spacer_init"));
			add_shortcode("artsmarket_spacer",array($this,"artsmarket_spacer_shortcode"));
		}
		function artsmarket_spacer_init(){
			if(function_exists("vc_map")){
				vc_map(
					array(
					   "name" => __("Responsive Spacer","SuperiorGlove"),
					   "base" => "artsmarket_spacer",
					   "class" => "vc_artsmarket_spacer",
					   "icon" => "boc_spacing",
					   "category" => "SuperiorGlove Shortcodes",
					   "description" => __("Adjust space between components.","SuperiorGlove"),
					   "params" => array(
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("<i class='dashicons dashicons-desktop'></i> Desktop", "SuperiorGlove"),
								"param_name" => "height",
								"admin_label" => true,
								"value" => 10,
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								"description" => __("Enter value in pixels", "SuperiorGlove"),
								//"edit_field_class" => "vc_col-sm-4 vc_column"
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("<i class='dashicons dashicons-tablet' style='transform: rotate(90deg);'></i> Tabs", "SuperiorGlove"),
								"param_name" => "height_on_tabs",
								"admin_label" => true,
								"value" => '',
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								//"description" => __("Enter value in pixels", "SuperiorGlove"),
								"edit_field_class" => "vc_col-sm-3 vc_column"
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("<i class='dashicons dashicons-tablet'></i> Tabs", "SuperiorGlove"),
								"param_name" => "height_on_tabs_portrait",
								"admin_label" => true,
								"value" => '',
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								//"description" => __("Enter value in pixels", "SuperiorGlove"),
								"edit_field_class" => "vc_col-sm-3 vc_column"
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("<i class='dashicons dashicons-smartphone' style='transform: rotate(90deg);'></i> Mobile", "SuperiorGlove"),
								"param_name" => "height_on_mob_landscape",
								"admin_label" => true,
								"value" => '',
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								//"description" => __("Enter value in pixels", "SuperiorGlove"),
								"edit_field_class" => "vc_col-sm-3 vc_column"
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("<i class='dashicons dashicons-smartphone'></i> Mobile", "SuperiorGlove"),
								"param_name" => "height_on_mob",
								"admin_label" => true,
								"value" => '',
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								//"description" => __("Enter value in pixels", "SuperiorGlove"),
								"edit_field_class" => "vc_col-sm-3 vc_column"
							),
						)
					)
				);
			}
		}
		function artsmarket_spacer_shortcode($atts){
			//wp_enqueue_script('artsmarket-custom');
			$height = $output = $height_on_tabs = $height_on_mob = '';
			extract(shortcode_atts(array(
				"height" => "",
				"height_on_tabs" => "",
				"height_on_tabs_portrait" => "",
				"height_on_mob" => "",
				"height_on_mob_landscape" => ""
			),$atts));
			if($height_on_mob == "" && $height_on_tabs == "")
				$height_on_mob = $height_on_tabs = $height;
			$style = 'clear:both;';
			$style .= 'display:block;';
			$uid = uniqid();
			$output .= '<div class="mobile-spacer spacer-'.$uid.'" data-id="'.$uid.'" data-height="'.$height.'" data-height-mobile="'.$height_on_mob.'" data-height-tab="'.$height_on_tabs.'" data-height-tab-portrait="'.$height_on_tabs_portrait.'" data-height-mobile-landscape="'.$height_on_mob_landscape.'" style="'.$style.'"></div>';
			return $output;
		}
	} // end class
	new SuperiorGlove_Spacer;
	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_artsmarket_spacer extends WPBakeryShortCode {
	    }
	}
}