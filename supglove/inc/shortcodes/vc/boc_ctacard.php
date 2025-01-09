<?php



/**

	Priority CTA Block with Pic and Dots

**/

 

// Register Shortcode

if( ! function_exists( 'shortcode_boc_safetypriority' ) ) {

	function shortcode_boc_safetypriority( $atts, $content = null ) {

		 global $myscript;

		$atts = vc_map_get_attributes('boc_safetypriority', $atts );

		extract( $atts );	

		// Adding a check for VC picture added

		$img = '';

		if($picture_url){

			$vc_image = wp_get_attachment_image_src($picture_url,'full');
      $img = $vc_image;

		}


		$str = '							
						
						<div class="right-side-image withtext '.$css_classes.'"> 
<h6 style="margin: 10px 0;"><img src="'.$img[0].'" alt="" style="margin-right: 5px;"/>'.do_shortcode(wp_kses_post($title)).'</h6>
<h3 style="margin: 0px;">'.do_shortcode(wp_kses_post($subtitle)).'</h3>
<p class="lead" style="color: #939396;">'.do_shortcode($content).' </p><a href="'.do_shortcode(wp_kses_post($ctaurl)).'" class="buttonogs btn_small btn_dark2   " target="_self" rel="noopener"><span>'.do_shortcode(wp_kses_post($ctatext)).'</span></a></div >';
						
						
						
						
						
						
		return $str;

	}

	

	add_shortcode('boc_safetypriority', 'shortcode_boc_safetypriority');

}



// Map Shortcode in Visual Composer

vc_map( array(

   "name" => __("Styled CTA", 'SuperiorGlove'),

   "description" => __("	Priority CTA Block", 'SuperiorGlove'),

   "base" 	=> "boc_safetypriority",

   "category" => "SuperiorGlove Shortcodes",

   "icon" 	=> "boc_safetypriority",

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

			"description" => __("Enter a Heading", 'SuperiorGlove'),

		),
		
		
				array(

			"type" => "textfield",

			"heading" => __("Subtitle Heading", 'SuperiorGlove'),

			"param_name" => "subtitle",

			"admin_label"=> true,

			"std" => "",

			"description" => __("Enter a Subtitle Heading", 'SuperiorGlove'),

		),
		
		
				array(

			"type" => "textfield",

			"heading" => __("CTA Link", 'SuperiorGlove'),

			"param_name" => "ctaurl",

			"admin_label"=> true,

			"std" => "",

			"description" => __("Enter FULL URL", 'SuperiorGlove'),

		),
		
		
		
				array(

			"type" => "textfield",

			"heading" => __("CTA Text", 'SuperiorGlove'),

			"param_name" => "ctatext",

			"admin_label"=> true,

			"std" => "",

			"description" => __("CTA Button Text", 'SuperiorGlove'),

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