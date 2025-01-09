<?php



/**

	Full Width Slider Image

**/



// Register Shortcode

if( ! function_exists( 'shortcode_boc_full_back' ) ) {

	function shortcode_boc_full_back( $atts, $content = null ) {

		 global $myscript;

		$atts = vc_map_get_attributes('boc_full_back', $atts );

		extract( $atts );	

		// Adding a check for VC picture added

		$img = '';

		if($picture_url){

			$vc_image = wp_get_attachment_image_src($picture_url,'full');
      $img = $vc_image;

		}


		$str = '<div class="vc_row wpb_row vc_inner vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12 vc_col-has-fill"><div class="vc_column-inner"><div class="wpb_wrapper" style="background-image: url('.$img[0].') !important; background-position: center !important; background-repeat: no-repeat !important;
background-size: cover !important;"><div class="mobile-spacer spacer-604ffb2062f6e" data-id="604ffb2062f6e" data-height="760" data-height-mobile="600" data-height-tab="560" data-height-tab-portrait="460" data-height-mobile-landscape="360" style="clear:both;display:block;"></div></div></div></div></div>';


					
		return $str;

	}

	

	add_shortcode('boc_full_back', 'shortcode_boc_full_back');

}



// Map Shortcode in Visual Composer

vc_map( array(

   "name" => __("Full Width Slider Image", 'SuperiorGlove'),

   "description" => __("Full Width Background Image for Slider.  Used on About Us Page.", 'SuperiorGlove'),

   "base" 	=> "boc_full_back",

   "category" => "SuperiorGlove Shortcodes",

   "icon" 	=> "boc_full_back",

   "weight"	=> 64,

   "params" => array(

		array(

			"type" => "attach_image",

			"heading" => __("Picture REQUIRED", 'SuperiorGlove'),

			"param_name" => "picture_url",

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