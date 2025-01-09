<?php



/**

	Side Img Featured Text

**/



// Register Shortcode

if( ! function_exists( 'shortcode_boc_animated_3_cards' ) ) {

	function shortcode_boc_animated_3_cards( $atts, $content = null ) {

		 global $myscript;

		$atts = vc_map_get_attributes('boc_animated_3_cards', $atts );

		extract( $atts );	

		// Adding a check for VC picture added

		$img1 = '';
		$img2 = '';
		$img3 = '';

		if($picture_url_one){
			$vc_image1 = wp_get_attachment_image_src($picture_url_one,'full');
      $img1 = $vc_image1;
		}
		
		if($picture_url_two){
			$vc_image2 = wp_get_attachment_image_src($picture_url_two,'full');
      $img2 = $vc_image2;
		}
		
		
	 if($picture_url_three){
			$vc_image3 = wp_get_attachment_image_src($picture_url_three,'full');
      $img3 = $vc_image3;
		}
		
		
					
						
			$str = '<div class="allboximages '.$css_classes.'">

						<figure class="box__image">
							<a href="'.$urlone.'"><img loading="lazy" class="boximg" 
									 src="'.$img1[0].'" alt="">
							<figcaption class="img__text">'.$titleone.'</figcaption></a>
						</figure>
						
						<figure class="box__image">
							<a href="'.$urltwo.'"><img loading="lazy" class="boximg" 
									 src="'.$img2[0].'" alt="">
							<figcaption class="img__text">'.$titletwo.'</figcaption></a>
						</figure>
						
						<figure class="box__image">
							<a href="'.$urlthree.'"><img loading="lazy" class="boximg" 
									 src="'.$img3[0].'" alt="">
							<figcaption class="img__text">'.$titlethree.'</figcaption></a>
						</figure>

					</div>


					<div class="boximgbut">
					<a href="/products/" class="buttonogs btn_small btn_white icon_pos_after hidden-xs " target="_self"><span>Browse All Products</span> <i class="icon-arrow-right "></i> </a>

					<a href="/products/" target="_self" class="buttonogs btn_small btn_dark2 visible-xs "><span>Browse All Products</span>  </a>

					</div>';
						
						
						
						
		return $str;

	}

	

	add_shortcode('boc_animated_3_cards', 'shortcode_boc_animated_3_cards');

}



// Map Shortcode in Visual Composer

vc_map( array(

   "name" => __("3 PICS Showcase", 'SuperiorGlove'),
   "description" => __("Animated Cards Triple", 'SuperiorGlove'),
   "base" 	=> "boc_animated_3_cards",
   "category" => "SuperiorGlove Shortcodes",
   "icon" 	=> "boc_animated_3_cards",
   "weight"	=> 64,
   
   
   
   /**** PIC 1 ***/ 
   "params" => array(

		array(
			"type" => "attach_image",
			"heading" => __("Picture 1", 'SuperiorGlove'),
			"param_name" => "picture_url_one",
		),

		array(
			"type" => "textfield",
			"heading" => __("Link One Text", 'SuperiorGlove'),
			"param_name" => "titleone",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Title for Pic One", 'SuperiorGlove'),
		),

		array(
			"type" => "textfield",
			"heading" => __("Link One URL", 'SuperiorGlove'),
			"param_name" => "urlone",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Url for Link One", 'SuperiorGlove'),
		),
		
		
		
		   /**** PIC 2 ***/ 

		array(
			"type" => "attach_image",
			"heading" => __("Picture 2", 'SuperiorGlove'),
			"param_name" => "picture_url_two",
		),

		array(
			"type" => "textfield",
			"heading" => __("Link Two Text", 'SuperiorGlove'),
			"param_name" => "titletwo",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Title for Pic Two", 'SuperiorGlove'),
		),

		array(
			"type" => "textfield",
			"heading" => __("Link Two URL", 'SuperiorGlove'),
			"param_name" => "urltwo",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Url for Link Two", 'SuperiorGlove'),
		),
		
		
		  /**** PIC 2 ***/ 
		  
		
		array(
			"type" => "attach_image",
			"heading" => __("Picture 3", 'SuperiorGlove'),
			"param_name" => "picture_url_three",
		),

		array(
			"type" => "textfield",
			"heading" => __("Link Three Text", 'SuperiorGlove'),
			"param_name" => "titlethree",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Title for Pic Three", 'SuperiorGlove'),
		),

		array(
			"type" => "textfield",
			"heading" => __("Link Three URL", 'SuperiorGlove'),
			"param_name" => "urlthree",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Url for Link Three", 'SuperiorGlove'),
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