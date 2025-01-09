<?php



/**

	Side Img Featured Text

**/



// Register Shortcode

if( ! function_exists( 'shortcode_boc_flip_box' ) ) {

	function shortcode_boc_flip_box( $atts, $content = null ) {

		 global $myscript;

		$atts = vc_map_get_attributes('boc_flip_box', $atts );

		extract( $atts );	

		// Adding a check for VC picture added

		$img = '';

		if($picture_url){

			$vc_image = wp_get_attachment_image_src($picture_url,'full');
      $img = $vc_image;

		}


		$str = '	<div class="cardmargin"><div class="card '.$css_classes.'">
						    <div class="cardbeforeimage" style="background-image: url('.$img[0].');"></div>
						    <div class="content">
						      <h5 class="title">'.do_shortcode(wp_kses_post($title)).'</h5>
						      <div class="copy">'.do_shortcode($content).'</div>
						    </div>
						</div></div>';
						
		return $str;

	}

	

	add_shortcode('boc_flip_box', 'shortcode_boc_flip_box');

}



// Map Shortcode in Visual Composer

vc_map( array(

   "name" => __("Animated Glove Card", 'SuperiorGlove'),

   "description" => __("Animated Card that Reveals Text", 'SuperiorGlove'),

   "base" 	=> "boc_flip_box",

   "category" => "SuperiorGlove Shortcodes",

   "icon" 	=> "boc_flip_box",

   "weight"	=> 64,

   "params" => array(

		array(

			"type" => "attach_image",

			"heading" => __("Picture REQUIRED", 'SuperiorGlove'),

			"param_name" => "picture_url",

		),

		array(

			"type" => "textfield",

			"heading" => __("Heading", 'SuperiorGlove'),

			"param_name" => "title",

			"admin_label"=> true,

			"std" => "",

			"description" => __("Enter a Heading if you want one", 'SuperiorGlove'),

		),

		array(

			"type" 		=> "textarea_html",

			"heading" 	=> __("Text Below Title", 'SuperiorGlove'),

			"param_name" => "content",

			"value" 		=> __("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis.", 'SuperiorGlove'),

			"description"=> __("Enter the Featured text", 'SuperiorGlove'),

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