<?php



/**

	Side Img Featured Text

**/



// Register Shortcode

if( ! function_exists( 'shortcode_boc_floatpic' ) ) {

	function shortcode_boc_floatpic( $atts, $content = null ) {

		 global $myscript;

		$atts = vc_map_get_attributes('boc_floatpic', $atts );

		extract( $atts );	

		// Adding a check for VC picture added

		$img = '';

		if($picture_url){

			$vc_image = wp_get_attachment_image_src($picture_url,'full');
      $img = $vc_image;

		}


		if($round_img) {

			$css_classes .= " rightfloat";

		}
		
						
				$str =	'<div class="component-section-spacing imageWithOverlay '.$css_classes.'">    
					    <div class="component horiz-component" data-layout="text-left" data-skrollex data-sk-group data-sk-component>
					        <div class="image-pos-wrapper">
					            <div class="image-wrapper scaler-1181x580">    
					                <div class="image-mask scaler-child"><img class="scaler-child" src="'.$img[0].'" data-no-lazy/>
					                </div>
					            </div>
					        </div>
					        <div class="text tag-controls">
					            <div class="tag-controls-inner">
					                  <h3>'.do_shortcode(wp_kses_post($title)).'</h3>
					                <div class="lead">'.do_shortcode($content).'</div>

					            </div>    
					        </div>
						</div>
					</div>';
											
						
						
						
						
		return $str;

	}

	

	add_shortcode('boc_floatpic', 'shortcode_boc_floatpic');

}



// Map Shortcode in Visual Composer

vc_map( array(

   "name" => __("Floated Image Left or Right", 'SuperiorGlove'),

   "description" => __("Content with Floating Image", 'SuperiorGlove'),

   "base" 	=> "boc_floatpic",

   "category" => "SuperiorGlove Shortcodes",

   "icon" 	=> "boc_floatpic",

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

			"type"			=> 'checkbox',

			"heading" 		=> __("Float Image Right?", 'SuperiorGlove'),

			"param_name" 	=> "round_img",

			"value"			=> Array(__("Yes", "SuperiorGlove") => 'yes' ),

			"description" 	=> __("Set to Yes image will be on RIGHT", 'SuperiorGlove'),						

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